<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_registrations' => User::where('registration_status', 'pending')->count(),
            'completed_registrations' => User::where('registration_status', 'completed')->count(),
            'payment_pending' => User::where('registration_status', 'payment_pending')->count(),
            'total_revenue' => User::where('registration_status', 'completed')->sum('amount_paid'),
        ];

        $recentUsers = User::latest()
            ->where('registration_status', '!=', 'pending')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
