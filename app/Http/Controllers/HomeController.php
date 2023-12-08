<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $services = [
            ['id' => 1, 'name' => 'Layanan A', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco', 'price' => 20_000, 'shipping_cost' => 0, 'days_of_work' => 3],
            ['id' => 2, 'name' => 'Layanan B', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco', 'price' => 25_000, 'shipping_cost' => 0, 'days_of_work' => 2],
            ['id' => 3, 'name' => 'Layanan C', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco', 'price' => 30_000, 'shipping_cost' => 0, 'days_of_work' => 3],
            ['id' => 4, 'name' => 'Layanan D', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco', 'price' => 50_000, 'shipping_cost' => 0, 'days_of_work' => 1]
        ];

        return view('welcome', [
            'services' => $services
        ]);
    }
}
