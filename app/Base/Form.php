<?php


namespace App\Base;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Form
{
    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected $_validator;
    protected function _rules(){
        return [];
    }

    protected function _iniValidate($attributes=[]){
        if(!empty($attributes)){
            //print_r( Arr::only($this->_rules(),$attributes));exit;
            $this->_validator= Validator::make(Arr::only($this->attributes(),$attributes), Arr::only($this->_rules(),$attributes), $this->_ruleMessages());
        }else{
            $this->_validator= Validator::make($this->attributes(), $this->_rules(), $this->_ruleMessages());
        }
    }

    public function validate($attributes=[]){
        $this->_iniValidate($attributes);
        return !$this->_validator->fails();
    }

    public function attributes(){
        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[$property->getName()] = $this->{$property->getName()};
            }
        }
        return $names;
    }

    protected function _ruleMessages(){
        return [];
    }


    public function loadRequest($data){
        $attributes=$this->_safe();
        if(empty($attributes)) return;
        foreach ($attributes as $index=>$name){
            if(isset($data[$name])){
                $this->{$name}=$data[$name];
            }
        }
    }

    public function elements(){
        return [];
    }

    public function attributeLabels(){
        return [];
    }

    public function attributeHints(){
        return [];
    }

    public function attributeHint($attribute){
        if(isset($this->attributeHints()[$attribute])){
            return $this->attributeHints()[$attribute];
        }
    }

    public function attributeLabel($attribute){
        if(isset($this->attributeLabels()[$attribute])){
            return $this->attributeLabels()[$attribute];
        }
        return ucfirst($attribute);
    }

    public function attribute($attribute){
        return $this->attributes()[$attribute];
    }

    /**
     * @return FormBuilder
     */
    protected function _builder(){
        return new FormBuilder($this);
    }

    public function view(){
        return $this->_builder()->view();
    }

    public function hasErrors(){
        return $this->_validator->fails();
    }

    public function hasError($attribute){
        if(!$this->_validator) return false;
        $errors=$this->_validator->errors();
        return $errors->has($attribute);
    }

    public function firstError($attribute=''){
        $errors=$this->_validator->errors();
        if(strlen($attribute)>0){
            return $errors->first($attribute);
        }

        $errors->first();
    }

    public function addError($attribute,$errorMessage=''){
        if(!$this->_validator){
            $this->_iniValidate();
        }
        $this->_validator->getMessageBag()->add($attribute,$errorMessage);
    }


    public function action(){
        return request()->fullUrl();
    }

    public function method(){
        return 'POST';
    }

    protected function _safe(){
        return array_keys($this->attributes());
    }

}
