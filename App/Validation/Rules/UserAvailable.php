<?php
/**
 * Created by PhpStorm.
 * User: Emre Ak
 * Date: 26.11.2016
 * Time: 16:03
 */

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\User;

class UserAvailable extends AbstractRule{

    public function validate($input){
        return User::where('_id', $input)->count() === 0;
    }


}

?>