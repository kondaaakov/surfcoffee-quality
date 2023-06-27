<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersProfiles;
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
            ->paginate($limit, [
                'users.id', 'users.created_at', 'users.created_at', 'users.login', 'users.email',
                'users_groups.title',
                'users.firstname', 'users.lastname'
            ]);
        return view('users.index', compact('users'));
    }

    public function create() {
        $groups = DB::table('users_groups')->get();

        return view('users.create', ['groups' => $groups]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'login'              => ['required', 'string', 'max:50', 'unique:users'],
            'email'              => ['required', 'string', 'max:50', 'email', 'unique:users'],
            'password'           => ['required', 'string', 'max:50', 'min:7'],
            'group_id'           => ['required'],
            'firstname'          => ['required', 'string'],
            'lastname'           => ['required', 'string'],
            'phone'              => ['required'],
            'telegram_nickname'  => ['string'],
        ]);

        $user = User::query()->create([
            'login'             => strtolower($validated['login']),
            'email'             => strtolower($validated['email']),
            'password'          => bcrypt($validated['password']),
            'group_id'          => $validated['group_id'],
            'firstname'         => $validated['firstname'],
            'lastname'          => $validated['lastname'],
            'phone'             => str_replace(['+', '(', ')', '-', ' '], '', $validated['phone']),
            'telegram_nickname' => strtolower($validated['telegram_nickname']),
        ]);

        //dd($user->id);

        return redirect()->route('users');
    }

    public function show($id) {
        $user = User::findOrFail($id);
        $group = DB::table('users_groups')->where(["id" => $user->group_id])->first('title');

        return view('users.show', ['user' => $user, 'group' => $group]);
    }

    public function edit($user) {

    }

    public function update(Request $request, $post) {

    }

    public function delete($post) {

    }
}
