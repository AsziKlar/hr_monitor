<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $users = User::whereNull('archived_at');
        $agencies = Agency::all();
        $roles = Role::all();

        if($request->filled('search')){
            $users->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $users->latest()->get();

        return view('admin.account-management', compact('user', 'users', 'agencies','roles'));
    }
    public function store(Request $request) {

        if ($request->role == 4){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required',
                'agency' => 'required'
            ]);

            
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role,
                'agency_id' => $request->agency
            ]);

        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required',
            ]);

            

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role,
            ]);
            
        }
        return redirect()->back()->with('success', 'Successfully created a new user account!');
    }
    public function archive(User $user){
        $user->update([
            'archived_at' => now()
        ]);
        return redirect()->back()->with('success', 'Account archived successfully');
    }

}
