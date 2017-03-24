<?php

namespace App\Auth;

use App\Models\User;

class Auth
{
    public function attempt($email, $password){

        $user = User::where("_email", $email)->first();

        if($user){
            if($user['_password'] == sha1($password)){
                $_SESSION['user'] = $user['_id'];

                return true;
            }
        }

        return false;
    }


}

?>