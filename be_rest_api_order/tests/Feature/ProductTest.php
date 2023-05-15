<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use WithFaker;

    /**
     * A feature test_the_product.
     *
     * @return void
     */
    public function test_the_product()
    {
        $this->json('GET', 'api/product', [], [
            'Accept' => 'application/json',
        ])->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }

    /**
     * A feature test_create_product.
     *
     * @return void
     */
    public function test_create_product()
    {
        $this->json('POST', 'api/product', [
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
        ], [
            'Accept' => 'application/json',
        ])->assertStatus(201)->assertJsonStructure([
            'success',
            'message',
        ]);
    }

      /**
     * A feature test_show_product.
     *
     * @return void
     */
    public function test_show_product()
    {
        $product = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
        ]);
        $this->json('GET', 'api/product/' . $product->id, [], [
            'Accept' => 'application/json',
        ])->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);
    }

    /**
     * A feature test_update_product.
     *
     * @return void
     */
    public function test_update_product()
    {
        $product = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
        ]);
        $this->json('PUT', 'api/product/' . $product->id, [
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
        ], [
            'Accept' => 'application/json',
        ])->assertStatus(200)->assertJsonStructure([
            'success',
            'message',
        ]);
    }

    /**
     * A feature test_delete_product.
     *
     * @return void
     */
    public function test_delete_product()
    {
        $product = Product::create([
            'name' => $this->faker->words(10, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
        ]);
        $this->json('DELETE', 'api/product/' . $product->id, [], [
            'Accept' => 'application/json',
        ])->assertStatus(204);
    }
}
