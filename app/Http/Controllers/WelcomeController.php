<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $activeOffers = Offer::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->with('creator')
            ->latest()
            ->take(6)
            ->get();
        
        return view('welcome', compact('activeOffers'));
    }
}
