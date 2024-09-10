<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToUsersTable extends Migration
{
    public function up()
    {
        // Define the new columns to be added
        $fields = [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        // Add the columns to the 'users' table
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        // Remove the columns if the migration is rolled back
        $this->forge->dropColumn('users', ['created_at', 'updated_at']);
    }
}
