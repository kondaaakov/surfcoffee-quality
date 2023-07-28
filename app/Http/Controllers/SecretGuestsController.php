<?php

namespace App\Http\Controllers;

use App\Models\SecretGuest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SecretGuestsController extends Controller
{
    private $statuses = [
        '1' => "Ожидает одобрения",
        '2' => 'На рассмотрении',
        '3' => 'Подтверждён',
        '4' => 'Отказано'
    ];

    public function index(Request $request) {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $limit = $validated['limit'] ?? 25;
        $guests = SecretGuest::query()
            ->latest('created_at')
            ->paginate($limit, ['id', 'created_at', 'name', 'telegram_nickname', 'phone', 'city', 'status']);
        return view('guests.index', ['guests' => $guests, 'statuses' => $this->statuses]);
    }

    public function create() {
        return view('guests.create', ['statuses' => $this->statuses]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:50'],
            'city'               => ['required', 'string'],
            'status'             => ['required'],
            'phone'              => ['required'],
            'telegram_nickname'  => ['required', 'string', 'unique:secret_guests'],
        ]);

        $guest = SecretGuest::query()->create([
            'name'              => strtolower($validated['name']),
            'telegram_nickname' => strtolower($validated['telegram_nickname']),
            'city'              => $validated['city'],
            'status'            => $validated['status'],
            'phone'             => str_replace(['+', '(', ')', '-', ' '], '', $validated['phone']),
        ]);

        return redirect()->route('guests');
    }

    public function show($guest) {
        $guest = SecretGuest::findOrFail($guest);

        return view('guests.show', ['entity' => $guest, 'statuses' => $this->statuses]);
    }

    public function edit($guest) {
        $guest = SecretGuest::findOrFail($guest);

        return view('guests.edit', ['entity' => $guest, 'statuses' => $this->statuses]);
    }

    public function update(Request $request, $id) {
        $guest = SecretGuest::findOrFail($id);

        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:50'],
            'city'               => ['required', 'string'],
            'status'             => ['required'],
            'phone'              => ['required'],
            'telegram_nickname'  => ['required', 'string', Rule::unique('secret_guests', 'telegram_nickname')->ignore($guest->id)],
        ]);

        $guest->fill($validated)->save();

        return redirect()->route('guests.show', $id);
    }

    public function delete($guest) {
        $guest = SecretGuest::findOrFail($guest);

        $guest->delete();
        return redirect()->route('guests');
    }
}
