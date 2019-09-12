<?php


namespace App\Http\Controllers\Front\forms\oauth;


use App\Models\MemberOpen;
use Overtrue\Socialite\SocialiteManager;

class FacebookAuth extends OAuthForm
{
    protected $_driver='facebook';

    protected function _callbackUrl()
    {
        return route('oauth_facebook_redirect');
    }

    protected function _zone()
    {
        return MemberOpen::Zone_Facebook;
    }
}
