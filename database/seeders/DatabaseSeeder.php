<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Product;
use App\Models\RestaurantTable;
use App\Models\Promo;
use App\Models\Order;
use App\Models\User;
use App\Models\TableBooking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Branches
        $branch1 = Branch::create([
            'name' => 'Kedai Mie Flagship Mulyosari',
            'slug' => 'mulyosari-surabaya',
            'address' => 'Jl. Raya Mulyosari No. 88, Kalisari, Mulyorejo',
            'city' => 'Surabaya',
            'phone' => '(031) 5928819',
            'opening_hours' => '10.00 - 22.00 WIB',
            'is_open' => true,
        ]);

        $branch2 = Branch::create([
            'name' => 'Kedai Mie Manyar Kertoarjo',
            'slug' => 'manyar-surabaya',
            'address' => 'Jl. Manyar Kertoarjo No. 42, Gubeng',
            'city' => 'Surabaya',
            'phone' => '(031) 5942210',
            'opening_hours' => '10.00 - 22.00 WIB',
            'is_open' => true,
        ]);

        $branch3 = Branch::create([
            'name' => 'Kedai Mie Ambengan Pusat',
            'slug' => 'ambengan-surabaya',
            'address' => 'Jl. Ambengan No. 12, Genteng',
            'city' => 'Surabaya',
            'phone' => '(031) 5319940',
            'opening_hours' => '10.00 - 22.00 WIB',
            'is_open' => true,
        ]);

        // 2. Seed Products
        Product::create([
            'code' => 'MIE-HOMPIMPA',
            'name' => 'Mie Hompimpa (Pedas Asin)',
            'category' => 'mie',
            'price' => 12000,
            'description' => 'Mie kenyal gurih dengan racikan cabai rawit segar asli dan taburan ayam cincang berbalut pangsit renyah.',
            'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => true,
            'max_spicy_level' => 8,
            'is_available' => true,
            'is_popular' => true,
            'rating' => 4.9,
            'rating_count' => 2450,
        ]);

        Product::create([
            'code' => 'MIE-GACOAN',
            'name' => 'Mie Gacoan (Pedas Manis)',
            'category' => 'mie',
            'price' => 12000,
            'description' => 'Perpaduan kecap premium manis gurih dengan sensasi cabai rawit pedas meledak, ayam cincang, dan pangsit goreng.',
            'image' => 'https://images.unsplash.com/photo-1552611052-33e04de081de?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => true,
            'max_spicy_level' => 8,
            'is_available' => true,
            'is_popular' => true,
            'rating' => 4.9,
            'rating_count' => 3120,
        ]);

        Product::create([
            'code' => 'MIE-SUIT',
            'name' => 'Mie Suit (Original Gurih)',
            'category' => 'mie',
            'price' => 11000,
            'description' => 'Pilihan non-pedas gurih aromatik minyak bawang nusantara dengan taburan ayam cincang halus dan 2 pangsit krispi.',
            'image' => 'https://images.unsplash.com/photo-1612927601601-6638404737ce?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => false,
            'max_spicy_level' => 0,
            'is_available' => true,
            'is_popular' => false,
            'rating' => 4.7,
            'rating_count' => 980,
        ]);

        Product::create([
            'code' => 'DIM-KEJU',
            'name' => 'Udang Keju Lumer',
            'category' => 'dimsum',
            'price' => 11000,
            'description' => 'Olahan daging udang segar padat dengan lelehan keju mozzarella gurih di dalamnya, digoreng keemasan.',
            'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => false,
            'max_spicy_level' => 0,
            'is_available' => true,
            'is_popular' => true,
            'rating' => 4.9,
            'rating_count' => 1890,
        ]);

        Product::create([
            'code' => 'DIM-RAMBUTAN',
            'name' => 'Udang Rambutan Crispy',
            'category' => 'dimsum',
            'price' => 11000,
            'description' => 'Bola olahan udang dan ayam berbalut kulit pangsit renyah berserabut kriuk, disajikan dengan saus bangkok.',
            'image' => 'https://images.unsplash.com/photo-1541696432-82c6da8ce7bf?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => false,
            'max_spicy_level' => 0,
            'is_available' => true,
            'is_popular' => true,
            'rating' => 4.8,
            'rating_count' => 1420,
        ]);

        Product::create([
            'code' => 'DIM-SIOMAY',
            'name' => 'Siomay Ayam Udang Kukus',
            'category' => 'dimsum',
            'price' => 10000,
            'description' => 'Siomay kukus lembut gurih kaya rempah tradisional dengan potongan udang utuh dan minyak wijen harum.',
            'image' => 'https://images.unsplash.com/photo-1526318896980-cf78c088247c?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => false,
            'max_spicy_level' => 0,
            'is_available' => true,
            'is_popular' => false,
            'rating' => 4.6,
            'rating_count' => 840,
        ]);

        Product::create([
            'code' => 'MIN-POCONG',
            'name' => 'Es Pocong Segar',
            'category' => 'minuman',
            'price' => 9000,
            'description' => 'Minuman penyejuk dahaga dari campuran sirup markisa tropis, selasih, nata de coco, dan buah jeruk asli.',
            'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => false,
            'max_spicy_level' => 0,
            'is_available' => true,
            'is_popular' => true,
            'rating' => 4.8,
            'rating_count' => 1650,
        ]);

        Product::create([
            'code' => 'MIN-GENDERUWO',
            'name' => 'Es Genderuwo Cincau Hitam',
            'category' => 'minuman',
            'price' => 9000,
            'description' => 'Kesegaran susu manis legit berpadu cincau hitam kenyal lembut dan sirup merah penawar pedas sempurna.',
            'image' => 'https://images.unsplash.com/photo-1546173159-315724a31696?q=80&w=600&auto=format&fit=crop',
            'has_spicy_level' => false,
            'max_spicy_level' => 0,
            'is_available' => true,
            'is_popular' => false,
            'rating' => 4.7,
            'rating_count' => 910,
        ]);

        // 3. Seed Restaurant Tables
        $tables = [
            ['A01', 4, 'Indoor AC'],
            ['A02', 4, 'Indoor AC'],
            ['A03', 2, 'Indoor AC'],
            ['A04', 6, 'Indoor AC'],
            ['B01', 4, 'Outdoor'],
            ['B02', 4, 'Outdoor'],
            ['B03', 6, 'Outdoor'],
            ['VIP1', 8, 'VIP Room'],
            ['VIP2', 10, 'VIP Room'],
        ];
        foreach ($tables as $t) {
            RestaurantTable::create([
                'table_number' => $t[0],
                'capacity' => $t[1],
                'room' => $t[2],
                'status' => 'available',
            ]);
        }

        // 4. Seed Promos
        Promo::create([
            'code' => 'GACOANHEMAT',
            'title' => 'Diskon 20% Pengguna Baru',
            'discount_type' => 'percent',
            'discount_value' => 20,
            'min_order' => 25000,
            'is_active' => true,
        ]);

        Promo::create([
            'code' => 'ANTIRIBET5K',
            'title' => 'Potongan Rp 5.000 Khusus Pickup',
            'discount_type' => 'fixed',
            'discount_value' => 5000,
            'min_order' => 30000,
            'is_active' => true,
        ]);

        // 5. Seed Demo Users (Explicitly for manual login)
        $demoUser = User::create([
            'name' => 'Pelanggan Setia Gacoan',
            'email' => 'user@demo.test',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '081234567890',
        ]);

        $demoKasir = User::create([
            'name' => 'Kasir Mulyosari',
            'email' => 'kasir@demo.test',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'phone' => '081234567891',
        ]);

        $demoAdmin = User::create([
            'name' => 'Admin Operasional',
            'email' => 'admin@demo.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567899',
        ]);

        // 6. Seed Initial Order
        Order::create([
            'order_code' => 'KM-PKP-1001',
            'user_id' => $demoUser->id,
            'branch_id' => $branch1->id,
            'order_type' => 'pickup_now',
            'pickup_time_slot' => '10-15 Menit',
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081234567890',
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'status' => 'in_kitchen',
            'subtotal' => 23000,
            'discount' => 4600,
            'tax' => 1840,
            'total' => 20240,
            'items' => [
                [
                    'name' => 'Mie Hompimpa (Pedas Asin)',
                    'price' => 12000,
                    'quantity' => 1,
                    'spicy_level' => 3,
                ],
                [
                    'name' => 'Udang Keju Lumer',
                    'price' => 11000,
                    'quantity' => 1,
                ]
            ],
            'notes' => 'Tolong pangsit dipisah.',
        ]);

        // 7. Seed Sample Booking
        TableBooking::create([
            'booking_code' => 'TBK-2026-001',
            'user_id' => $demoUser->id,
            'branch_id' => $branch1->id,
            'table_id' => 1,
            'customer_name' => 'Pelanggan Setia Gacoan',
            'customer_phone' => '081234567890',
            'booking_date' => now()->toDateString(),
            'booking_time' => '19:00',
            'guests_count' => 4,
            'room_preference' => 'Indoor AC',
            'status' => 'confirmed',
            'notes' => 'Dekat stop kontak bila memungkinkan.',
        ]);
    }
}
