<?php


namespace App\Http\Controllers\Front\forms\oauth;


use App\Models\MemberOpen;
use App\OAuth\OAuth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Overtrue\Socialite\SocialiteManager;

class OAuthForm
{
    protected $_driver='';

    public $open_id;


    protected function _zone(){
        return '';
    }

    public function redirect(){
        return OAuth::driver($this->_driver)->redirect();
    }

    /**
     * @return \Overtrue\Socialite\User
     */
    public function user(){
        return OAuth::driver($this->_driver)->user();
    }

    private $_memberOpen=null;

    /**
     * @return MemberOpen|bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getMemberOpen(){
        if($this->_memberOpen!=null) return $this->_memberOpen;
        $user=$this->user();
        if(!$user){
            return null;
        }
        $this->_memberOpen=MemberOpen::query()
            ->where('zone',$this->_zone())
            ->where('open_id',$user->getId())
            ->first();
        if(!$this->_memberOpen){
            $this->_memberOpen=new MemberOpen();
            $this->_memberOpen->open_id=$user->getId();
            $this->_memberOpen->zone=$this->_zone();
            $this->_memberOpen->member_id=0;
            $this->_memberOpen->token=$user->getToken();
            $this->_memberOpen->info=json_encode($user->toArray());
            if(!$this->_memberOpen->save()){
                return null;
            }
        }
        return $this->_memberOpen;
    }

    public function __construct()
    {

    }

    public function isSuss(){
        $open=$this->getMemberOpen();
        return  $open;
    }


    public function isBinding(){
       return  $this->getMemberOpen()->member_id>0;
    }

    public function binding($member_id){
        $this->getMemberOpen()->member_id=$member_id;
        return $this->getMemberOpen()->save();
    }

    const OPEN_ID_KEY='open_id';

    public function saveOpenId(){
       session()->put(self::OPEN_ID_KEY,$this->getMemberOpen()->id);
    }


    public function validate(){
        $this->open_id=intval(session()->get(self::OPEN_ID_KEY));
        if(!$this->open_id) return false;

        $this->_memberOpen=MemberOpen::query()->where('id',$this->open_id)->first();
        if(!$this->_memberOpen) return false;

        return true;
    }

    public function login(SessionGuard $guard){

        $guard->login($this->getMemberOpen()->member,true);
        return true;
    }

}
