<?php


namespace App\Http\Controllers\Front\forms\sign;


use App\Base\Form;
use App\Base\FormBuilder;
use App\Base\ObContent;
use App\Helpers\Html;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SignInForm extends Form
{
    public $username;
    public $password;
    public $is_remember;

    protected function _rules()
    {
        return [
            'username'=>['required','max:32'],
            'password'=>['required','max:32'],
        ];
    }

    protected function _ruleMessages()
    {
        return [
            'username.required'=>'用户名必须输入',
            'password.required'=>'密码必须输入',
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码'
        ];
    }

    public function attributeHints()
    {
        return [
            'username'=>'请输入用户名',
            'password'=>'请输入您的密码'
        ];
    }

    public function elements()
    {
        return [
            'elements'=>[
                'username'=>[
                    'type'=>FormBuilder::TYPE_TEXT,
                ],
                'password'=>[
                    'type'=>FormBuilder::TYPE_PASSWORD
                ],
                'is_remember'=>function(){
                    ObContent::begin();
                    ?>
                    <div class="form-group">
                        <div class="form-check">
                            <?=Html::checkbox('is_remember',strlen($this->is_remember)>0,[
                                'class'=>'form-check-input',
                                'id'=>'is_remember'
                            ]) ?>
                            <label class="form-check-label" for="is_remember">
                                是否记住登陆状态
                            </label>
                        </div>
                    </div>
                    <?php
                    return ObContent::end();
                }
            ],
            'buttons'=>[
                'save'=>[
                    'type'=>FormBuilder::TYPE_SUBMIT_BUTTON,
                    'label'=>'立即登陆'
                ]
            ]
        ];
    }

    public function login($guard){
       $logined=$guard->attempt(
           Arr::only($this->attributes(),['username','password']),
           strlen($this->is_remember)>0
       );
       if($logined){
           return true;
       }
       $this->addError('password','账号或密码错误');
       return false;
    }
}
