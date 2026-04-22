<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users = DB::table("users")->get();
        // $users = DB::table("users")->pluck('email', 'name');
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch user using id
        // $user = DB::table("users")->find($id);
        $user = User::find($id);
        return $user;

        // Delete user with ids
        // $user = DB::table("users")->where('id', $id)->delete();
        // return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            "name" => "Test User update",
            "email" => "test@update1.com",
        ];
        // $user = DB::table("users")->where('id', $id)->update($data);
        $user = User::find($id)->update($data);

        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $user = DB::table("users")->where('id', $id)->delete();
        $user = User::find($id)->delete();

        return $user;
    }
}
