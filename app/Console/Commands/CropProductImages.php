<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CropProductImages extends Command
{
    protected $signature = 'products:crop-images';
    protected $description = 'Crop all product images to 1080x1080 square';

    public function handle()
    {
        $files = Storage::disk('public')->files('products');

        if (empty($files)) {
            $this->info("❌ No images found in storage/app/public/products/");
            return;
        }

        foreach ($files as $file) {
            $path = storage_path('app/public/' . $file);

            // Skip if not an actual image
            if (!@getimagesize($path)) {
                $this->warn("Skipping non-image: " . $file);
                continue;
            }

            $this->info("Cropping: " . $file);

            Image::make($path)
                ->fit(1080, 1080)
                ->save($path, 80);
        }

        $this->info("✅ All product images cropped to 1080x1080 successfully!");
    }
}
