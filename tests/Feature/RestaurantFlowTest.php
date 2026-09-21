<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    public function test_manual_login_redirects_based_on_role()
    {
        // User login
        $resUser = $this->post('/login', [
            'email' => 'user@demo.test',
            'password' => 'password',
        ]);
        $resUser->assertRedirect('/');
        $this->post('/logout');

        // Kasir login
        $resKasir = $this->post('/login', [
            'email' => 'kasir@demo.test',
            'password' => 'password',
        ]);
        $resKasir->assertRedirect('/pos');
        $this->post('/logout');

        // Admin login
        $resAdmin = $this->post('/login', [
            'email' => 'admin@demo.test',
            'password' => 'password',
        ]);
        $resAdmin->assertRedirect('/admin');
        $this->post('/logout');
    }

    public function test_guest_cannot_access_pos_or_admin()
    {
        $response = $this->get('/pos');
        $response->assertRedirect('/login');

        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_user_cannot_access_admin_or_pos()
    {
        $user = User::where('email', 'user@demo.test')->first();
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);

        $response = $this->actingAs($user)->get('/pos');
        $response->assertStatus(403);
    }

    public function test_kasir_can_access_pos()
    {
        $kasir = User::where('email', 'kasir@demo.test')->first();
        $response = $this->actingAs($kasir)->get('/pos');
        $response->assertStatus(200);
    }

    public function test_checkout_store_creates_order()
    {
        $user = User::where('email', 'user@demo.test')->first();
        $items = [
            [
                'id' => 1,
                'name' => 'Mie Hompimpa',
                'price' => 12000,
                'quantity' => 2,
                'spicy_level' => 3
            ]
        ];

        $res = $this->actingAs($user)->post('/checkout', [
            'order_type' => 'dine_in',
            'branch_id' => 1,
            'table_number' => 'A01',
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081234567890',
            'payment_method' => 'qris',
            'items' => json_encode($items),
        ]);

        $res->assertSessionHasNoErrors();
        $res->assertStatus(302);
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Budi Santoso',
            'table_number' => 'A01',
            'order_type' => 'dine_in',
        ]);
    }

    public function test_pos_sync_saves_offline_orders()
    {
        $kasir = User::where('email', 'kasir@demo.test')->first();
        $offlineOrders = [
            [
                'order_code' => 'OFF-260921-999',
                'order_type' => 'dine_in',
                'table_number' => 'B01',
                'customer_name' => 'Pelanggan Offline POS',
                'payment_method' => 'cash',
                'subtotal' => 24000,
                'discount' => 0,
                'tax' => 2400,
                'total' => 26400,
                'items' => [
                    ['name' => 'Mie Gacoan', 'price' => 12000, 'quantity' => 2]
                ]
            ]
        ];

        $res = $this->actingAs($kasir)->postJson('/pos/sync', [
            'orders' => $offlineOrders
        ]);

        $res->assertStatus(200);
        $res->assertJsonFragment(['success' => true]);
        $this->assertDatabaseHas('orders', [
            'order_code' => 'OFF-260921-999',
            'customer_name' => 'Pelanggan Offline POS',
        ]);
    }

    public function test_public_pages_work()
    {
        $this->get('/')->assertStatus(200);
        $this->get('/menu')->assertStatus(200);
        $this->get('/booking')->assertStatus(200);
        $this->get('/order/track/KM-PKP-1001')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }
}
