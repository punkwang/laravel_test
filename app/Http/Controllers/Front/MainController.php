<?php


namespace App\Http\Controllers\Front;


use App\Models\Member;





class MainController extends Base
{
    public function index(){
        return $this->_view('main.index');
    }
}
