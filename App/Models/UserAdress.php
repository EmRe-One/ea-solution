<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @SWG\Definition(
 *      definition="userAdressModel",
 *      required={"adress_id", "user_id", "stadt",
 *                "bezirk", "viertel", "strasse",
 *                "geo_lng", "geo_lat", "zusaetzliches"},
 *      @SWG\Property(
 *          property="adress_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="stadt",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="bezirk",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="viertel",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="strasse",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="geo_lng",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="geo_lat",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="zusaetzliches",
 *          type="string"
 *      )
 * )
 */
class UserAdress extends Model{

    protected $table = 'tbl_adress';

    protected $primaryKey = '_adress_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "_adress_id",
        "_user_id",
        "_stadt",
        "_bezirk",
        "_viertel",
        "_strasse",
        "_geo_lng",
        "_geo_lat",
        "_zusaetzliches"
    ];

}

?>