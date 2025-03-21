<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('profile_picture')) {
            if ($employee->profile_picture) {
                Storage::delete('public/' . $employee->profile_picture);
            }
            $path = $request->file('profile_picture')->store('employees', 'public');
            $employee->profile_picture = $path;
        }
        
        $employee->first_name = $request->input('first_name');
        $employee->last_name = $request->input('last_name');
        $employee->phone = $request->input('phone');
        $employee->address = $request->input('address');
        $employee->save();
        
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}