<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\SecretGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SecretGuestsController extends Controller
{
    private $statuses = [
        '1' => "Ожидает одобрения",
        '2' => 'На рассмотрении',
        '3' => 'Подтверждён',
        '4' => 'Отказано'
    ];

    public function index(Request $request) : View {
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

    public function store(Request $request) : RedirectResponse {
        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:50'],
            'city'               => ['required', 'string'],
            'status'             => ['required'],
            'phone'              => ['required'],
            'telegram_nickname'  => ['required', 'string', 'unique:secret_guests'],
        ]);

        $guest = SecretGuest::query()->create([
            'name'              => $validated['name'],
            'telegram_nickname' => strtolower($validated['telegram_nickname']),
            'city'              => $validated['city'],
            'status'            => $validated['status'],
            'phone'             => str_replace(['+', '(', ')', '-', ' '], '', $validated['phone']),
        ]);

        sendNewSecretNotify($guest, 'handmade');

        return redirect()->route('guests');
    }

    public function storeApi(Request $request) {
//        $validated = $request->validate([
//            'name'               => ['required', 'string', 'max:100'],
//            'city'               => ['required', 'string'],
//            'phone'              => ['required'],
//            'telegram_nickname'  => ['required', 'string', 'unique:secret_guests'],
//        ]);

        $guest = SecretGuest::query()->create([
            'name'              => $request->name,
            'telegram_nickname' => strtolower($request->telegram_nickname),
            'city'              => $request->city,
            'status'            => 1,
            'phone'             => str_replace(['+', '(', ')', '-', ' '], '', $request->phone),
        ]);

        if ($guest) {
            sendNewSecretNotify($guest);
        }


        return response('ok', 200);
    }

    public function show($id) : View {
        $guest = SecretGuest::findOrFail($id);
        $polls = Poll::query()
            ->leftJoin('spots', 'polls.spot_id', '=', 'spots.id')
            ->where('polls.secret_guest_id', $id)
            ->latest('polls.id')
            ->get(['polls.*', 'spots.title as spot_title', 'spots.city as spot_city'])
        ;

        return view('guests.show', ['entity' => $guest, 'statuses' => $this->statuses, 'polls' => $polls]);
    }

    public function edit($guest) : View {
        $guest = SecretGuest::findOrFail($guest);

        return view('guests.edit', ['entity' => $guest, 'statuses' => $this->statuses]);
    }

    public function update(Request $request, $id) : RedirectResponse {
        $guest = SecretGuest::findOrFail($id);

        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:50'],
            'city'               => ['required', 'string'],
            'status'             => ['required'],
            'phone'              => ['required'],
            'telegram_nickname'  => ['required', 'string', Rule::unique('secret_guests', 'telegram_nickname')->ignore($guest->id)],
        ]);

        if ($guest->status !== $validated['status']) {
            sendSecretGuestChangeStatus($guest, $this->statuses[$validated['status']]);
        }

        $guest->fill($validated)->save();

        return redirect()->route('guests.show', $id);
    }

    public function delete($guest) : RedirectResponse {
        $guest = SecretGuest::findOrFail($guest);

        $guest->delete();
        return redirect()->route('guests');
    }
}
