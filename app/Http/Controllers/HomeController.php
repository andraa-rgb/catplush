<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home/landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get all dosens with their latest status and jadwals
        $dosens = User::whereIn('role', ['staf', 'kepala_lab'])
            ->with(['status', 'jadwals'])
            ->get();

        return view('home', compact('dosens'));
    }
}
