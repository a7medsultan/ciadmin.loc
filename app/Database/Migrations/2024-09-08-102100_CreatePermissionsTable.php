<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        // Define the permission table fields
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'record_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => false,
            ],
            'delete_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
            ],
            'date_added' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'date_modified' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'added_by' => [
                'type'    => 'INT',
                'null'    => true,
                'default' => null,
            ],
            'modified_by' => [
                'type'    => 'INT',
                'null'    => true,
                'default' => null,
            ],
        ]);

        // Set the primary key
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('permissions');
    }

    public function down()
    {
        // Drop the permission table
        $this->forge->dropTable('permissions');
    }
}
