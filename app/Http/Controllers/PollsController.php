<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Poll;
use App\Models\PollCategory;
use App\Models\SecretGuest;
use App\Models\Spot;
use App\Models\Template;
use Intervention\Image\Facades\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PollsController extends Controller
{
    public function index($id) : View {

        $encrypt     = encrypt_decrypt('decrypt', $id);
        $parameters  = explode(", ", $encrypt);
        $parameters  = [
            'poll_id' => $parameters[0]
        ];

        $poll = Poll::findOrFail($parameters['poll_id']);

        if ($poll->closed == 1) {
            abort(404, "Опрос закрыт");
        } else if (Carbon::now() > $poll->until_at) {
            abort(404, "Дата опроса просрочена");
        }


        $spotTitle = DB::table('spots')->select('title')->where('id', $poll->spot_id)->first();
        $spotTitle = "Surf Coffee® x $spotTitle->title";


        $pollsCategories = buildTreePoll(PollCategory::query()->where('poll_id', $poll->id)->get()->toArray());

        return view('polls.poll', ['title' => $spotTitle, 'categories' => $pollsCategories, 'pollId' => $parameters['poll_id']]);

        // сборка пулла: сам пулл, данные о кофейне, данные о сроке ДО, категории
        // передача всех этих данных в шаблон
    }

    public function create() : View {
        $guests = SecretGuest::query()->where("status", 3)->get();
        $templates = Template::query()->where('active', 1)->get();
        $spots = Spot::query()->where([['status', 'worked'], ['active', 1]])->get();
        $plus3Days = Date('Y-m-d', strtotime('+3 days'));

        return view('polls.create', ['templates' => $templates, 'guests' => $guests, 'spots' => $spots, 'days' => $plus3Days]);
    }

    public function store(Request $request) : RedirectResponse {

        $validated = $request->validate([
            'template_id'     => ['required', 'integer'],
            'spot_id'         => ['required', 'integer'],
            'secret_guest_id' => ['required', 'integer'],
            'until_at'        => ['required', 'date'],
        ]);

        $template      = Template::query()->where('id', $validated['template_id'])->first();
        $categoriesIds = getIdsOfCildrens(unserialize($template->categories));

        $poll = Poll::query()->create([
            'template_id'     => $validated['template_id'],
            'spot_id'         => $validated['spot_id'],
            'secret_guest_id' => $validated['secret_guest_id'],
            'until_at'        => $validated['until_at'],
        ]);

        foreach ($categoriesIds as $categoryId) {
            $pollId = $poll->id;
            $category = Category::query()->where('id', $categoryId)->first();

            PollCategory::query()->create([
                'poll_id' => $pollId,
                'category_id' => $category->id,
                'weight' => $category->weight,
            ]);
        }

        // отправка опроса и криптовой ссылки тайнику в ЛС с информацией

        return redirect()->route('polls');
    }

    public function answer(Request $request) : RedirectResponse {
        $poll = Poll::find($request['poll_id']);

        if ($request->isMethod('post') && isset($request['poll_id']) && $poll->closed == 0) {
            $categoriesOfPoll = PollCategory::query()->where('poll_id', $request['poll_id'])->get()->toArray();

            $data = $request->validate([
                'comment' => ['nullable'],
                'receipt' => ['required', 'file', 'mimes:jpg,bmp,png,heic,jpeg,gif']
            ]);

            $rates = [];
            foreach ($request->toArray() as $key => $item) {
                if (str_contains($key, "cat_")) {
                    $id = str_replace('cat_', '', $key);
                    $rate = (int) $item / 5 * 100;

                    $rates[$id] = $rate;
                }
            }

            $categories = [];
            foreach ($categoriesOfPoll as $item) {
                $categories[$item['category_id']] = [
                    'weight' => $item['weight'],
                    'category_id' => $item['category_id'],
                    'rate' => $rates[$item['category_id']] ?? 0,
                    'result' => isset($rates[$item['category_id']]) ? $rates[$item['category_id']] * $item['weight'] : 0
                ];
            }

            $categories = buildTreePoll($categories, true);

            $pollResult = 0;
            foreach ($categories as $category) {
                if ($category['include_in'] == 0) {
                    $pollResult += $category['result'];
                }
            }
            $pollResult = 0.01 * (int) ( $pollResult * 100 );
            $now        = Carbon::now();
            $file       = $request->file('receipt');
            $fileName   = "poll_{$request['poll_id']}_{$now->format('Y_m_d_H_i_s')}.{$file->extension()}";

            $path = Storage::putFileAs(
                'public/receipts', $file, $fileName
            );

            $poll->fill([
                'result' => $pollResult,
                'closed' => 1,
                'closed_at' => $now,
                'receipt' => $fileName,
                'comment' => $request['comment'] ?? ''
            ])->save();

            foreach ($categories as $category) {
                DB::table('polls_categories')
                    ->where(
                        [
                            ['category_id', $category['id']],
                            ['poll_id', $request['poll_id']]
                        ]
                    )->update(
                        [
                            'weight' => $category['weight'],
                            'rate'   => $category['rate'],
                            'result' => $category['result']
                        ]
                    )
                ;
            }

        }

        return redirect()->route('poll.thanks');
    }

    public function thanks() : View {
        return view('polls.thanks', []);
    }

    public function show($id) : View {
        $poll = Poll::query()
            ->leftJoin('templates', 'polls.template_id', '=', 'templates.id')
            ->leftJoin('secret_guests', 'polls.secret_guest_id', '=', 'secret_guests.id')
            ->leftJoin('spots', 'polls.spot_id', '=', 'spots.id')
            ->select([
                'polls.id', 'polls.created_at', 'polls.template_id', 'polls.secret_guest_id', 'polls.spot_id', 'polls.closed', 'polls.until_at', 'polls.closed_at', 'polls.result', 'polls.comment', 'polls.receipt',
                'templates.title as template_title',
                'secret_guests.name as guest_name', 'secret_guests.city as guest_city',
                'spots.title as spot_title', 'spots.city as spot_city',
            ])
            ->findOrFail($id)
        ;

        $pollsCategories = buildTreePoll(PollCategory::query()->where('poll_id', $poll->id)->get()->toArray());

        return view('polls.show', ['poll' => $poll, 'categories' => $pollsCategories]);
    }

    public function list(Request $request) : View {
        $validated = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page'  => ['nullable', 'integer', 'min:1'],
            'template_id' => ['nullable', 'integer', 'min:1']
        ]);

        $limit = $validated['limit'] ?? 25;

        if (isset($validated['template_id'])) {
            $polls = Poll::query()
                ->leftJoin('templates', 'polls.template_id', '=', 'templates.id')
                ->leftJoin('secret_guests', 'polls.secret_guest_id', '=', 'secret_guests.id')
                ->leftJoin('spots', 'polls.spot_id', '=', 'spots.id')
                ->where([['template_id', $validated['template_id']]])
                ->oldest('polls.id')
                ->paginate($limit, [
                    'polls.id', 'polls.created_at', 'polls.template_id', 'polls.secret_guest_id', 'polls.spot_id', 'polls.closed', 'polls.until_at', 'polls.closed_at', 'polls.result',
                    'templates.title as template_title',
                    'secret_guests.name as guest_name', 'secret_guests.city as guest_city',
                    'spots.title as spot_title', 'spots.city as spot_city',
                ]);
        } else {
            $polls = Poll::query()
                ->leftJoin('templates', 'polls.template_id', '=', 'templates.id')
                ->leftJoin('secret_guests', 'polls.secret_guest_id', '=', 'secret_guests.id')
                ->leftJoin('spots', 'polls.spot_id', '=', 'spots.id')
                ->oldest('polls.id')
                ->paginate($limit, [
                    'polls.id', 'polls.created_at', 'polls.template_id', 'polls.secret_guest_id', 'polls.spot_id', 'polls.closed', 'polls.until_at', 'polls.closed_at', 'polls.result',
                    'templates.title as template_title',
                    'secret_guests.name as guest_name', 'secret_guests.city as guest_city',
                    'spots.title as spot_title', 'spots.city as spot_city',
                ]);
        }

        return view('polls.index', ['polls' => $polls]);
    }

    public function close($id) : RedirectResponse {
        $poll = Poll::findOrFail($id);
        $poll->fill([
            'closed'    => 1,
            'closed_at' => Carbon::now()
        ])->save();

        // отправка в бот сообщение тайнику о том, что опрос закрыт преждевременно

        return redirect()->route('polls');
    }
}
