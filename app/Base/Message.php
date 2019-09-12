<?php


namespace App\Base;


class Message
{
    const Type_Primary='primary';
    const Type_Secondary='secondary';
    const Type_Success='success';
    const Type_Danger='danger';
    const Type_Warning='warning';
    const TYPE_Info='info';

    const Session_Flash_Key='ses_fl_key';




    static public function show($text,$type){
        session()->flash(self::Session_Flash_Key,[
            'text'=>$text,
            'type'=>$type
        ]);
    }

    static public function has(){
        return session()->has(self::Session_Flash_Key);
    }

    static public function render(){
        $msg=session()->get(self::Session_Flash_Key);
        if(!$msg) return;
        ObContent::begin();
        ?>
        <div class="alert alert-<?=$msg['type'] ?>" role="alert">
            <?=$msg['text']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        return ObContent::end();
    }
}
