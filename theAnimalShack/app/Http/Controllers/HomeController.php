<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;
use App\adoptRequest;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index()
  {
    $animals = Animal::all()->toArray();
    $adoptRequests = adoptRequest::all()->toArray();

    //return view('animals.index', compact('animals'));
    return view('home', compact('animals','adoptRequests'));
  }
}
