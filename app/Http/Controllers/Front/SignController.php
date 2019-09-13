<?php


namespace App\Http\Controllers\Front;


use App\Http\Controllers\Front\forms\sign\SignInForm;
use App\Http\Controllers\Front\forms\sign\SignupForm;
use Illuminate\Http\Request;

class SignController extends Base
{
    public function in(Request $request,SignInForm $form){

        if($request->isMethod('POST')){
            $form->loadRequest($request->all());
            if($form->validate()){
                if($form->login($this->_guard())){
                    return $this->_redirect('home','登陆成功');
                }
            }
        }
        return $this->_view('sign.in',[
            'form'=>$form
        ]);
    }

    public function up(Request $request,SignupForm $form){
        if($request->isMethod('POST')){
            $form->loadRequest($request->all());
            if($form->validate()&&$form->save()){
                return $this->_redirect('signin','注册成功，可以使用账号登陆');
            }
        }
        return $this->_view('sign.up',[
            'form'=>$form
        ]);
    }

    public function out(Request $request){
        $this->_guard()->logout();
        $request->session()->invalidate();

        return redirect(route('home'));
    }

    public function __construct()
    {
        $this->middleware('guest:web,home')->except('out');
    }
}
