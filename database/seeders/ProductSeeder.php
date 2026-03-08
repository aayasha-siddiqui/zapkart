<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->truncate();

        $products = [

            // ✅ CATEGORY 1 – Atta & Maida
            ["id" => 1, "name" => "Aashirvaad Whole Wheat Atta", "image" => "products/UV7lCDS7e254ydUJmG7o3w4Hc1GEff2qmmLOZAA5.jpg", "price" => 49.00, "description" => "Fresh and pure whole wheat flour for soft rotis", "category_id" => 1],
            ["id" => 2, "name" => "Fortune Multigrain Atta", "image" => "products/cZrtOMrBzgJGSdgZh1O0ORJ1Z7jnoNiUelpgCzfy.webp", "price" => 65.00, "description" => "Blend of multiple grains for healthy rotis", "category_id" => 1],
           ["id" => 9, "name" => "Atta Gold Premium 10kg", "image" => "products/Yp34Q11pR43rhgdW8WeJawhGwnUqXBtsGpPqYxD2.webp", "price" => 900.00, "description" => "Premium wheat flour, finely ground", "category_id" => 1],
            ["id" => 17, "name" => "Maida Premium 2kg", "image" => "products/3wzgsi5KB7MpDXYkT0gmcAupmRgyLvmXxXk8dE8W.jpg", "price" => 170.00, "description" => "High-quality refined flour for bakery", "category_id" => 1],

            // ✅ CATEGORY 3 – Rice
            ["id" => 24, "name" => "Non-Basmati Rice", "image" => "products/r2.webp", "price" => 90.00, "description" => "Quality non-basmati rice.", "category_id" => 3],
            ["id" => 25, "name" => "Brown Rice", "image" => "products/r3.webp", "price" => 150.00, "description" => "Healthy brown whole grain rice.", "category_id" => 3],
            ["id" => 26, "name" => "Idli Rice", "image" => "products/r4.webp", "price" => 110.00, "description" => "Perfect rice for soft idlis.", "category_id" => 3],
            ["id" => 27, "name" => "Steam Rice", "image" => "products/r5.webp", "price" => 100.00, "description" => "Light and fluffy steam rice.", "category_id" => 3],

            // ✅ CATEGORY 4 – Dal & Pulses
            ["id" => 28, "name" => "Toor Dal", "image" => "products/t5.webp", "price" => 120.00, "description" => "Premium quality toor dal.", "category_id" => 4],
            ["id" => 29, "name" => "Moong Dal", "image" => "products/t6.webp", "price" => 110.00, "description" => "Fresh, clean and nutritious moong dal.", "category_id" => 4],
            ["id" => 30, "name" => "Masoor Dal", "image" => "products/TfP9gBVLVlHBItEqpixIR0Iw5Bo3vE9oJlPVcimP.webp", "price" => 100.00, "description" => "High-quality masoor dal for daily cooking.", "category_id" => 4],
            ["id" => 31, "name" => "Chana Dal", "image" => "products/t8.webp", "price" => 90.00, "description" => "Pure and premium chana dal.", "category_id" => 4],
            ["id" => 32, "name" => "Urad Dal", "image" => "products/t9.webp", "price" => 130.00, "description" => "Best quality urad dal for idli & dosa.", "category_id" => 4],

            // ✅ CATEGORY 5 – Sugar & Jaggery
            ["id" => 37, "name" => "White Sugar", "image" => "products/t10.webp", "price" => 55.00, "description" => "Premium quality white sugar.", "category_id" => 5],
            ["id" => 38, "name" => "Brown Sugar", "image" => "products/t11.webp", "price" => 68.00, "description" => "Unrefined brown sugar with natural minerals.", "category_id" => 5],
            ["id" => 39, "name" => "Jaggery (Gur)", "image" => "products/t12.webp", "price" => 75.00, "description" => "Organic jaggery made from sugarcane.", "category_id" => 5],
            ["id" => 40, "name" => "Mishri", "image" => "products/t13.jpg", "price" => 90.00, "description" => "Pure crystal mishri.", "category_id" => 5],

            // ✅ CATEGORY 6 – Salt
            ["id" => 42, "name" => "Iodized Salt", "image" => "products/300.jpg", "price" => 427.00, "description" => "High quality Iodized Salt", "category_id" => 6],
            ["id" => 43, "name" => "Rock Salt", "image" => "products/301.jpg", "price" => 351.00, "description" => "High quality Rock Salt", "category_id" => 6],
            ["id" => 44, "name" => "Black Salt", "image" => "products/302.jpg", "price" => 399.00, "description" => "High quality Black Salt", "category_id" => 6],

            // ✅ CATEGORY 7 – Oil & Ghee
            ["id" => 45, "name" => "Mustard Oil", "image" => "products/303.jpg", "price" => 146.00, "description" => "High quality Mustard Oil", "category_id" => 7],
            ["id" => 46, "name" => "Sunflower Oil", "image" => "products/304.jpg", "price" => 269.00, "description" => "High quality Sunflower Oil", "category_id" => 7],
            ["id" => 47, "name" => "Groundnut Oil", "image" => "products/305.jpg", "price" => 370.00, "description" => "High quality Groundnut Oil", "category_id" => 7],
            ["id" => 48, "name" => "Desi Ghee", "image" => "products/306.jpg", "price" => 360.00, "description" => "High quality Desi Ghee", "category_id" => 7],

            // ✅ CATEGORY 8 – Spices & Masala
            ["id" => 49, "name" => "Haldi", "image" => "products/307.jpg", "price" => 472.00, "description" => "High quality Haldi", "category_id" => 8],
            ["id" => 50, "name" => "Garam Masala", "image" => "products/308.jpg", "price" => 358.00, "description" => "High quality Garam Masala", "category_id" => 8],
            ["id" => 51, "name" => "Jeera", "image" => "products/309.jpg", "price" => 146.00, "description" => "High quality Jeera", "category_id" => 8],
            ["id" => 52, "name" => "Whole Spices", "image" => "products/310.jpg", "price" => 277.00, "description" => "High quality Whole Spices", "category_id" => 8],

            // ✅ CATEGORY 9 – Tea & Coffee
            ["id" => 53, "name" => "Regular Tea", "image" => "products/311.jpg", "price" => 165.00, "description" => "High quality Regular Tea", "category_id" => 9],
            ["id" => 54, "name" => "Green Tea", "image" => "products/312.jpg", "price" => 373.00, "description" => "High quality Green Tea", "category_id" => 9],
            ["id" => 55, "name" => "Instant Coffee", "image" => "products/313.jpg", "price" => 442.00, "description" => "High quality Instant Coffee", "category_id" => 9],
            ["id" => 56, "name" => "Filter Coffee", "image" => "products/314.jpg", "price" => 221.00, "description" => "High quality Filter Coffee", "category_id" => 9],

            // ✅ CATEGORY 10 – Dry Fruits & Nuts
            ["id" => 57, "name" => "Almonds", "image" => "products/315.jpg", "price" => 84.00, "description" => "High quality Almonds", "category_id" => 10],
            ["id" => 58, "name" => "Cashews", "image" => "products/316.jpg", "price" => 370.00, "description" => "High quality Cashews", "category_id" => 10],
            ["id" => 59, "name" => "Raisins", "image" => "products/317.jpg", "price" => 88.00, "description" => "High quality Raisins", "category_id" => 10],
            ["id" => 60, "name" => "Pistachios", "image" => "products/318.jpg", "price" => 450.00, "description" => "High quality Pistachios", "category_id" => 10],

            // ✅ CATEGORY 11 – Poha & Suji
            ["id" => 61, "name" => "Poha", "image" => "products/319.jpg", "price" => 109.00, "description" => "High quality Poha", "category_id" => 11],
            ["id" => 62, "name" => "Suji", "image" => "products/320.jpg", "price" => 279.00, "description" => "High quality Suji", "category_id" => 11],
            ["id" => 63, "name" => "Dalia", "image" => "products/321.jpg", "price" => 479.00, "description" => "High quality Dalia", "category_id" => 11],

            // ✅ CATEGORY 12 – Biscuits & Rusk
            ["id" => 64, "name" => "Cream Biscuits", "image" => "products/322.jpg", "price" => 218.00, "description" => "High quality Cream Biscuits", "category_id" => 12],
            ["id" => 65, "name" => "Marie", "image" => "products/323.jpg", "price" => 431.00, "description" => "High quality Marie", "category_id" => 12],
            ["id" => 66, "name" => "Rusk", "image" => "products/324.jpg", "price" => 124.00, "description" => "High quality Rusk", "category_id" => 12],

            // ✅ CATEGORY 13 – Noodles & Pasta
            ["id" => 67, "name" => "Instant Noodles", "image" => "products/325.jpg", "price" => 146.00, "description" => "High quality Instant Noodles", "category_id" => 13],
            ["id" => 68, "name" => "Hakka Noodles", "image" => "products/326.jpg", "price" => 308.00, "description" => "High quality Hakka Noodles", "category_id" => 13],
            ["id" => 69, "name" => "Pasta", "image" => "products/327.jpg", "price" => 433.00, "description" => "High quality Pasta", "category_id" => 13],

            // ✅ CATEGORY 14 – Breakfast Cereals
            ["id" => 70, "name" => "Cornflakes", "image" => "products/328.jpg", "price" => 434.00, "description" => "High quality Cornflakes", "category_id" => 14],
            ["id" => 71, "name" => "Oats", "image" => "products/329.jpg", "price" => 468.00, "description" => "High quality Oats", "category_id" => 14],
            ["id" => 72, "name" => "Muesli", "image" => "products/330.jpg", "price" => 200.00, "description" => "High quality Muesli", "category_id" => 14],

            // ✅ CATEGORY 15 – Ready to Eat
            ["id" => 73, "name" => "Instant Upma", "image" => "products/331.jpg", "price" => 450.00, "description" => "High quality Instant Upma", "category_id" => 15],
            ["id" => 74, "name" => "Cup Noodles", "image" => "products/332.jpg", "price" => 304.00, "description" => "High quality Cup Noodles", "category_id" => 15],
            ["id" => 75, "name" => "Instant Mixes", "image" => "products/sqKCNeuljQ6SxtpmGf992hEgPU7gQbjrRNgNVWVo.jpg", "price" => 94.00, "description" => "High quality Instant Mixes", "category_id" => 15],

            // ✅ CATEGORY 16 – Pickles & Papad
            ["id" => 76, "name" => "Mango Pickle", "image" => "products/334.jpg", "price" => 219.00, "description" => "High quality Mango Pickle", "category_id" => 16],
            ["id" => 77, "name" => "Mixed Pickle", "image" => "products/335.jpg", "price" => 344.00, "description" => "High quality Mixed Pickle", "category_id" => 16],
            ["id" => 78, "name" => "Papad", "image" => "products/336.jpg", "price" => 287.00, "description" => "High quality Papad", "category_id" => 16],

            // ✅ CATEGORY 17 – Baking Essentials
            ["id" => 79, "name" => "Maida", "image" => "products/337.jpg", "price" => 356.00, "description" => "High quality Maida", "category_id" => 17],
            ["id" => 80, "name" => "Baking Powder", "image" => "products/338.jpg", "price" => 317.00, "description" => "High quality Baking Powder", "category_id" => 17],
            // ✅ CATEGORY 17 – Baking Essentials (continued)
            ["id" => 81, "name" => "Cocoa Powder", "image" => "products/339.jpg", "price" => 145.00, "description" => "High quality Cocoa Powder", "category_id" => 17],
            ["id" => 82, "name" => "Yeast", "image" => "products/340.jpg", "price" => 231.00, "description" => "High quality Yeast", "category_id" => 17],

            // ✅ CATEGORY 18 – Sauces & Ketchup
            ["id" => 83, "name" => "Tomato Ketchup", "image" => "products/341.jpg", "price" => 313.00, "description" => "High quality Tomato Ketchup", "category_id" => 18],
            ["id" => 84, "name" => "Soya Sauce", "image" => "products/342.jpg", "price" => 128.00, "description" => "High quality Soya Sauce", "category_id" => 18],
            ["id" => 85, "name" => "Chilli Sauce", "image" => "products/343.jpg", "price" => 490.00, "description" => "High quality Chilli Sauce", "category_id" => 18],

            // ✅ CATEGORY 19 – Snacks & Namkeen
            ["id" => 86, "name" => "Bhujia", "image" => "products/344.jpg", "price" => 186.00, "description" => "High quality Bhujia", "category_id" => 19],
            ["id" => 87, "name" => "Chips", "image" => "products/345.jpg", "price" => 207.00, "description" => "High quality Chips", "category_id" => 19],
            ["id" => 88, "name" => "Mixture", "image" => "products/346.jpg", "price" => 59.00, "description" => "High quality Mixture", "category_id" => 19],

            // ✅ CATEGORY 20 – Dairy
            ["id" => 89, "name" => "Milk", "image" => "products/347.jpg", "price" => 342.00, "description" => "High quality Milk", "category_id" => 20],
            ["id" => 90, "name" => "Curd", "image" => "products/348.jpg", "price" => 241.00, "description" => "High quality Curd", "category_id" => 20],
            ["id" => 91, "name" => "Butter", "image" => "products/349.jpg", "price" => 371.00, "description" => "High quality Butter", "category_id" => 20],
            ["id" => 92, "name" => "Paneer", "image" => "products/350.jpg", "price" => 59.00, "description" => "High quality Paneer", "category_id" => 20],

            // ✅ CATEGORY 21 – Eggs & Bread
            ["id" => 93, "name" => "White Bread", "image" => "products/351.jpg", "price" => 363.00, "description" => "High quality White Bread", "category_id" => 21],
            ["id" => 94, "name" => "Brown Bread", "image" => "products/352.jpg", "price" => 182.00, "description" => "High quality Brown Bread", "category_id" => 21],
            ["id" => 95, "name" => "Eggs", "image" => "products/353.jpg", "price" => 206.00, "description" => "High quality Eggs", "category_id" => 21],

            // ✅ CATEGORY 22 – Frozen Food
            ["id" => 96, "name" => "Paratha", "image" => "products/354.jpg", "price" => 58.00, "description" => "High quality Paratha", "category_id" => 22],
            ["id" => 97, "name" => "Fries", "image" => "products/355.jpg", "price" => 455.00, "description" => "High quality Fries", "category_id" => 22],
            ["id" => 98, "name" => "Ice Cream", "image" => "products/356.jpg", "price" => 456.00, "description" => "High quality Ice Cream", "category_id" => 22],

            // ✅ CATEGORY 23 – Cleaning Essentials
            ["id" => 99, "name" => "Dishwash", "image" => "products/357.jpg", "price" => 283.00, "description" => "High quality Dishwash", "category_id" => 23],
            ["id" => 100, "name" => "Floor Cleaner", "image" => "products/358.jpg", "price" => 330.00, "description" => "High quality Floor Cleaner", "category_id" => 23],
            ["id" => 101, "name" => "Toilet Cleaner", "image" => "products/359.jpg", "price" => 107.00, "description" => "High quality Toilet Cleaner", "category_id" => 23],

            // ✅ CATEGORY 24 – Personal Care
            ["id" => 102, "name" => "Soap", "image" => "products/360.jpg", "price" => 62.00, "description" => "High quality Soap", "category_id" => 24],
            ["id" => 103, "name" => "Shampoo", "image" => "products/361.jpg", "price" => 128.00, "description" => "High quality Shampoo", "category_id" => 24],
            ["id" => 104, "name" => "Toothpaste", "image" => "products/362.jpg", "price" => 299.00, "description" => "High quality Toothpaste", "category_id" => 24],

            // ✅ CATEGORY 25 – Baby Care
            ["id" => 105, "name" => "Baby Diapers", "image" => "products/363.jpg", "price" => 473.00, "description" => "High quality Baby Diapers", "category_id" => 25],
            ["id" => 106, "name" => "Baby Lotion", "image" => "products/364.jpg", "price" => 415.00, "description" => "High quality Baby Lotion", "category_id" => 25],
            ["id" => 107, "name" => "Baby Food", "image" => "products/365.jpg", "price" => 94.00, "description" => "High quality Baby Food", "category_id" => 25],

            // ✅ CATEGORY 26 – Pet Care
            ["id" => 108, "name" => "Dog Food", "image" => "products/366.jpg", "price" => 200.00, "description" => "High quality Dog Food", "category_id" => 26],
            ["id" => 109, "name" => "Cat Food", "image" => "products/367.jpg", "price" => 313.00, "description" => "High quality Cat Food", "category_id" => 26],
            ["id" => 110, "name" => "Pet Shampoo", "image" => "products/368.jpg", "price" => 468.00, "description" => "High quality Pet Shampoo", "category_id" => 26],

            // ✅ EXTRA ITEMS YOU ADDED
            ["id" => 111, "name" => "Chai", "image" => "products/U7vOUzFDkIlFjShdxbx395ymr26qduuN2JEHvnKN.jpg", "price" => 353.00, "description" => "Flat 10% off", "category_id" => 9],
            ["id" => 112, "name" => "Instant Mixes Deluxe", "image" => "products/uxgww1d1FgjEQ3qAjbeTyG4Q5DRRajvjPSZZFGzE.jpg", "price" => 321.00, "description" => "Best Quality", "category_id" => 17],
        ];

        DB::table('products')->insert($products);
    }
}
