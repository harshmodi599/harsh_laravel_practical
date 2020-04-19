<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class UserSkill extends Model{
    public $timestamps = false;
    protected $fillable = [
        'user_id','skill_id'
    ];

    /**
     * @param $user_id
     * @param $user_skills
     *
     * @throws Throwable
     */
    public static function addUserSkills($user_id, $user_skills){
        try {
        	UserSkill::where('user_id', $user_id)->delete();
        	foreach ($user_skills as $user_skill) {
        		$skill = new UserSkill();
        		$skill->user_id = $user_id;
        		$skill->skill_id = $user_skill;
        		$skill->save();
        	}
        } catch (Throwable $t) {
            throw $t;
        }
    }
}
