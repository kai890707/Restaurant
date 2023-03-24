<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RestaurantPhoto extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'restaurantPhoto_key'           => [
                 'type'           => 'INT',
                 'constraint'     => 255,
                 'unsigned'       => true,
                 'auto_increment' => true,
                 'null'           => false,
                 'comment'        => "RestaurantPhoto primary key"
             ],
             'restaurant_key'         => [
                 'type'           => 'INT',
                 'constraint'     => 255,
                 'null'           => false,
                 'unsigned'       => true,
                 'comment'        => "restaurant foreign key"
             ],
             'photo_reference'           => [
                 'type'           => 'varchar',
                 'constraint'     => 255,
                 'null'           => false,
                 'comment'        => "Restaurant photo_reference"
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
        $this->forge->addKey('restaurantPhoto_key', true);
        $this->forge->addForeignKey('restaurant_key', 'restaurant', 'restaurant_key');
        $this->forge->createTable('restaurantPhoto');
    }

    public function down()
    {
        //
    }
}
