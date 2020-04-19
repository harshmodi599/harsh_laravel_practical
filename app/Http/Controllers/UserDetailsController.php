<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserDetailsRequest;
use App\UserDetail;
use App\Skill;
use App\UserSkill;
use App\UserRelation;
use DataTables;
use Throwable;
use Exception;
use DB;
use Hash;

class UserDetailsController extends Controller{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try {
            $user_count = UserDetail::where('user_id', \Auth::user()->id)->count();
            return view('user_details.index', compact('user_count'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        try {
            $skill_list = Skill::select('id', 'name')->latest()->get();
            return view('user_details.create', compact('skill_list'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserDetailsRequest $request){
        try {
            $user_details = $request->all();
            $user_details['user_id'] = \Auth::user()->id;
            $user_details['photo'] = '';
            if ($request->gender) {
                $user_details['gender'] = $request->gender;    
            }else{
                $user_details['gender'] = 0;    
            }
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoname = time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('public', $photoname);
                $user_details['photo'] = $photoname;
            }
            UserSkill::addUserSkills($user_details['user_id'], $user_details['skill']);
            UserDetail::create($user_details);
            return redirect()->route('index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(){
        try {
            $user_details_list = UserDetail::where('user_id', \Auth::user()->id)->latest()->get();
            return Datatables::of($user_details_list)
                    ->addIndexColumn()
                    ->addColumn('photo', function ($user_details_list) {
                        $url= asset('storage/'.$user_details_list->photo);
                        return '<img src="'.$url.'" border="0" width="60" align="center" />';
                    })
                    ->addColumn('action', function ($user_details_list) {
                        return '<h6><a href="user_details/edit/'. $user_details_list->id .'" class="btn btn-primary btn-sm">Edit</a> | <a href="user_details/delete/'. $user_details_list->id .'" class="btn btn-danger btn-sm">Delete</a></h6>';
                    })
                    ->rawColumns(['photo','action'])
                    ->make(true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        try {
            $user_id = \Auth::user()->id;
            $user_details_data = UserDetail::find($id);
            $skill_list = Skill::select('id', 'name')->latest()->get();        
            $user_skills = UserSkill::select('skill_id')->where('user_id', $user_id)->pluck('skill_id');
            $user_skills = json_decode($user_skills);
            return view('user_details.create', compact('user_details_data', 'skill_list', 'user_skills'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserDetailsRequest $request, $id){
        try {
            $user_details = $request->all();
            $user_id = \Auth::user()->id;
            $user_detail = UserDetail::find($id);
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoname = time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('public', $photoname);
                $user_details['photo'] = $photoname;
            }
            $user_detail->update($user_details);
            UserSkill::addUserSkills($user_id, $user_details['skill']);
            return redirect()->route('index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            UserDetail::find($id)->delete();
            return redirect()->route('index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userSkillIndex(){
        try {
            return view('user_details.user_skill');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userSkill(){
        try {
            $user_id = \Auth::user()->id;
            $user_details_list = UserDetail::join('user_skills', 'user_details.user_id', '=', 'user_skills.user_id')
            ->select('user_details.id', 'user_details.user_id', 'user_details.user_name', 'user_details.email', 'user_details.mobile', 'user_details.gender', 'user_details.photo')
            ->whereRaw('user_skills.skill_id IN (SELECT us.skill_id FROM user_skills AS us WHERE us.user_id = "'.$user_id.'")')
            ->where('user_details.user_id', '!=', $user_id)
            ->groupBy('user_details.id', 'user_details.user_id', 'user_details.user_name', 'user_details.email', 'user_details.mobile', 'user_details.gender', 'user_details.photo')
            ->orderBy('user_details.id', 'desc')
            ->get();
            return Datatables::of($user_details_list)
                    ->addIndexColumn()
                    ->addColumn('photo', function ($user_details_list) {
                        $url= asset('storage/'.$user_details_list->photo);
                        return '<img src="'.$url.'" border="0" width="60" align="center" />';
                    })
                    ->addColumn('action', function ($user_details_list) {
                        $check_request = UserRelation::checkFriend(\Auth::user()->id, $user_details_list->user_id);
                        if($check_request){
                            return '<h6><a href="/user_details/cancel_request/'. $user_details_list->user_id .'" class="btn btn-primary btn-sm">Cancel Request</a>';
                        }else{
                            return '<h6><a href="/user_details/friend_request/'. $user_details_list->user_id .'" class="btn btn-primary btn-sm">Add Friend</a>';
                        }
                    })
                    ->rawColumns(['photo','action'])
                    ->make(true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the pending resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function friendRequest($id){
        try {
            UserRelation::addUserRelation(\Auth::user()->id, $id, 'pending');
            return redirect()->route('user_skill_index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Cancel the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancelRequest($id){
        try {
            UserRelation::cancelUserRequest(\Auth::user()->id, $id, 'pending');
            return redirect()->route('user_skill_index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the requested friends resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myFridendRequest(){
        try {
            return view('user_details.friend_request');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get the requested friends resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function friendRequestList(){
        try {
            $friend_request_list = UserRelation::join('user_details', 'user_relations.send_by', '=', 'user_details.user_id')
                ->select('user_details.user_id', 'user_details.first_name', 'user_details.last_name', 'user_details.id', 'user_details.photo', 'user_relations.created_at')
                ->where('user_relations.send_to', \Auth::user()->id)->where('user_relations.status', 'pending')->latest()->get();

            return Datatables::of($friend_request_list)
                ->addIndexColumn()
                ->addColumn('photo', function ($friend_request_list) {
                    $url= asset('storage/'.$friend_request_list->photo);
                    return '<img src="'.$url.'" border="0" width="60" align="center" />';
                })
                ->addColumn('action', function ($friend_request_list) {
                    return '<h6><a href="/user_details/friend_action/'. $friend_request_list->user_id .'/accept " class="btn btn-primary btn-sm">Accept</a> | <a href="/user_details/friend_action/'. $friend_request_list->user_id .'/reject" class="btn btn-danger btn-sm">Reject</a></h6>';
                })
                ->rawColumns(['photo','action'])
                ->make(true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the login user friend list.
     *
     * @return \Illuminate\Http\Response
     */
    public function myFriends(){
        try {
            return view('user_details.friend_list');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get the login user friend list.
     *
     * @return \Illuminate\Http\Response
     */
    public function friendList(){
        try {
            $friend_list = UserRelation::join('user_details', 'user_relations.send_by', '=', 'user_details.user_id')
                ->select('user_details.user_id', 'user_details.first_name', 'user_details.last_name', 'user_details.id', 'user_details.photo', 'user_relations.created_at')
                ->where('user_relations.send_to', \Auth::user()->id)->where('user_relations.status', 'accept')->latest()->get();

            return Datatables::of($friend_list)
                ->addIndexColumn()
                ->addColumn('photo', function ($friend_list) {
                    $url= asset('storage/'.$friend_list->photo);
                    return '<img src="'.$url.'" border="0" width="60" align="center" />';
                })
                ->addColumn('action', function ($friend_list) {
                    return '<h6><a href="/user_details/friend_action/'. $friend_list->user_id .'/unfriend " class="btn btn-primary btn-sm">Unfriend</a>';
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Unfriend the specified resource.
     *
     * @param  int  $id
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function friendAction($id, $status){
        try {
            UserRelation::where('send_by', $id)->where('send_to', \Auth::user()->id)->update(['status' => $status]);
            if($status == 'unfriend'){
                return redirect()->route('my_friend');
            }else{
                return redirect()->route('my_friend_request');
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
