<?php


namespace App\Http\Controllers\Front\forms\oauth;


use App\Models\MemberOpen;
use Overtrue\Socialite\SocialiteManager;

class FacebookAuth extends OAuthForm
{
    protected $_driver='facebook';


    protected function _zone()
    {
        return MemberOpen::Zone_Facebook;
    }
}
