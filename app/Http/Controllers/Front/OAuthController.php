<?php


namespace App\Http\Controllers\Front;


use App\Base\Message;
use App\Http\Controllers\Front\forms\oauth\FacebookAuth;
use App\Http\Controllers\Front\forms\oauth\GoogleAuth;
use App\Http\Controllers\Front\forms\oauth\OAuthForm;
use App\Http\Controllers\Front\forms\sign\SignInForm;
use App\Http\Controllers\Front\forms\sign\SignupForm;
use App\Models\MemberOpen;
use Illuminate\Http\Request;

class OAuthController extends Base
{
    public function facebook(){
        $form=new FacebookAuth();
        return $form->redirect();
    }

    public function facebookRedirect(){
        $form=new FacebookAuth();
        if($form->isSuss()){
            if(!$form->isBinding()){
                $form->saveOpenId();
                return $this->_redirect('oauth_bind','请绑定系统账号');
            }
            if($form->login($this->_guard())){
                return $this->_redirect('home','登陆成功');
            }
        }
    }

    public function google(){
        $form=new GoogleAuth();
        return $form->redirect();
    }

    public function googleRedirect(){
        $form=new GoogleAuth();
        if($form->isSuss()){
            if(!$form->isBinding()){
                $form->saveOpenId();
                return $this->_redirect('oauth_bind','请绑定系统账号');
            }
            if($form->login($this->_guard())){
                return $this->_redirect('home','登陆成功');
            }
        }
    }

    public function bind(Request $request){
        $authForm=new OAuthForm();
        if(!$authForm->validate()){
            return $this->_redirect('home','请先授权登陆',Message::Type_Danger);
        }
        $signinForm=new SignInForm();
        if($request->isMethod('POST')){
            $signinForm->loadRequest($request->all());
            if($signinForm->validate()&&$signinForm->login($this->_guard())){
                if($authForm->binding($this->_guard()->user()->id)){
                    return $this->_redirect('home','登陆并成功绑定');
                }
            }
        }
        return $this->_view('oauth.bind',[
            'form'=>$signinForm,
        ]);
    }

    public function bindSignup(Request $request){
        $authForm=new OAuthForm();
        if(!$authForm->validate()){
            return $this->_redirect('home','请先授权登陆',Message::Type_Danger);
        }
        $signupForm=new SignupForm();
        if($request->isMethod('POST')){
            $signupForm->loadRequest($request->all());
            if($signupForm->validate()&&$signupForm->save()&&$signupForm->login($this->_guard())){
                if($authForm->binding($this->_guard()->user()->id)){
                    return $this->_redirect('home','注册并成功绑定');
                }
            }
        }
        return $this->_view('oauth.bind_signup',[
            'form'=>$signupForm,
        ]);
    }
}
