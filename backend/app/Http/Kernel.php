<?php

namespace App\Http;

class Kernel
{
   protected $middleware = [
      \Fruitcake\Cors\CorsService::class,
      // Egyéb middleware-ek...
   ];
}
