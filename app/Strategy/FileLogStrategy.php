<?php

namespace App\Strategy;

use App\Interfaces\LoggingInterface;
use Illuminate\Support\Facades\Log;

class FileLogStrategy implements LoggingInterface
{
  public function writeLog($request, $response)
  {
    if (app()->environment('local')) {
      $log = [
        'URI' => $request->getUri(),
        'METHOD' => $request->getMethod(),
        'REQUEST_BODY' => $request->all(),
        'RESPONSE' => $response->getContent()
      ];

      Log::info(json_encode($log));
    }
  }
}
