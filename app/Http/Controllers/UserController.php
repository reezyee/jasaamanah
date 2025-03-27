<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show all users
    public function index(Request $request)
    {
        $users = User::query();
        
        // Exclude the currently logged-in user
        $users->where('id', '!=', Auth::id());
        
        // Handle Ajax filter requests
        if ($request->ajax()) {
            // Filter by name
            if ($request->has('name') && !empty($request->name)) {
                $users->where('name', 'like', '%' . $request->name . '%');
            }
            
            // Filter by email
            if ($request->has('email') && !empty($request->email)) {
                $users->where('email', 'like', '%' . $request->email . '%');
            }
            
            // Filter by role
            if ($request->has('role') && !empty($request->role)) {
                $users->where('role', $request->role);
            }
            
            // Filter by division
            if ($request->has('division') && !empty($request->division)) {
                $users->where('division', 'like', '%' . $request->division . '%');
            }
            
            $filteredUsers = $users->get();
            
            return response()->json([
                'users' => $filteredUsers,
                'html' => view('pages.admin.partials.user', compact('filteredUsers'))->render()
            ]);
        }
        
        $users = $users->get();
        return view('pages.admin.user', compact('users'))->with(['title' => 'Users Management']);
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,worker,client',
            'division' => 'nullable|string|max:255'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'division' => $request->role === 'worker' ? $request->division : null,
        ]);

        return redirect('/admin/user')->with('success', 'User added successfully.');
    }

    // Update existing user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,worker,client',
            'division' => 'nullable|string|max:255'
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'division' => $request->role === 'worker' ? $request->division : null,
        ]);

        return redirect('/admin/user')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/user')->with('success', 'User deleted successfully.');
    }
}