<?php

namespace App\Lib\Interfaces;

use App\Models\Account;
use Illuminate\Support\Facades\Cache;

class TelegramVariables
{
    public $message_type, $data, $text, $chat_id, $from_id;
    public $user = null;

    public function __construct($update)
    {
        $this->update = $update;
        $this->message_type = messageType($update);
        if ($this->message_type == "callback_query") {
            $this->data = $update["callback_query"]['data'];
            $this->chat_id = $update["callback_query"]['message']['chat']['id'];
            $this->message_id = $update["callback_query"]["message"]['message_id'];
            $this->text = $update["callback_query"]['message']['text'] ?? "";
//            $username = $update["callback_query"]['from']['username'];
//            $name = $update["callback_query"]['from']['first_name'];
        } elseif ($this->message_type == "channel_post" || $this->message_type == "channel_photo") {
            $this->text = $update['channel_post']['text'] ?? "//**";
            $this->chat_id = $update['channel_post']['chat']['id'] ?? "";
            $this->from_id = $update['channel_post']['from']['id'] ?? "";
            $this->message_id = $update['channel_post']['message_id'] ?? "";
            $this->reply_to_message = $update['channel_post']['reply_to_message']['message_id'] ?? "";
            $username = $update['channel_post']['from']['username'] ?? "";
            $name = $update['channel_post']['from']['first_name'] ?? "";
        } else {
            $this->text = $update['message']['text'] ?? "//**";
            $this->chat_id = $update['message']['chat']['id'] ?? "";
            $this->from_id = $update['message']['from']['id'] ?? "";
            $this->message_id = $update['message']['message_id'] ?? "";
            $this->reply_to_message = $update['message']['reply_to_message']['message_id'] ?? "";
            $username = $update['message']['from']['username'] ?? "";
            $name = $update['message']['from']['first_name'] ?? "";
        }

        $chat_id = $this->chat_id;
        $user = Cache::remember('useraccount' . $this->chat_id, now()->addSeconds(20), function () use ($chat_id) {

        });
        if (isset($username)) {
            $user->username = $username;
            $user->account_name = $name;
//        $user->name = $name;
            $user->save();
        }
        $this->user = $user;


    }

}
