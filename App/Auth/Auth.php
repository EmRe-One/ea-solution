<?php

namespace App\Auth;

use App\Models\User;

class Auth
{
    public function attempt($email, $password){

        $user = User::where("_email", $email)->first();

        if(!$user){
            $_SESSION['errors'] = ['email' => ['Email ist entweder falsch oder nicht registriert.']];
            return false;
        }

        if( password_verify( $password, $user['_password']) ){
            $_SESSION['user'] = $user['_id'];

            return true;
        }

        $_SESSION['errors'] = ['password' => ['Password falsch. Versuchen Sie es erneut.']];

        return false;
    }

    public function check() {
        return isset($_SESSION['user']);
    }

    public function user() {
        if ( $this->check() ){
            return User::where('_id', $_SESSION['user'])->first();
        }else{
            return NULL;
        }
    }

    public function logout() {
        unset($_SESSION['user']);
    }
}

?>