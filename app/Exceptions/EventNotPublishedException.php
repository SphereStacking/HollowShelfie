<?php

namespace App\Exceptions;

use Exception;

class EventNotPublishedException extends Exception
{
    // HTTPステータスコード
    protected $code = 404;

    // エラーメッセージ
    protected $message = 'The event is not published.';
}
