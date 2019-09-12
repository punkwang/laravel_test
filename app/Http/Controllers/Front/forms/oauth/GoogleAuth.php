<?php


namespace App\Http\Controllers\Front\forms\oauth;


use App\Models\MemberOpen;

class GoogleAuth extends OAuthForm
{
    protected $_driver='google';

    protected function _callbackUrl()
    {
        return route('oauth_google_redirect');
    }

    protected function _zone()
    {
        return MemberOpen::Zone_Google;
    }

    public function isLogined(){
        $memberOpen=$this->memberOpen();

    }
}
