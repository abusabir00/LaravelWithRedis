<?php

namespace App\Services;

use App\Models\Person;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class PersonService
{

  /**
   * Get Data with redis to Display a listing of the resource.
   */

  public function getPersonsData($request)
  {
    // Set parameters into session 
    if(isset($request->year) && isset($request->month)){
      Session::put('year', $request->year);
      Session::put('month', $request->month);
    }
    if(!isset($request->year) && !isset($request->month) && !isset($request->page)){
      Session::put('year', '');
      Session::put('month', '');
    }
    $year = Session::get('year');
    $month = Session::get('month');
    // Set data into redies
    $key = $year.'-'.$month;
    if(!Redis::exists($key)){
        $data = Person::query();
        if($request->year) {
            $data = $data->whereYear('birthdate', '=', $request->year);
        }
        if($request->year) {
            $data = $data->whereMonth('birthdate', '=', $request->month);
        }
        $data = $data->get();
        Redis::set($key,  $data, 'EX', 60);
    }

    $data = collect(json_decode(Redis::get($key)));
    $data = $data->paginate(20);
    return $data;
  }


}
