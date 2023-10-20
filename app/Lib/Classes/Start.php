<?php
namespace App\Lib\Classes;
use App\Lib\Interfaces\TelegramOperator;

class Start extends TelegramOperator
{

    public function initCheck()
    {
        return ($this->telegram->message_type=="message"&&$this->telegram->text=="/start");
    }

    public function handel()
    {
        sendMessage([
            'chat_id' => $this->telegram->chat_id,
            'text'=>'start!'
        ]);
    }
}
