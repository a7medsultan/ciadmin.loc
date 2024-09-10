<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesPermissionsTable extends Migration
{
    public function up()
    {
        // Define the roles_permissions table fields
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'permission_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id', true);

        // Add foreign key constraints for role_id and permission_id (if roles and permissions tables exist)
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('roles_permissions');
    }

    public function down()
    {
        // Drop the roles_permissions table
        $this->forge->dropTable('roles_permissions');
    }
}
