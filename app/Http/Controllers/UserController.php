<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
           
            $user = User::create([
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
         
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role,
            ]);

        }

        if (!$user->agency){
            $user->notify(
                new SystemNotification(
                    'Welcome to the CSC Region X - HR Mechanism Tracker!',
                    route('dashboard')
                )
            );

        } else {
            $user->notify(
                new SystemNotification(
                    'Welcome ' . $user->name . ' to the CSC Region X - HR Mechanism Tracker. Please check the details of ' . $user->agency->name ,
                    route('hrmo.dashboard')
                )
            );
        }

        return redirect()->back()->with('success', 'Successfully created a new user account!');
    }
    public function archive(User $user){
        $user->update([
            'archived_at' => now()
        ]);
        return redirect()->back()->with('success', 'Account archived successfully');
    }

    public function admin_profile_update(Request $request){
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return redirect()->back()->with('success', 'Account updated successfully');
    }

}