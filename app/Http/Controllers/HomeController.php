<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('urutan', 'asc')
            ->get();

        return view('public.home', compact('sliders'));
    }
}
