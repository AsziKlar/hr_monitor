<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        $agencies = Agency::all();
        $roles = Role::all();

        $search = request('search');

        $users = User::when($search, function ($query, $search){
                        $query  ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
            })->latest()->get();

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
        return redirect()->back();
    }

}
