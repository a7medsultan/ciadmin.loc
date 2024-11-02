<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFacilitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'state_id'            => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'name'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => false,
            ],
            'summary'       => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'phone'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => true,
            ],
            'address'       => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'email'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'image'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'logo'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'location_link' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'created_by'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'modified_by'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'created_at'    => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at'    => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'deleted'       => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 0,
                'null'           => true,
            ],
        ]);

        // Set the primary key
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('facilities');
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('facilities');
    }
}
