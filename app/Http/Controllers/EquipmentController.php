<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Employee;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // Show all equipments (with search)
    public function index(Request $request)
    {
        $query = Equipment::with('employee')->latest();

        // If there's a search term, filter by name or control number
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('control_number', 'like', "%{$search}%");
            });
        }

        $equipments = $query->get();

        return view('equipments.index', compact('equipments'));
    }

    // Show create form
    public function create()
    {
        $employees = Employee::all();
        return view('equipments.create', compact('employees'));
    }

    // Store new equipment
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        // Get current year and month
        $yearMonth = now()->format('Ym'); // e.g., 202511

        // Find the last equipment for the current month
        $lastEquipment = Equipment::where('control_number', 'like', 'MGPC-' . $yearMonth . '%')
            ->latest('id')
            ->first();

        // Determine next sequence number
        if ($lastEquipment) {
            $lastNumber = (int) substr($lastEquipment->control_number, -3);
            $number = $lastNumber + 1;
        } else {
            $number = 1;
        }

        // Format control number as MGPC-YYYYMM-###
        $controlNumber = 'MGPC-' . $yearMonth . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Create new equipment record
        Equipment::create([
            'control_number' => $controlNumber,
            'name' => $request->name,
            'employee_id' => $request->employee_id,
        ]);

        return redirect()->route('equipments.index')->with('success', 'Equipment added successfully!');
    }

    // Show edit form
    public function edit(Equipment $equipment)
    {
        $employees = Employee::all();
        return view('equipments.edit', compact('equipment', 'employees'));
    }

    // Update equipment
    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $equipment->update([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
        ]);

        return redirect()->route('equipments.index')->with('success', 'Equipment updated successfully!');
    }

    // Delete equipment
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipments.index')->with('success', 'Equipment deleted successfully!');
    }
}
