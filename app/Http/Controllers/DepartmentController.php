<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function getDepartments()
    {
        $departments = Department::all(['id', 'name']);
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:departments,id',
        ]);

        $department = Department::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?? 1, // Default parent_id is 1
        ]);

        return response()->json([
            'message' => 'Department added successfully!',
            'department' => $department
        ]);
    }

}
