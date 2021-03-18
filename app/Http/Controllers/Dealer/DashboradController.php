<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboradController extends Controller
{
    public function index(){
        return view('dealers.index');
    }
    public function logout()
    {

        $gaurd = $this->getGaurd();
        $gaurd->logout();

        return redirect()->route('dealer.login');
    }
    private function getGaurd()
    {
        return auth('dealer');
    }
}
