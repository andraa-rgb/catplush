<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ExamSession;
use App\Models\ExamResult;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Adjust model queries if needed
        $sessions = ExamSession::where('is_active', true)->get();
        $results = ExamResult::where('user_id', $user->id)->get();

        return view('dashboard', compact('user', 'sessions', 'results'));
    }
}