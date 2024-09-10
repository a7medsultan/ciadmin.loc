<?php

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'system_settings' => [
                'type' => 'longtext',
                'null' => false,
                'charset' => 'utf8mb4',
                'collate' => 'utf8mb4_bin',
            ],
            'record_status' => [
                'type' => 'tinyint',
                'constraint' => 1,
                'null' => false,
                'default' => 1,
            ],
            'deleted' => [
                'type' => 'tinyint',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'added_by' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
            ],
            'modified_by' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
