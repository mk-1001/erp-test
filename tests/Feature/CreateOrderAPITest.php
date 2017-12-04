<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateOrderAPITest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Create a simple Order, with a single Item containing a quantity of 2.
     *
     * @return void
     */
    public function test_creates_simple_order()
    {
        $order = [
            'customer' => 'Gabriel Jaramillo',
            'total'    => 555.1,
            'address'  => '12 Sims Street Australia',
            'items'    => [[
                'sku'      => 'SKU1234',
                'quantity' => 2,
                'colour'   => 'green'
            ]]
        ];
        $response = $this->json('POST', '/api/orders', ['order' => $order]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'items');
    }

    /**
     * Create an Order with multiple Items, including repetitions of the same sku.
     *
     * @return void
     */
    public function test_order_with_multiple_items()
    {
        // Total expected items: 2 + 2 + 8 = 12
        $items = [
            [
                'sku'      => 'SKU1223534',
                'quantity' => 2,
                'colour'   => 'green'
            ],
            [
                'sku'      => 'SKUABCDEFG',
                'quantity' => 2,
                'colour'   => 'red'
            ],
            [
                'sku'      => 'SKU1223534',
                'quantity' => 8,
                'colour'   => 'green'
            ],
        ];
        $order = [
            'customer' => 'Gabriel Surname',
            'total'    => 700.2,
            'address'  => '13 Sims Street Australia',
            'items'    => $items
        ];
        $response = $this->json('POST', '/api/orders', ['order' => $order]);

        $response->assertStatus(200);
        $response->assertJsonCount(12, 'items');
    }

    /**
     * Test an Order with an invalid input (missing customer).
     *
     * @return void
     */
    public function test_order_with_missing_customer_input()
    {
        $order = [
            'total'    => 102.3,
            'address'  => '12 Sims Street Australia',
            'items'    => [[
                'sku'      => 'SKU1234',
                'quantity' => 2,
                'colour'   => 'green'
            ]]
        ];
        $response = $this->json('POST', '/api/orders', ['order' => $order]);
        $response->assertStatus(422);
        $response->assertSee('order.customer field');
    }

    /**
     * Test an Order with an invalid input (no items).
     *
     * @return void
     */
    public function test_order_with_missing_items()
    {
        $order = [
            'customer' => 'Gabriel Surname',
            'total'    => 102.3,
            'address'  => '12 Sims Street Australia'
        ];
        $response = $this->json('POST', '/api/orders', ['order' => $order]);
        $response->assertStatus(422);
        $response->assertSee('order.items field');
    }
}
