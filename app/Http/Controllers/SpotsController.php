<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Spot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SpotsController extends Controller
{

    private array $statuses = [
        'worked' => "Работает",
        'not_worked' => 'Не работает',
    ];

    public function index(Request $request) : View {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $limit = $validated['limit'] ?? 12;

        $spots = Spot::query()
//            ->where([
//                ['external_id', '>', 210],
//                ['title', 'like', '%Dyb%']
//            ])
            ->oldest('external_id')
            ->paginate($limit, ['id', 'external_id', 'title', 'city', 'status', 'active']);

        return view('spots.index', ['spots' => $spots, 'statuses' => $this->statuses]);
    }

    public function create() : View {
        return view('spots.create', ['statuses' => $this->statuses]);
    }

    public function store(Request $request) : RedirectResponse {
        $validated = $request->validate([
            'external_id' => ['required', 'integer'],
            'title'       => ['required', 'string'],
            'city'        => ['required', 'string'],
            'status'      => ['required'],
        ]);

        Spot::query()->create([
            'external_id' => $validated['external_id'],
            'title'       => trim($validated['title']),
            'city'        => trim($validated['city']),
            'status'      => $validated['status'],
        ]);

        return redirect()->route('spots');
    }

    public function show($id) : View {
        $spot = Spot::findOrFail($id);
        $polls = Poll::query()
            ->where([['polls.spot_id', $id], ['polls.closed', 1], ['polls.result', '!=', 'null']])
            ->leftJoin('secret_guests', 'polls.secret_guest_id', '=', 'secret_guests.id')
            ->oldest("polls.id")
            ->get(['polls.*', 'secret_guests.name as guest_name', 'secret_guests.city as guest_city']);

        return view('spots.show', ['spot' => $spot, 'statuses' => $this->statuses, 'polls' => $polls, 'some' => $some]);
    }

    public function edit($id) : View {
        $spot = Spot::findOrFail($id);

        return view('spots.edit', ['spot' => $spot, 'statuses' => $this->statuses]);
    }

    public function update(Request $request, $id) : RedirectResponse {
        $spot = Spot::findOrFail($id);

        $validated = $request->validate([
            'title'       => ['required', 'string'],
            'city'        => ['required', 'string'],
            'status'      => ['required'],
            'external_id' => ['required', 'integer'],
        ]);

        $spot->fill($validated)->save();

        return redirect()->route('spots.show', $id);
    }

    public function delete($id) {

    }

    public function archive($id) : RedirectResponse {
        $spot = Spot::findOrFail($id);
        $spot->fill(['active' => 0])->save();

        return redirect()->route('spots.show', $id);
    }

    public function unarchive($id) : RedirectResponse {
        $spot = Spot::findOrFail($id);
        $spot->fill(['active' => 1])->save();

        return redirect()->route('spots.show', $id);
    }
}
