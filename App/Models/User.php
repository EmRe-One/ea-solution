<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

    use SoftDeletes;

    protected $table = 'tbl_user';

    protected $primaryKey = '_id';
    public $incrementing = false;

    const CREATED_AT = '_created_at';
    const UPDATED_AT = '_updated_at';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        "_id",
        "_vorname",
        "_name",
        "_email",
        "_password",
        "_token"
    ];

    protected $hidden = [
        '_password',
        '_password_reset_timestamp',
        '_password_reset_tokem',
        'deleted_at'
    ];
}

?>