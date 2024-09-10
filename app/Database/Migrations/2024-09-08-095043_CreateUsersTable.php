<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        // Create the users table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'superadmin' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
            ],
            'role_id' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false,
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => false,
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => false,
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'profile_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => false,
            ],
            'record_status' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'deleted' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => null,
            ],
            'added_by' => [
                'type'       => 'INT',
                'null'       => false,
                'default'    => 1,
            ],
            'modified_by' => [
                'type'       => 'INT',
                'null'       => false,
                'default'    => 1,
            ],
        ]);

        // Set primary key
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('users');

        // Insert default superadmin user
        $data = [
            'superadmin'   => 1,
            'role_id'      => 1, // Assuming role_id 1 is for superadmin
            'phone'        => '1234567890',
            'first_name'   => 'Super',
            'last_name'    => 'Admin',
            'full_name'    => 'Super Admin',
            'email'        => 'superadmin@example.com',
            'password'     => password_hash('P@$$w0rd', PASSWORD_DEFAULT), // Securely hash the password
            'profile_image' => 'default.jpg',
            'record_status' => 1,
            'deleted'      => null,
            'added_by'     => 1,
            'modified_by'  => 1,
        ];

        // Insert into database
        $this->db->table('users')->insert($data);
    }

    public function down()
    {
        // Drop the users table
        $this->forge->dropTable('users');
    }
}
