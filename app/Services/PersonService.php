<?php

namespace App\Services;

use App\Models\Person;
use Illuminate\Support\Facades\Redis;

class PersonService
{

  /**
   * Get Data with redis to Display a listing of the resource.
   */

  public function getPersonsData($request)
  {
    $key = $request->year.'-'.$request->month;
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
