<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $update = Telegram::commandsHandler(true);

        // You can also handle normal messages here
        if ($update->getMessage()) {
            $chatId = $update->getMessage()->getChat()->getId();
            
            // Example response for basic message
            if (!$update->getMessage()->hasCommand()) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Barchasi joyida, biz sizning xabaringizni qabul qildik.'
                ]);
            }
        }

        return response('OK', 200);
    }
}
