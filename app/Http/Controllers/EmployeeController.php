<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // Show all employees
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    // Show create form
    public function create()
    {
        return view('employees.create'); // Make sure this view exists
    }

    // Store new employee
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Employee::create([
            'name' => $request->name,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully!');
    }

    // Show edit form
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // Update employee name
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $employee->update([
            'name' => $request->name,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee name updated successfully!');
    }

    // Delete employee
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
