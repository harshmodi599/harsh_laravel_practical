<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SkillRequest;
use App\Skill;
use DataTables;
use Throwable;
use Exception;

class SkillController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        try {
            return view('skill.index');
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
            return view('skill.create');
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
    public function store(SkillRequest $request){
        try {
            $skills = $request->all();
            Skill::create($skills);
            return redirect()->route('index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(){
        try {
            $skill_list = Skill::latest()->get();
            return Datatables::of($skill_list)
                    ->addIndexColumn()
                    ->addColumn('action', function ($skill_list) {
                        return '<h6><a href="skill/edit/'. $skill_list->id .'" class="btn btn-primary btn-sm">Edit</a> | <a href="skill/delete/'. $skill_list->id .'" class="btn btn-danger btn-sm">Delete</a></h6>';
                    })
                    ->rawColumns(['action'])
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
            $skill_data = Skill::find($id);
            return view('skill.create', compact('skill_data'));
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
    public function update(SkillRequest $request, $id){
        try {
            $skills = $request->all();
            $update_skill = Skill::find($id);
            $update_skill->update($skills);
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
            Skill::find($id)->delete();
            return redirect()->route('index');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
