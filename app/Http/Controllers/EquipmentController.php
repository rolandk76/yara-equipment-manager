<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with(['category', 'assignedUser']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('equipment_number', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $equipment = $query->orderBy('created_at', 'desc')->paginate(12);

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $stats = [
            'total' => Equipment::count(),
            'available' => Equipment::where('status', 'available')->count(),
            'in_use' => Equipment::where('status', 'in_use')->count(),
            'maintenance' => Equipment::where('status', 'maintenance')->count(),
        ];

        return Inertia::render('Equipment/Index', [
            'equipment' => $equipment,
            'categories' => $categories,
            'stats' => $stats,
            'filters' => $request->only(['status', 'category_id', 'search']),
        ]);
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return Inertia::render('Equipment/Create', [
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'equipment_number' => 'required|string|unique:equipment,equipment_number',
            'description' => 'nullable|string',
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'next_maintenance_date' => 'nullable|date',
            'maintenance_interval_days' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'specifications' => 'nullable|array',
        ]);

        Equipment::create($validated);

        return redirect()->route('equipment.index')
            ->with('message', 'Equipment erfolgreich erstellt!');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load(['category', 'assignedUser', 'maintenanceLogs.performedBy']);

        return Inertia::render('Equipment/Show', [
            'equipment' => $equipment,
        ]);
    }

    public function edit(Equipment $equipment)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        return Inertia::render('Equipment/Edit', [
            'equipment' => $equipment,
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'equipment_number' => 'required|string|unique:equipment,equipment_number,' . $equipment->id,
            'description' => 'nullable|string',
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'next_maintenance_date' => 'nullable|date',
            'maintenance_interval_days' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'specifications' => 'nullable|array',
        ]);

        $equipment->update($validated);

        return redirect()->route('equipment.show', $equipment)
            ->with('message', 'Equipment erfolgreich aktualisiert!');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('message', 'Equipment erfolgreich gelöscht!');
    }
}

