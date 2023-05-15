<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use WithFaker;

    /**
     * A feature test_add_cart.
     *
     * @return void
     */
    public function test_add_cart()
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $product = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
        ]);
        $product2 = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
        ]);
        $this->json('POST', 'api/cart', [
            "user" => $user->id,
            "cart" => [
                [
                    "product_id" => $product->id,
                    'quantity' => $this->faker->numberBetween(1, 100),
                ],
                [
                    "product_id" => $product2->id,
                    'quantity' => $this->faker->numberBetween(1, 100),
                ]
            ]
        ], [
            'Accept' => 'application/json',
        ])->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }

    /**
     * A feature test_some_product_doesnt_exists_cart.
     *
     * @return void
     */
    public function test_some_product_doesnt_exists_cart()
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $product = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
        ]);
        $this->json('POST', 'api/cart', [
            "user" => $user->id,
            "cart" => [
                [
                    "product_id" => $product->id,
                    'quantity' => $this->faker->numberBetween(1, 100),
                ],
                [
                    "product_id" => 99999,
                    'quantity' => $this->faker->numberBetween(1, 100),
                ]
            ]
        ], [
            'Accept' => 'application/json',
        ])->assertStatus(400)->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }

    /**
     * A feature test_checkout.
     *
     * @return void
     */
    public function test_checkout()
    {
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $product = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
        ]);
        $product2 = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 100),
        ]);
        $this->json('POST', 'api/checkout', [
            "user" => $user->id,
            "cart" => [
                [
                    "product_id" => $product->id,
                    "quantity" => $this->faker->numberBetween(1, 100),
                ],
                [
                    "product_id" => $product2->id,
                    "quantity" => $this->faker->numberBetween(1, 100),
                ]
            ]
        ], [
            'Accept' => 'application/json',
        ])->assertStatus(201)->assertJsonStructure([
            'success',
            'message',
        ]);
    }

    /**
     * A feature test_list_orders.
     *
     * @return void
     */
    public function test_list_orders()
    {
        $this->json('GET', 'api/order', [], [
            'Accept' => 'application/json',
        ])->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }

    /**
     * A feature test_summary_orders.
     *
     * @return void
     */
    public function test_summary_orders()
    {
        $this->json('GET', 'api/summary', [], [
            'Accept' => 'application/json',
        ])->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'products_count',
            'orders_count'
        ]);
    }
}
