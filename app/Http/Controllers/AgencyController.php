<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function index(){
        $agencies = Agency::All();

        view('admin.agencies', compact('agencies'));
    }
}
