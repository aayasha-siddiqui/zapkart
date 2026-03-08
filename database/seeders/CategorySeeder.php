<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ["id" => 1, "name" => "Atta & Maida", "image" => "categories/11.jpg", "tagline" => "flat 50% OFF"],
            ["id" => 3, "name" => "Rice", "image" => "categories/12.jpg", "tagline" => "Starts at ₹99"],
            ["id" => 4, "name" => "Dal & Pulses", "image" => "categories/13.jpg", "tagline" => "Flat 15% Off"],
            ["id" => 5, "name" => "Sugar & Jaggery", "image" => "categories/Ea84RPQ4P9ShUIySUFB3q9zyHZShkWXdbEmw9fjN.jpg", "tagline" => "Sweet Deals Starting ₹54"],
            ["id" => 6, "name" => "Salt", "image" => "categories/slr.jpeg", "tagline" => "Buy 1 Get 1 Free"],
            ["id" => 7, "name" => "Oil & Ghee", "image" => "categories/oil.jpg", "tagline" => "Fresh Stock Sale"],
            ["id" => 8, "name" => "Spices & Masala", "image" => "categories/14.jpg", "tagline" => "Big Discounts on Brands"],
            ["id" => 9, "name" => "Tea & Coffee", "image" => "categories/tea.jpg", "tagline" => "Morning Offers Up to 25% Off"],
            ["id" => 10, "name" => "Dry Fruits & Nuts", "image" => "categories/e3.jpg", "tagline" => "Premium Range – Save More"],
            ["id" => 11, "name" => "Poha & Suji", "image" => "categories/11.jpg", "tagline" => "Breakfast Offer – Starts ₹59"],
            ["id" => 12, "name" => "Biscuits & Rusk", "image" => "categories/bf.jpg", "tagline" => "Snack Time Deals"],
            ["id" => 13, "name" => "Noodles & Pasta", "image" => "categories/nd.jpeg", "tagline" => "Quick Meals, Big Savings"],
            ["id" => 14, "name" => "Breakfast Cereals", "image" => "categories/bff.jpg", "tagline" => "Healthy Start @ ₹79"],
            ["id" => 15, "name" => "Ready-to-Eat", "image" => "categories/rd.jpg", "tagline" => "Instant Deals Just for You"],
            ["id" => 16, "name" => "Pickles & Papad", "image" => "categories/pp.jpeg", "tagline" => "Traditional Taste Offers"],
            ["id" => 17, "name" => "Baking Essentials", "image" => "categories/bk.jpg", "tagline" => "Bake & Save – Offers Live"],
            ["id" => 18, "name" => "Sauces & Ketchup", "image" => "categories/ss.jpg", "tagline" => "Add Spice – Offers Inside"],
            ["id" => 19, "name" => "Snacks & Namkeen", "image" => "categories/sn.jpg", "tagline" => "Crunchy Offers Starting ₹39"],
            ["id" => 20, "name" => "Dairy", "image" => "categories/dr.jpeg", "tagline" => "Fresh Daily Deals"],
            ["id" => 21, "name" => "Eggs & Bread", "image" => "categories/eg.jpeg", "tagline" => "Morning Essentials Offer"],
            ["id" => 22, "name" => "Frozen Food", "image" => "categories/fg.jpeg", "tagline" => "Cool Deals – Up to 30% Off"],
            ["id" => 23, "name" => "Cleaning Essentials", "image" => "categories/ce.jpg", "tagline" => "Home Cleaning Offers"],
            ["id" => 24, "name" => "Personal Care", "image" => "categories/pc.jpg", "tagline" => "Self Care Deals"],
            ["id" => 25, "name" => "Baby Care", "image" => "categories/bb.jpg", "tagline" => "Gentle Care, Great Discounts"],
            ["id" => 26, "name" => "Pet Care", "image" => "categories/7FZVQ356BcYjOjazcGX7LJDIFfwzg0JDoBSoUZsJ.jpg", "tagline" => "Happy Pets, Smart Savings"],
            ["id" => 29, "name" => "gud", "image" => "categories/qTqhCfuxYi0iWtPxqp9IDeWdwfwCzoMNtk7iFYkn.jpg", "tagline" => "Sweet Deals Starting ₹54"],
        ];

        DB::table('categories')->insert($categories);
    }
}
