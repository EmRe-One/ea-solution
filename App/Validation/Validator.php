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
                $e->findMessages([
                    'alnum' => '{{name}} darf nur Buchstaben und Ziffern enthalten',
                    'alpha' => '{{name}} darf nur Buchstaben enthalten',
                    'email' => 'Die Email-Adresse ist fehlerhaft',
                    'equals' => 'Die Passwörter stimmen nicht überein',
                    'notEmpty' => 'Dieses Feld ist erforderlich',
                    'noWhitespace' => '{{name}} darf keine Leerzeichen beinhalten'
                ]);

                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

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