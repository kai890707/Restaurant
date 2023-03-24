<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'u_key'           => [
                 'type'           => 'INT',
                 'constraint'     => 255,
                 'unsigned'       => true,
                 'auto_increment' => true,
                 'null'           => false,
                 'comment'        => "user primary key"
             ],
             'name'         => [
                 'type'           => 'varchar',
                 'constraint'     => 255,
                 'null'           => false,
                 'comment'        => "user name"
             ],
             'email'           => [
                 'type'           => 'varchar',
                 'constraint'     => 35,
                 'null'           => false,
                 'comment'        => "user email"
             ],
             'password'           => [
                 'type'           => 'varchar',
                 'constraint'     => 35,
                 'null'           => false,
                 'comment'        => "user password"
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
        $this->forge->addKey('u_key', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        //
    }
}
