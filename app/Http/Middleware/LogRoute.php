<?php

namespace App\Http\Middleware;

use App\Interfaces\LoggingInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Strategy\DatabaseLogStrategy;
use App\Strategy\FileLogStrategy;
use Illuminate\Support\Facades\Log;

class LogRoute
{
  private $logging;

  public function __construct()
  {
    $this->logging = \config('logger.url') === 'file-system' ? new FileLogStrategy() : new DatabaseLogStrategy();
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $response = $next($request);

    $this->logging->writeLog($request, $response);

    return $response;
  }
}
