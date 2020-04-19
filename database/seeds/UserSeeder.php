<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_id = DB::table('users')->insertGetId([
            'name' => 'admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $users_details = DB::table('user_details')->insertGetId([
            'user_id' => $users_id,
            'user_name' => 'adminadmin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'mobile' => '9724811513',
            'gender' => 'male',
            'photo' => '1587201765.jpg',
        ]);

        $skill_id = DB::table('skills')->insertGetId([
        	'name' => 'Laravel',
        ]);

        $user_skill = DB::table('user_skills')->insertGetId([
        	'user_id' => $users_id,
        	'skill_id' => $skill_id,
        ]);
    }
}
