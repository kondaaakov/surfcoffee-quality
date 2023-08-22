<?php

use App\Http\Controllers\SecretGuestsController;
use App\Models\SecretGuest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/telegramNicknames', function () {
    $users = User::query()->where('group_id', '!=', '3')->get('telegram_nickname')->toArray();
    $secret_guests = SecretGuest::query()->where('status', '!=', '4')->get('telegram_nickname')->toArray();

    $entities = [];
    foreach ($users as $user) {
        $entities[] = $user['telegram_nickname'];
    }
    foreach ($secret_guests as $guest) {
        $entities[] = $guest['telegram_nickname'];
    }

    $entities = array_unique($entities);

    return response()->json($entities);
})->name('api.getTelegramNicknames');

Route::get('/checkUserGroup', function (Request $request) {
    $validated = $request->validate([
        'nickname' => ['required', 'string'],
    ]);

    $user = User::query()
        ->leftJoin('users_groups', 'users.group_id', '=', 'users_groups.id')
        ->where('users.telegram_nickname', $validated['nickname'])
        ->first('users_groups.code');

    if (!$user) {
        return response('false', 404);
    } else {
        return response($user->code, 200);
    }
})->name('api.getCheckUserGroup');

Route::post('/guests', [SecretGuestsController::class, 'storeApi'])->name('api.guests.store');

