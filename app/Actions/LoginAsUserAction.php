<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginAsUserAction extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->user);

        if ($user) {
            Auth::login($user);

            return redirect()->route('dashboard');
        }
    }
}
