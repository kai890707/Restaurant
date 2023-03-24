<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Restaurant extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'restaurant_key' => [
                'type'           => 'INT',
                'constraint'     => 255,
                'unsigned'       => true,
                'auto_increment' => true,
                'null'           => false,
                'comment'        => "Restaurant primary key"
            ],
            'category_key'         => [
                'type'           => 'INT',
                'constraint'     => 255,
                'unsigned'       => true,
                'null'           => false,
                'comment'        => "Category foreign key"
            ],
            'name'         => [
                'type'           => 'varchar',
                'constraint'     => 255,
                'null'           => false,
                'comment'        => "Restaurant name"
            ],
            'address'           => [
                'type'           => 'varchar',
                'constraint'     => 255,
                'null'           => false,
                'comment'        => "Restaurant address"
            ],
            'phoneNumber'           => [
                'type'           => 'varchar',
                'constraint'     => 255,
                'null'           => false,
                'comment'        => "Restaurant phoneNumber"
            ],
            'weekday'           => [
                'type'           => 'TEXT',
                'null'           => false,
                'comment'        => "Restaurant weekday"
            ],
            'lat'           => [
                'type'           => 'FLOAT',
                'constraint'     => 40,
                'null'           => false,
                'unsigned'       => true,
                'comment'        => "Restaurant 緯度"
            ],
            'lng'           => [
                'type'           => 'FLOAT',
                'constraint'     => 40,
                'null'           => false,
                'unsigned'       => true,
                'comment'        => "Restaurant 經度"
            ],
            'rating'           => [
                'type'           => 'FLOAT',
                'constraint'     => 5,
                'null'           => false,
                'comment'        => "Restaurant rating"
            ],
            'website'           => [
                'type'           => 'varchar',
                'constraint'     => 255,
                'null'           => false,
                'comment'        => "Restaurant website"
            ],
            'placeID'           => [
                'type'           => 'varchar',
                'constraint'     => 255,
                'null'           => false,
                'comment'        => "googel place id"
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
        $this->forge->addKey('restaurant_key', true);
        $this->forge->addForeignKey('category_key', 'category', 'category_key');
        $this->forge->createTable('restaurant');
    }

    public function down()
    {
        //
    }
}
