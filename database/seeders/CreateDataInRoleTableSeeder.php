<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Sentinel;

class CreateDataInRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('throttle')->truncate();

        $rows = [
            [
                'name' => 'Administrador',
                'slug' => 'administrator',
                'permissions' => [
                    'read' => true,
                    'create' => true,
                    'update' => true,
                    'delete' => true,
                ]
            ],
            [
                'name' => 'Cliente',
                'slug' => 'client',
                'permissions' => [
                    'read' => true,
                    'create' => false,
                    'update' => false,
                    'delete' => false,
                ]
            ]
        ];

        foreach( $rows as $row ) :
			$role = Sentinel::getRoleRepository()->createModel()->create( $row );
        endforeach;
    }
}
