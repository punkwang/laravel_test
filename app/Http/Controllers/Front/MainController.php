<?php


namespace App\Http\Controllers\Front;


class MainController extends Base
{
    public function index(){
        return $this->_view('main.index');
    }
}
