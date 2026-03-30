<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'order_id' => ['type' => 'INT'],
            'product_id' => ['type' => 'INT'],
            'qty' => ['type' => 'INT'],
            'price' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
