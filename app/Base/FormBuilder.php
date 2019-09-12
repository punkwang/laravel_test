<?php


namespace App\Base;


use App\Helpers\Html;
use Illuminate\Support\Arr;

class FormBuilder
{
    const TYPE_HTML = "html";
    const TYPE_STATIC='static';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_CHECKBOXLIST = 'checkboxlist';
    const TYPE_DROPDOWN = 'dropdownlist';
    const TYPE_FILE = 'file';
    const TYPE_PASSWORD = 'password';
    const TYPE_RADIOBUTTONLIST = 'radiobuttonlist';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_TEXT = 'text';
    const TYPE_NUMBER='number';
    const TYPE_LISTBOX = 'listbox';
    const TYPE_HIDDEN = 'hidden';
    const TYPE_SUBMIT_BUTTON = 'submit';
    const TYPE_BUTTON = 'button';


    protected $_form;
    protected $_map;

    protected function _initMap(){
        $this->_map=[
            self::TYPE_TEXT=>function($attribute,$element){
                return $this->_renderTextInput($attribute,$element);
            },
            self::TYPE_PASSWORD=>function($attribute,$element){
                return $this->_renderPasswordInput($attribute,$element);
            },
            self::TYPE_SUBMIT_BUTTON=>function($attribute,$element){
                return $this->_renderSubmitButton($attribute,$element);
            }
        ];
    }

    protected function _renderSubmitButton($attribute,$element){
        ObContent::begin();
        ?>
        <button class="btn btn-success btn-lg btn-block" type="submit"><?=$element['label'] ?></button>
        <?php
        return ObContent::end();
    }

    protected function _renderTextInput($attribute,$element){
        $element['htmlOptions']['class'][]='form-control';
        if($this->_form->hasError($attribute)){
            $element['htmlOptions']['class'][]='is-invalid';
        }
        return Html::input('text',$attribute,$this->_form->attribute($attribute),$element['htmlOptions']);
    }

    protected function _renderPasswordInput($attribute,$element){
        $element['htmlOptions']['class'][]='form-control';
        if($this->_form->hasError($attribute)){
            $element['htmlOptions']['class'][]='is-invalid';
        }
        return Html::input('password',$attribute,$this->_form->attribute($attribute),$element['htmlOptions']);
    }

    public function __construct(Form $form)
    {
        $this->_form=$form;
        $this->_initMap();
    }

    protected function _template(){
        ObContent::begin();
        ?>
        {beginForm}
            {elements}
            <hr class="mb-4">
            {buttons}
        {endForm}
        <?php
        return ObContent::end();
    }


    private function __parse($template,$data){
        foreach ($data as $k=>$v){
            $template=str_replace('{'.$k.'}',$v,$template);
        }
        return $template;
    }

    protected function _elementTemplate($attribute,$element){
        ObContent::begin();
        ?>
        <div class="mb-3">
            <label for="<?=$attribute ?>>"><?=$this->_form->attributeLabel($attribute); ?></label>
            {element}

            <?php if($hint=$this->_form->attributeHint($attribute)): ?>
                <small class="text-muted"><?=$hint; ?></small>
            <?php endif; ?>
            <?php if($this->_form->hasError($attribute)): ?>
                <div class="invalid-feedback">
                    <?=$this->_form->firstError($attribute); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        return ObContent::end();
    }


    protected function _renderElements(){
        $elements=$this->_form->elements()['elements'];
        if(empty($elements)) return '';
        $elementItems=[];
        foreach ($elements as $attribute=>$element){
            if($element instanceof \Closure){
                $elementItems[]=$element();continue;
            }
            $elementItems[]=$this->__parse(
                $this->_elementTemplate($attribute,$element),
                [
                    'element'=>$this->_renderMapElement($attribute,$element),
                ]);
        }
        return implode('',$elementItems);
    }

    protected function _renderMapElement($attribute,$element){
      if(isset($this->_map[$element['type']])){
            $parser=$this->_map[$element['type']];
            if($parser instanceof \Closure){
                return $parser($attribute,$element);
            }
        }
    }

    protected function _renderButtons(){
        $buttons=$this->_form->elements()['buttons'];
        if(empty($buttons)) return '';
        $buttonItems=[];
        foreach ($buttons as $attribute=>$button){
            $buttonItems[]=$this->_renderMapElement($attribute,$button);
        }
        return implode('',$buttonItems);
    }

    protected function _beginForm(){
        ObContent::begin();
        ?>
        <form action="<?=$this->_form->action(); ?>" method="<?=$this->_form->method() ?>">
        <?=csrf_field(); ?>
        <?php
        return ObContent::end();
    }

    protected function _endForm(){
        ObContent::begin();
        ?>
        </form>
        <?php
        return ObContent::end();
    }



    public function view(){
        return $this->__parse($this->_template(),[
            'elements'=>$this->_renderElements(),
            'buttons'=>$this->_renderButtons(),
            'beginForm'=>$this->_beginForm(),
            'endForm'=>$this->_endForm()
        ]);
    }
}
