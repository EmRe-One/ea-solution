<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator{

    protected $errors;

    public function validate($body, array $rules){

        foreach ($rules as $field => $rule){
            try{
                $rule->setName(ucFirst($field))->assert($body[$field]);
            }catch (NestedValidationException $e){
                //$this->errors[$field] = $e->getMessages()[0];
                $this->errors['message'] = $e->getMessages()[0];
            }
        }

        return $this;

    }

    public function failed(){
        return !empty($this->errors);
    }

    public function getErrors(){
        return $this->errors;
    }

}

?>