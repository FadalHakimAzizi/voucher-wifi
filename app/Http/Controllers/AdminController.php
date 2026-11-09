<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role; // 'admin' atau 'user'
        return view('admin.dashboard', compact('role'));
    }
}
