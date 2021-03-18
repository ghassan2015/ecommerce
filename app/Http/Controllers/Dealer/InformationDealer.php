<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformationDealer extends Controller
{
    public function information($id){
        return $id;
    }
}
