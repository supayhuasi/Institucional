<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\SiteSetting;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::query()->pluck('value', 'key');

        $menuItems = MenuItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $sliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('site.home', [
            'settings' => $settings,
            'menuItems' => $menuItems,
            'sliders' => $sliders,
        ]);
    }
}
