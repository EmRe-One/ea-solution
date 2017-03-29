<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;


class EmailAvailable extends AbstractRule {

    public function validate( $input ) {

        var_dump(trim(strtolower($input)));

        return ( User::where( '_email', $input )->count() === 0 );
    }

}

?>