<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insert([
            'name' => 'teszt',
            'email' => 'teszt@teszt.hu',
            'password' => bcrypt('teszt'),
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
        ]);
		
		DB::table('todo')->insert([
            'cim' => 'Első feladat',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et elementum quam. Vestibulum eget lorem pretium, dictum tellus vitae, commodo dolor.',
            'user_id' => \App\User::first()->id,
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
        ]);
		
		DB::table('todo')->insert([
            'cim' => 'Lezárt feladat',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et elementum quam. Vestibulum eget lorem pretium, dictum tellus vitae, commodo dolor.',
            'user_id' => \App\User::first()->id,
			'status' => '1',
			'status_date' => \Carbon\Carbon::now(),
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
