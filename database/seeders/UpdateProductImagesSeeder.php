<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class UpdateProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing product images
        ProductImage::truncate();

        // Map products to their images
        $imageMap = [
            'Es Jeruk Original' => 'products/es-jeruk-original.png',
            'Es Jeruk Susu' => 'products/es-jeruk-susu.png',
            'Es Jeruk Madu' => 'products/es-jeruk-madu.png',
            'Es Sunkist Original' => 'products/es-sunkist-original.png',
            'Es Sunkist Susu' => 'products/es-sunkist-susu.png',
            'Es Sunkist Madu' => 'products/es-sunkist-madu.png',
            'Es Lemon Original' => 'products/es-lemon-original.png',
            // Note: Lemon Susu and Lemon Madu will use lemon original as placeholder for now
            'Es Lemon Susu' => 'products/es-lemon-original.png',
            'Es Lemon Madu' => 'products/es-lemon-original.png',
        ];

        foreach ($imageMap as $productName => $imagePath) {
            $product = Product::where('name', $productName)->first();
            
            if ($product) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => true,
                ]);
            }
        }

        $this->command->info('✅ Product images updated successfully!');
        $this->command->info('📸 Note: Image generation quota exhausted. Lemon Susu and Lemon Madu use placeholder. Quota resets in ~5 hours.');
    }
}
