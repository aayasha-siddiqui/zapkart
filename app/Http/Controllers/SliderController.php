<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        // Add your image URLs here
        $images = [
            'https://via.placeholder.com/300x200?text=Image+1',
            'https://via.placeholder.com/300x200?text=Image+2',
            'https://via.placeholder.com/300x200?text=Image+3',
            'https://via.placeholder.com/300x200?text=Image+4',
            'https://via.placeholder.com/300x200?text=Image+5',
            'https://via.placeholder.com/300x200?text=Image+6',
            'https://via.placeholder.com/300x200?text=Image+7',
        ];

        return view('slider', compact('images'));
    }
}
