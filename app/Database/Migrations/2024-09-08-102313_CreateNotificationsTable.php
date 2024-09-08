<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        // Define the notification table fields
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['email', 'sms'],
                'null'       => true,
                'default'    => null,
            ],
            'receivers' => [
                'type'       => 'TEXT',
                'null'       => false,
                'comment'    => 'comma separated user ids',
            ],
            'viewed_by' => [
                'type'       => 'TEXT',
                'null'       => true,
                'comment'    => 'comma separated user ids',
            ],
            'sent' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
            ],
            'record_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => false,
            ],
            'deleted' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => null,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'added_by' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'modified_by' => [
                'type'       => 'INT',
                'null'       => false,
            ],
        ]);

        // Set the primary key
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('notifications');
    }
}
