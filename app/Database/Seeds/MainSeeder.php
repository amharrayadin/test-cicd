<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class MainSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // USERS
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->email,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('users')->insertBatch($users);

        // PRODUCTS
        $products = [];
        for ($i = 0; $i < 20; $i++) {
            $products[] = [
                'name' => $faker->word,
                'price' => $faker->numberBetween(10000, 100000),
                'stock' => $faker->numberBetween(1, 50),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }
        $this->db->table('products')->insertBatch($products);

        // ORDERS + ITEMS
        for ($i = 0; $i < 15; $i++) {

            $userId = rand(1, 10);

            $order = [
                'user_id' => $userId,
                'total_price' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('orders')->insert($order);
            $orderId = $this->db->insertID();

            $total = 0;

            $numItems = rand(1, 5);
            for ($j = 0; $j < $numItems; $j++) {
                $productId = rand(1, 20);
                $qty = rand(1, 3);
                $price = rand(10000, 100000);

                $total += $qty * $price;

                $this->db->table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'qty' => $qty,
                    'price' => $price,
                ]);
            }

            $this->db->table('orders')
                ->where('id', $orderId)
                ->update(['total_price' => $total]);
        }
    }
}