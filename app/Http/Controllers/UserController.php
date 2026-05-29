<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AuditLog;
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

        $existing_user = User::where('email', $request->email)
                            ->whereNull('archived_at')
                            ->exists();

        if ($existing_user) {
            return redirect()->back()->with('error', 'User creation unsuccessful. Active email already exists');
        }

        $password = Str::upper(Str::random(4)) . rand(100, 999) . Str::lower(Str::random(3));

        if ($request->role == 4){

            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
                'agency' => 'required',
            ]);
           
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($password),
                'role_id' => $request->role,
                'agency_id' => $request->agency,
                'must_change_password' => true,
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
                'must_change_password' => true,
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

        AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'User created the user ' . $request->name,
        ]);

        return redirect()->back()->with('success', 'Successfully created a new user account!');
    }
    
    public function archive(User $user){
        $user->update([
            'archived_at' => now()
        ]);

        AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'User archived the user ' . $user->name,
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

        if ($request->password) {

            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ],
            ], [
                'password.regex' => 'Password must contain uppercase, lowercase, number, and special character.',
            ]);

            $data['password'] = bcrypt($request->password);
            $user->update($data);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Admin updated profile',
        ]);


        return redirect()->back()->with('success', 'Account updated successfully');
    }

    public function hrmo_account_update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ], 
        ],[
                'password.regex' => 'Password must contain uppercase, lowercase, number, and special character.',
            ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'HRMO update profile',
        ]);

        return redirect()->back()->with('success', 'Account updated successfully');
    }

    public function edit_acc_by_admin(Request $request, User $user){

         $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ],
        ], [
                'password.regex' => 'Password must contain uppercase, lowercase, number, and special character.',
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

         AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Admin updated profile of ' . $user->name,
        ]);

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

         AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'HRMO self-archived account',
        ]);

        return redirect('/');

    }
    public function password_change(Request $request){
        $request->validate([
                'password' => [
                    'required',
                    'confirmed',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                ],
            ], [
                'password.regex' => 'Password must contain uppercase, lowercase, number, and special character.',
            ]);

        auth()->user()->update([
            'password' => 'bcrypt()',
            'must_change_password' => false,
        ]);

        AuditLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'User force changed password' . auth()->user()->name ,
        ]);

        return back()->with('success', 'Password changed successfully');
    }

}

