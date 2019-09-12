<?php


namespace App\Http\Controllers\Front;


use App\Base\Message;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class Base extends Controller
{
    protected function _view($view = null, $data = [], $mergeData = []){
        return view("front.{$view}",$data,$mergeData);
    }

    protected function _redirect($name,$messageText=null,$messageType=Message::TYPE_Info){
        if($messageText){
            Message::show($messageText,$messageType);
        }
        return redirect(route($name));
    }

    /**
     * @return Guard
     */
    protected function _guard()
    {
        return Auth::guard('web');
    }
}
