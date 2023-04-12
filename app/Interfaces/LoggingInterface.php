<?php

namespace App\Interfaces;

Interface LoggingInterface
{
  public function writeLog($request, $response);
}