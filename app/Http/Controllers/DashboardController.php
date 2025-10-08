<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Category;
use App\Models\MaintenanceLog;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_equipment' => Equipment::count(),
            'available' => Equipment::where('status', 'available')->count(),
            'in_use' => Equipment::where('status', 'in_use')->count(),
            'maintenance' => Equipment::where('status', 'maintenance')->count(),
        ];

        $categories = Category::withCount('equipment')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $recentEquipment = Equipment::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $upcomingMaintenance = Equipment::whereNotNull('next_maintenance_date')
            ->where('next_maintenance_date', '<=', now()->addDays(30))
            ->with('category')
            ->orderBy('next_maintenance_date')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'stats' => $stats,
            'categories' => $categories,
            'recentEquipment' => $recentEquipment,
            'upcomingMaintenance' => $upcomingMaintenance,
        ]);
    }
}

