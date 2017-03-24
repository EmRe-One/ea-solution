<?php
/**
 * Created by PhpStorm.
 * User: Emre Ak
 * Date: 26.11.2016
 * Time: 16:04
 */

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class UserAvailableException extends ValidationException{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'User is not found.'
        ]
    ];

}