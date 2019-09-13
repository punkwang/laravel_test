<?php


namespace App\OAuth;


use Illuminate\Support\ServiceProvider;
use Overtrue\Socialite\SocialiteManager;

class OAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('oauth',function(){
            $config=config('oauth.info');
            foreach ($config as $k=>$v){
                $config[$k]['redirect']=route($v['redirect']);
            }
            return new SocialiteManager($config);
        });
    }
}
