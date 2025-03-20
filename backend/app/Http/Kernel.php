<?php

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
   protected $middleware = [
      // Globális middleware-ek
      \Fruitcake\Cors\CorsService::class,
      \App\Http\Middleware\LogPageVisit::class,
   ];

   protected $routeMiddleware = [
      // Route-specifikus middleware-ek
      'auth' => \App\Http\Middleware\Authenticate::class, // Laravel alapértelmezett auth middleware
      'admin' => \App\Http\Middleware\AdminMiddleware::class, // AdminMiddleware regisztrálása
   ];
}
