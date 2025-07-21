<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\File as FacadeFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFiles = FacadeFile::files(base_path('database/factories/images/categories'));
        $selectedImage = collect($imageFiles)->random();

        $storedPath =Storage::disk('public')->putFile('public/categories',  new File($selectedImage->getRealPath()));
        $name = $this->faker->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $storedPath,
            'description' => $this->faker->paragraph(),
            'is_active' => true,

        ];
    }
}
