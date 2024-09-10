<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSuperadminRoleToRolesTable extends Migration
{
    public function up()
    {
        // Insert the 'superadmin' role into the roles table
        $data = [
            'name' => 'superadmin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Using the query builder to insert data
        $this->db->table('roles')->insert($data);
    }

    public function down()
    {
        // Remove the 'superadmin' role if migration is rolled back
        $this->db->table('roles')->where('name', 'superadmin')->delete();
    }
}
