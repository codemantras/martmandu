<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\File as FacadeFile;


/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        // 💾 Get real image from local folder
        $localFiles = FacadeFile::files(base_path('database/factories/images/products'));
        $selectedImage = collect($localFiles)->random();

        // 📥 Copy image into public storage
        $storedPath = Storage::disk('public')->putFile('products', new File($selectedImage->getRealPath()));

        return [
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'images' => json_encode([$storedPath]),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'is_active' => true,
            'is_featured' => $this->faker->boolean(),
            'in_stock' => $this->faker->boolean(80),
            'on_sale' => $this->faker->boolean(30),
        ];
    }
}
