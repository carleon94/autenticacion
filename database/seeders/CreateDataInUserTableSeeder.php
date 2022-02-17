<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Sentinel;

class CreateDataInUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
		DB::table('role_users')->truncate();
		DB::table('activations')->truncate();
		DB::table('reminders')->truncate();
		DB::table('persistences')->truncate();

		$rows = [
			[
				'email' => 'admin@hotmail.com',
				'password' => '1234',
				'first_name' => 'Carlos',
				'last_name' => 'León',
				'role_slug' => 'administrator',
			],
			[
				'email' => 'cliente@hotmail.com',
				'password' => '1234',
				'first_name' => 'Cliente',
				'last_name' => 'Test',
				'role_slug' => 'client',
			],
		];

		foreach( $rows as $row ) :
            $role = Sentinel::findRoleBySlug($row['role_slug']);
			unset( $row['role_slug'] );
			$user = Sentinel::registerAndActivate( $row );
			$user->roles()->attach( $role );
		endforeach;
    }
}
