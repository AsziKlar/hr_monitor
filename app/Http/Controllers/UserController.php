<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use App\Notifications\HRMOAccountCreated;
use App\Notifications\PasswordUpdatedByAdmin;
use App\Notifications\SystemNotification;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

        $password = Str::upper(Str::random(4)) . rand(100, 999) . Str::lower(Str::random(3));

        if ($request->role == 4){

            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
                'agency' => 'required'
            ]);
           
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($password),
                'role_id' => $request->role,
                'agency_id' => $request->agency
            ]);

        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
            ]);
         
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($password),
                'role_id' => $request->role,
            ]);

        }


        // if (!$user->agency){
        //     $user->notify(
        //         new SystemNotification(
        //             'Welcome to the CSC Region X - HR Mechanism Tracker!',
        //             route('dashboard')
        //         )
        //     );

        // } else {
        //     $user->notify(
        //         new SystemNotification(
        //             'Welcome ' . $user->name . ' to the CSC Region X - HR Mechanism Tracker. Please check the details of ' . $user->agency->name ,
        //             route('hrmo.dashboard')
        //         )
        //     );
        // }

        $user->notify(
            new HRMOAccountCreated($password)
        );

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

    public function hrmo_account_update(Request $request) {
        $user = auth()->user();
       
        
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'password' => 'nullable|min:8'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if ($request->password){
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        return redirect()->back()->with('success', 'Account updated successfully');


    }

    public function edit_acc_by_admin(Request $request, User $user){

         $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'nullable|min:8'
        ]);


        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);


        if ($request->password){
            $user->update([
                'password' => bcrypt($request->password)
            ]);

            $user->notify(
                new PasswordUpdatedByAdmin($request->password)
            );
        }

        return redirect()->back()->with('success', 'Account updated successfully');

    }
 

    public function self_archive_hrmo(Request $request){
        $user = auth()->user();

        $user->update([
            'archived_at' => now()
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }

}

