<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Bezhanov\Faker\Provider\Commerce;

class User extends Seeder
{
    public function run()
    {
        $now   = date("Y-m-d H:i:s");

        $faker = \Faker\Factory::create();
        $faker->addProvider(new Commerce($faker));

        for ($i = 0; $i < 10; $i++) {
            $data = [
                'name'       => $faker->name,
                'email'      => $faker->email,
                'password'   => password_hash("changeme", PASSWORD_DEFAULT),
                'created_at' => $faker->dateTimeBetween('-2 month', '-1 days')->format('Y-m-d H:i:s'),
                'updated_at' => $now,
            ];
            $this->db->table('user')->insert($data);
        }
    }
}
