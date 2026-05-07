<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users = DB::table("users")->get();
        // $users = DB::table("users")->pluck('email', 'name');
        $search = request('search');
        if ($search) {
            // for postgresql
            // $users = User::where('name', 'ILIKE', "%$search%")
            //     ->orWhere('email', 'ILIKE', "%$search%")
            //     ->orderByDesc('id')
            //     ->get();

            // for mysql
            $users = User::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $users = User::orderByDesc('id')->paginate(10);
        }

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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
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
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        User::find($id)->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $user = DB::table("users")->where('id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function getProfile()
    {
        $user = Auth::user();

        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);


        $image = $request->file('profile');
        if (isset($image)) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $data['profile'] = 'profile/' .$imageName;
            $image->move(public_path('profile'), $imageName);
        }

        Auth::user()->update($data);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }
}
