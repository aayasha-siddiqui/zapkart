<?php

use Illuminate\Support\Str;

function category_image_url($img)
{
    if (!$img) {
        return asset('images/no-category.png');
    }

    if (Str::startsWith($img, ['http', 'https'])) {
        return $img;
    }

    // stored category images
    if (Str::startsWith($img, 'categories/')) {
        return asset('storage/' . $img);
    }

    // fallback for legacy images
    return asset($img);
}


function product_image_url($image)
{
    if (!$image) {
        return asset('placeholder.jpg');
    }

    // Full URL
    if (Str::startsWith($image, ['http', 'https'])) {
        return $image;
    }

    // New stored images
    if (Str::startsWith($image, 'products/')) {
        return asset('storage/' . $image);
    }

    // Old public/images images
    if (Str::startsWith($image, 'images/')) {

        // If file was copied to storage, prefer that
        $storagePath = public_path('storage/products/' . basename($image));

        if (file_exists($storagePath)) {
            return asset('storage/products/' . basename($image));
        }

        // fallback to old path
        return asset($image);
    }

    // Last fallback
    return asset($image);
}
