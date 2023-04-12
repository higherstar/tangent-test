<?php

namespace App\Strategy;

use App\Interfaces\LoggingInterface;
use Illuminate\Support\Facades\DB;

class DatabaseLogStrategy implements LoggingInterface
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

      DB::table('loggings')->insert([
        'data' => json_encode($log)
      ]);
    }
  }
}
