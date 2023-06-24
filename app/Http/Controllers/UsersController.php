<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller {
    public function index(Request $request) {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $limit = $validated['limit'] ?? 10;
        $users = User::query()
            ->leftJoin('users_groups', 'users_groups.id', '=', 'users.group_id')
            ->latest('users.created_at')
            ->paginate($limit, ['users.id', 'users.created_at', 'users.created_at', 'users.login', 'users.email', 'users_groups.title']);
        return view('users.index', compact('users'));
    }

    public function create() {
        $groups = DB::table('users_groups')->get();

        return view('users.create', ['groups' => $groups]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'login'     => ['required', 'string', 'max:50', 'unique:users'],
            'email'     => ['required', 'string', 'max:50', 'email', 'unique:users'],
            'password'  => ['required', 'string', 'max:50', 'min:7'],
            'group_id'  => ['required'],
        ]);

        $user = User::query()->create([
            'login'    => strtolower($validated['login']),
            'email'    => strtolower($validated['email']),
            'password' => bcrypt($validated['password']),
            'group_id' => $validated['group_id'],
        ]);

        return redirect()->route('users');
    }

    public function show(User $user) {
        return view('users.show', compact('user'));
    }

    public function edit($post) {

    }

    public function update(Request $request, $post) {

    }

    public function delete($post) {

    }
}
