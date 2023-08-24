<?php

use App\Models\SecretGuest;
use App\Models\Spot;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

function sendSecretGuestPoll($guestId, $poll) {
    $link             = encrypt_decrypt('encrypt', "{$poll->id}, {$poll->secret_guest_id}");
    $secretTelegramId = getSecretGuestTelegramId($guestId);

    if (!empty($secretTelegramId)) {
        $time     = Carbon::parse($poll->until_at)->format('d.m.Y');
        $spotName = Spot::query()->where('id', $poll->spot_id)->value('title');
        $text     = "Вам назначена проверка <b>SurfCoffee x $spotName</b>, которую можно пройти до <b>$time</b>.";

        return sendTelegramRequest([
            'chat_id'      => $secretTelegramId,
            'text'         => $text,
            'parse_mode'   => "HTML",
            'reply_markup' => [
                'inline_keyboard' => [
                    [['text' => '🕵️ Начать проверку', 'url' => "https://quality.surfcoffee.ru/poll/$link"]],
                ],
                'remove_keyboard' => true,
            ]
        ]);
    } else {
        return [];
    }
}

function sendSecretGuestChangeStatus(SecretGuest $guest, string $status) {
    $secretTelegramId = getSecretGuestTelegramId($guest->id);

    if (!empty($secretTelegramId)) {
        if ($status == 'На рассмотрении') {
            $text = "⏳ $guest->name, твоя заявка на секретного гостя <b>на рассмотрении</b>! ";
        } else if ($status == 'Подтверждён') {
            $text = "🥳 $guest->name, твоя заявка на секретного гостя <b>одобрена</b>! ";
        } else if ($status == 'Отказано') {
            $text = "😞 $guest->name, твоя заявка на секретного гостя <b>отказана</b>! Ты сможешь подать заявку на секретного гостя снова чуть позже!";
        }

        return sendTelegramText($secretTelegramId, $text, true);
    }

    return "";
}

function sendCreatePollNotify($poll) {
    $adminsTelegramId = getAdminsIds();

    foreach ($adminsTelegramId as $id) {
        $secretGuestName = SecretGuest::query()->where('id', $poll->secret_guest_id)->value('name');
        $spotName        = Spot::query()->where('id', $poll->spot_id)->value('title');
        $time            = Carbon::parse($poll->until_at)->format('d.m.Y');
        $text            = "🕵️ Назначена новая проверка для секретного гостя <b>$secretGuestName</b>. Спот - <b>SurfCoffee x $spotName</b>. Проверка должна состояться до <b>$time</b>.";

        sendTelegramRequest([
            'chat_id'      => $id,
            'text'         => $text,
            'parse_mode'   => "HTML",
            'reply_markup' => [
                'inline_keyboard' => [
                    [['text' => 'ℹ️ Информация об опросе', 'url' => "https://quality.surfcoffee.ru/polls/{$poll->id}"]],
                ],
                'remove_keyboard' => true,
            ]
        ]);
    }

    return "";
}

function sendNewSecretNotify($guest, $type = 'api') {
    $adminsTelegramId = getAdminsIds();

    foreach ($adminsTelegramId as $id) {
        $text = "🕵️ Новая заявка в тайные гости от <b>$guest->name</b> (@$guest->telegram_nickname) из города $guest->city.";
        $text .= $type == 'api' ? " Заявка создана через API." : " Заявка создана вручную.";

        sendTelegramRequest([
            'chat_id' => $id,
            'text' => $text,
            'parse_mode' => "HTML",
            'reply_markup' => [
                'inline_keyboard' => [
                    [['text' => 'ℹ️ Информация о заявке', 'url' => "https://quality.surfcoffee.ru/guests/{$guest->id}"]],
                ],
                'remove_keyboard' => true,
            ]
        ]);
    }

    return "";
}

function getAdminsIds() : array {
    $users = User::query()->where([['group_id', "!=", "3"], ['telegram_nickname', '!=', '']])->pluck('telegram_nickname')->toArray();
    return DB::connection('supportBot')
        ->table('bot_spy_clients')
        ->whereIn('username', $users)
        ->pluck('telegram_id')->toArray();
    ;
}

function getSecretGuestTelegramId($guestId) {
    $telegramNickname = SecretGuest::query()->where('id', $guestId)->value('telegram_nickname');
    return DB::connection('supportBot')
        ->table('bot_spy_clients')
        ->where('username', $telegramNickname)
        ->orWhere('telegram_id', $telegramNickname)
        ->value('telegram_id')
    ;
}

function sendTelegramText($id, string $text, bool $removeKeyboard = false) : array {
    if ($removeKeyboard) {
        $message = [
            'chat_id'      => $id,
            'text'         => $text,
            'parse_mode'   => "HTML",
            'reply_markup' => [
                'remove_keyboard' => $removeKeyboard
            ]
        ];
    } else {
        $message = [
            'chat_id'    => $id,
            'parse_mode' => "HTML",
            'text'       => $text
        ];
    }

    return sendTelegramRequest($message);
}

function sendTelegramRequest($data, $method = 'sendMessage') {
    $curl    = curl_init( 'https://api.telegram.org/bot6566897746:AAFnRqBZpWG-RprkWDybmAyx9scUj5K_QmQ/' . $method);
    $payload = json_encode($data);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = json_decode(curl_exec($curl), true);

    curl_close($curl);

    return $result;
}
