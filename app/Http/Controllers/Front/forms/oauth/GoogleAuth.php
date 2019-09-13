<?php


namespace App\Http\Controllers\Front\forms\oauth;


use App\Models\MemberOpen;

class GoogleAuth extends OAuthForm
{
    protected $_driver='google';


    protected function _zone()
    {
        return MemberOpen::Zone_Google;
    }

    public function isLogined(){
        $memberOpen=$this->memberOpen();

    }
}
