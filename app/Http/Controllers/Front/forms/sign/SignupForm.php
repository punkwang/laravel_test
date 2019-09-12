<?php


namespace App\Http\Controllers\Front\forms\sign;


use App\Base\Form;
use App\Base\FormBuilder;
use App\Models\Member;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Hash;

class SignupForm extends Form
{
    public $username;
    public $password;
    public $password2;

    protected function _rules()
    {
        return [
            'username'=>['required','max:32','min:6','unique:member'],
            'password'=>['required','max:32','min:6'],
            'password2'=>['required','max:32','min:6','same:password'],
        ];
    }

    protected function _ruleMessages()
    {
        return [
            'username.required'=>'用户名必须输入',
            'password.required'=>'密码必须输入',
            'password2.required'=>'确认密码必须输入',
            'password2.same'=>'密码输入不一致',
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'password2'=>'确认密码',
        ];
    }

    public function attributeHints()
    {
        return [
            'username'=>'请输入用户名',
            'password'=>'请输入您的密码',
            'password2'=>'请再次输入您的密码',
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
                'password2'=>[
                    'type'=>FormBuilder::TYPE_PASSWORD
                ],
            ],
            'buttons'=>[
                'save'=>[
                    'type'=>FormBuilder::TYPE_SUBMIT_BUTTON,
                    'label'=>'立即注册'
                ],
            ]
        ];
    }

    protected $_member=null;

    public function save(){
        $this->_member=new Member();
        $this->_member->username=$this->username;
        $this->_member->password=Hash::make($this->password);
        if(!$this->_member->save()){
            $this->addError('username','创建出错！');
            return false;
        }

        return true;
    }

    public function login(SessionGuard $guard){
        $guard->login($this->_member,true);
        return true;
    }
}
