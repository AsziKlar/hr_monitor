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
        $users = User::all();
        $agencies = Agency::all();
        $roles = Role::all();

        return view('admin.account-management', compact('user', 'users', 'agencies','roles'));

    }

}
