<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //
    public function getUsers()
    {
        $users = User::select(['id', 'username', 'email', 'no_hp', 'role'])->get();
        return response()->json(['data' => $users]);
    }
}
