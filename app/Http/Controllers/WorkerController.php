<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WorkerController extends Controller
{
    // Admin: Melihat semua worker
    public function index()
    {
        $workers = User::where('role', 'worker')->get();
        return view('admin.workers', compact('workers'));
    }

    // Admin: Menambah worker
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'division' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'worker',
            'division' => $request->division,
        ]);

        return redirect()->back()->with('success', 'Worker added successfully!');
    }
}
