<?php

namespace App\Controllers;

class Dashguru extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Dashboard',
    ];

    return view('users/dashboard', $data);
  }
}
