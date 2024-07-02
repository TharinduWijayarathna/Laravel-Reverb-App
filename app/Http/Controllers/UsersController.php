<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function __invoke()
    {
        $users = User::query()
            ->paginate();

        return view('users.index', compact('users'));
    }
}
