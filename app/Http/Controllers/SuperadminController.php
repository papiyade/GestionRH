<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreated;
use App\Models\Entreprise;

use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    //
public function index()
{
    $entreprises = Entreprise::all();

    $actives = $entreprises->where('is_actif', true)->count();
    $inactives = $entreprises->where('is_actif', false)->count();

    return view('superadmin.dashboard', compact('entreprises', 'actives', 'inactives')); 
}


    public function addAdmin()
{
    return view('superadmin.addUsers');
}

public function createUsers(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed',
        'telephone' => 'nullable',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->telephone = $request->telephone;
    $user->role = 'admin';
    $user->save();

   
    Mail::to($user->email)->send(new AccountCreated($user->name, $user->email, $request->password));

    return redirect()->route('list_admin')->with('success', 'Administrateur ajouté avec succès.');
}


    public function adminList()
    {
    $admins = User::where('role', 'admin')->get();
    return view('superadmin.listUsers', compact('admins'));
    }

    public function status(){
        return view('status');
    }

}
