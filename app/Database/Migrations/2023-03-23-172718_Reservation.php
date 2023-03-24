<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Reservation extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'reservation_key'           => [
                 'type'           => 'INT',
                 'constraint'     => 255,
                 'unsigned'       => true,
                 'auto_increment' => true,
                 'null'           => false,
                 'comment'        => "Reservation primary key"
             ],
             'u_key'         => [
                 'type'           => 'INT',
                 'constraint'     => 255,
                 'null'           => false,
                 'unsigned'       => true,
                 'comment'        => "user foreign key"
             ],
             'restaurant_key'         => [
                 'type'           => 'INT',
                 'constraint'     => 255,
                 'null'           => false,
                 'unsigned'       => true,
                 'comment'        => "restaurant foreign key"
             ],
             'text'           => [
                 'type'           => 'TEXT',
                 'null'           => false,
                 'comment'        => "Reservation text"
             ],
             'rating'           => [
                 'type'           => 'FLOAT',
                 'constraint'     => 5,
                 'null'           => false,
                 'comment'        => "Reservation rating"
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
        $this->forge->addKey('reservation_key', true);
        $this->forge->addForeignKey('u_key', 'user', 'u_key');
        $this->forge->addForeignKey('restaurant_key', 'restaurant', 'restaurant_key');
        $this->forge->createTable('reservation');
    }

    public function down()
    {
        //
    }
}
