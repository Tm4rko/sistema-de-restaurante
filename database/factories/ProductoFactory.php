<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [

            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'imagen' => $this->faker->imageUrl(640, 480, 'products', true),
            'precio_venta' => $this->faker->randomFloat(2, 10, 500),
            'fecha_ingreso' => $this->faker->date(),
            'categoria_id' => 4,
        ];
    }
}
