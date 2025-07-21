<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Facades\File as FacadeFile;
use Illuminate\Support\Facades\Storage;


/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFiles = FacadeFile::files(base_path('database/factories/images/brands'));
        $selectedImage = collect($imageFiles)->random();

        $storedPath = Storage::disk('public')->putFile('brands', new File($selectedImage->getRealPath()));
        $name = $this->faker->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $storedPath,
            'description' => $this->faker->paragraph(),
            'is_active' => true,

        ];
    }
}
