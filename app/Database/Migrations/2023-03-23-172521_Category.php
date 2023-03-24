<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Category extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'category_key'           => [
                 'type'           => 'INT',
                 'constraint'     => 255,
                 'unsigned'       => true,
                 'auto_increment' => true,
                 'null'           => false,
                 'comment'        => "category primary key"
             ],
             'type'         => [
                 'type'           => 'varchar',
                 'constraint'     => 255,
                 'null'           => false,
                 'comment'        => "category type"
             ],
             "created_at"    => [
                 'type'           => 'datetime'
             ],
             "updated_at"    => [
                 'type'           => 'datetime'
             ],
             "deleted_at"    => [
                 'type'           => 'datetime',
                 'null'           => true
             ]
         ]);
        $this->forge->addKey('category_key', true);
        $this->forge->createTable('category');
    }

    public function down()
    {
        //
    }
}
