<?php


namespace App\Base;


class ObContent
{
    const TYPE_JS='js';
    const TYPE_CSS='css';

    static protected $_vars;
    static function begin($vars=[]){
        self::$_vars=$vars;
        ob_start();
        ob_implicit_flush(false);
    }

    static public function flush(){
        ob_end_flush();
    }

    static function end($filter=null,$options=[]){

        if($filter instanceof \Closure){
            return $filter(ob_get_clean(),self::$_vars);
        }else{
            switch ($filter){
                case self::TYPE_JS:
                    return preg_replace('/<.*?script.*?>/','',ob_get_clean());
                case self::TYPE_CSS:
                    return preg_replace('/<.*?style.*?>/','',ob_get_clean());
            }
        }
        return ob_get_clean();
    }
}
