<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FixProductImages extends Command
{
    protected $signature = 'fix:product-images';
    protected $description = 'Copy public/images to storage/products and fix DB image paths safely';

    public function handle()
    {
        $this->info("🔍 Scanning product images...\n");

        $products = DB::table('products')->get();
        $fixedCount = 0;
        $skipped = 0;

        foreach ($products as $product) {
            $image = $product->image;

            if (!$image) {
                $skipped++;
                continue;
            }

            // Already correct path
            if (str_starts_with($image, 'products/')) {
                $skipped++;
                continue;
            }

            // Remote URLs keep as is
            if (str_starts_with($image, 'http')) {
                $skipped++;
                continue;
            }

            $publicImagePath = public_path($image);
            $storagePath = 'products/' . basename($image);

            // If file exists in public/images → copy to storage
            if (File::exists($publicImagePath)) {

                Storage::disk('public')->put(
                    $storagePath,
                    File::get($publicImagePath)
                );

                // Update DB
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['image' => $storagePath]);

                $this->info("✅ Fixed: {$product->name} → {$storagePath}");
                $fixedCount++;

            } else {
                $this->warn("⚠ Not found: {$image}");
            }
        }

        $this->info("\n✅ DONE!");
        $this->info("✅ Fixed: {$fixedCount}");
        $this->info("⏭ Skipped: {$skipped}");
        $this->info("📁 New images stored in: storage/products/");
        $this->info("🛡 No images deleted, all safe.");

        return Command::SUCCESS;
    }
}
