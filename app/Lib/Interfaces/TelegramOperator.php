<?php

namespace App\Lib\Interfaces;
abstract class TelegramOperator
{
    public $user,$update,$class_status,$telegram;

    public function __construct($update,TelegramVariables $telegram)
    {
        $this->update = $update;
        $this->telegram = $telegram;
        if ($this->initCheck()) {
            $this->handel();
            $this->class_status =  true;

        }
    }
    abstract public function initCheck();

    abstract public function handel();

}
