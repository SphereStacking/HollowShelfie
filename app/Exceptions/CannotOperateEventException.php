<?php

namespace App\Exceptions;

use Exception;

class CannotOperateEventException extends Exception
{
    // HTTPステータスコード
    protected $code = 403;

    // エラーメッセージ
    protected $message = 'このイベントを操作することはできません。';

}
