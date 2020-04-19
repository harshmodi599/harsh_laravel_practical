<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class UserRelation extends Model{
    protected $fillable = [
        'user_id','skill_id'
    ];

    /**
     * @param $user_id
     * @param $request_id
     * @param $status
     *
     * @throws Throwable
     */
    public static function addUserRelation($user_id, $request_id, $status='pending'){
        try {
    		$user_relation = new UserRelation();
    		$user_relation->send_by = $user_id;
    		$user_relation->send_to = $request_id;
            $user_relation->status = $status;
    		$user_relation->save();
        } catch (Throwable $t) {
            throw $t;
        }
    }

    /**
     * @param $user_id
     * @param $send_id
     *
     * @throws Throwable
     */
    public static function checkFriend($user_id, $send_id){
        try {
            return UserRelation::where('send_by', $user_id)->where('send_to', $send_id)->exists();
        } catch (Throwable $t) {
            throw $t;
        }
    }

    /**
     * @param $user_id
     * @param $send_id
     *
     * @throws Throwable
     */
    public static function cancelUserRequest($user_id, $send_id){
        try {
            return UserRelation::where('send_by', $user_id)->where('send_to', $send_id)->delete();
        } catch (Throwable $t) {
            throw $t;
        }
    }
    
}
