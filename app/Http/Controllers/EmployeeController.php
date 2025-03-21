<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{/*
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,manager,employee',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
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

        return response()->json(['message' => 'Employee added successfully!']);
    }*/
    /*
    public function edit($id)
    {
        $employee = Employee::with('user', 'department')->findOrFail($id);
        return response()->json($employee);
    }
    
    /**------------------------------------------------------------ */
   
    public function dashboard()
    
    {

        return view('employee.dashboard');
    }

  
    public function getDirectory(Request $request)
    {
     $employeeIds = User::where('role', 'Employee')->pluck('id');

     $employees = Employee::join('users', 'employees.user_id', '=', 'users.id')
     ->where('users.role', 'Employee')
     ->select([
         'employees.id', 
         'users.username', 
         'employees.department_id', 
         'users.email'
     ])
     ->get();
 
     return datatables()->of($employees)
         ->addColumn('department', function ($employee) {
             return $employee->department ? $employee->department->name : 'N/A'; 
         })
         ->toJson();
    }
    
    
    public function getAnnouncements()
    {
        $announcements = [
            ['title' => 'Office Closed on Friday', 'date' => '2025-03-15'],
            ['title' => 'New HR Policy Update', 'date' => '2025-03-10'],
            ['title' => 'Annual Company Retreat', 'date' => '2025-04-05'],
        ];
    
        return response()->json(['announcements' => $announcements], 200);
    }
   
    public function getTasks()
    {
        $tasks = [
            ['task' => 'Prepare Monthly Report', 'due_date' => '2025-03-20'],
            ['task' => 'Client Meeting at 2 PM', 'due_date' => '2025-03-12'],
            ['task' => 'Submit Leave Application', 'due_date' => '2025-03-15'],
        ];

        return response()->json(['tasks' => $tasks]);
    }

   
    public function getProfile()
    {
        $employee = Employee::where('user_id', Auth::id())
            ->with('department')
            ->first();

        if (!$employee) {
            return response()->json(['error' => 'Employee record not found'], 404);
        }

        return response()->json($employee);
    }
    
    public function showDirectory()
    {
        $employees = Employee::join('users', 'employees.user_id', '=', 'users.id')
            ->where('users.role', 'Employee')
            ->select(['employees.id', 'users.username', 'employees.department_id', 'users.email'])
            ->get();

        return view('employee.directory', compact('employees'));
    }

    public function showAnnouncements()
    {
        $announcements = [
            ['title' => 'Office Closed on Friday', 'date' => '2025-03-15'],
            ['title' => 'New HR Policy Update', 'date' => '2025-03-10'],
            ['title' => 'Annual Company Retreat', 'date' => '2025-04-05'],
        ];

        return view('employee.announcements', compact('announcements'));
    }

    public function showTasks()
    {
        $tasks = [
            ['task' => 'Prepare Monthly Report', 'due_date' => '2025-03-20'],
            ['task' => 'Client Meeting at 2 PM', 'due_date' => '2025-03-12'],
            ['task' => 'Submit Leave Application', 'due_date' => '2025-03-15'],
        ];

        return view('employee.tasks', compact('tasks'));
    }

    public function showProfile()
    {
        $employee = Employee::where('user_id', Auth::id())->with('department')->first();

        if (!$employee) {
            return redirect()->back()->with('error', 'Employee record not found.');
        }

        return view('employee.profile', compact('employee'));
    }

public function index()
{
    $announcements = Announcement::all();
    $tasks = Task::where('employee_id', Auth::id())->get(); 
    $employees = Employee::all(); 

    return view('dashboard', compact('announcements', 'tasks', 'employees'));
}

}
