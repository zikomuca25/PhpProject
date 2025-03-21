<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
  
    public function dashboard()
    {
        return view('admin.dashboard');
    }

   
    public function getDepartmentsTree()
    {
        $departments = Department::with('children')->whereNull('parent_id')->get();
        return $this->buildDepartmentTree($departments);
    }

    private function buildDepartmentTree($departments)
    {
        $html = '<ul>';
        foreach ($departments as $department) {
            $html .= '<li class="department-item" data-id="' . $department->id . '">' . $department->name;
            if ($department->children->count()) {
                $html .= $this->buildDepartmentTree($department->children);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
    

   /* public function getDepartmentsDropdown()
    {
        return response()->json(Department::select('id', 'name')->get());
    }
*/
 
    public function getEmployees(Request $request)
    {
        if ($request->ajax()) {
            $query = Employee::with('user', 'department');
    
            if ($request->has('department_id') && !empty($request->department_id)) {
                $query->where('department_id', intval($request->department_id));
            }
    
            $employees = $query->get();
    
            return DataTables::of($employees)
                ->addColumn('name', function ($row) {
                    return $row->first_name . ' ' . $row->last_name;
                })
                ->addColumn('email', function ($row) {
                    return $row->user->email;
                })
                ->addColumn('department', function ($row) {
                    return $row->department->name ?? 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning edit-employee" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-employee" data-id="' . $row->id . '">Delete</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }
    

    public function edit($id)
    {
        $employee = Employee::with('user', 'department')->find($id);

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }
   


public function addEmployee(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|unique:users,username',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,id',
        'phone' => 'nullable|integer',
        'address' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    DB::beginTransaction();
    try {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Employee',
        ]);

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
        else if (is_null($request->file('profile_picture')))  {
            $profilePicturePath = 'images/default-profile.png';
    }
        

        Employee::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_picture' => $profilePicturePath,
        ]);

        DB::commit();
        return response()->json(['message' => 'Employee added successfully!']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Something went wrong!'], 500);
    }
}

public function updateEmployee(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'department_id' => 'required|exists:departments,id',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['error' => 'Employee not found'], 404);
    }

    DB::beginTransaction();
    try {
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $employee->profile_picture = $profilePicturePath;
        }

        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($employee->user) {
            $employee->user->touch(); // Updates `updated_at`
        }

        DB::commit();
        return response()->json(['message' => 'Employee updated successfully!']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Something went wrong!'], 500);
    }
}

    
    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
    
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
    
        $user = $employee->user;
    
        $employee->delete();
    
        if ($user) {
            $user->delete();
        }
    
        return response()->json(['message' => 'Employee deleted successfully!']);
    }}