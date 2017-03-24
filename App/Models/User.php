<?php

namespace App\Models;

use App\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @SWG\Definition(
 *      definition="userModel",
 *      required={"vorname", "name", "email", "password"},
 *      @SWG\Property(
 *          property="id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="vorname",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="token",
 *          type="string"
 *      )
 * )
 */
class User extends Model
{

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

    public function getAdress($id)
    {

        $adress = Adress::where('_user_id', $id) - first();
        if (!$adress) {
            $adress = Adress::create([
                '_adress_id' => UUID::v4(),
                '_user_id' => $id
            ]);
        }

        return $adress;
    }

}

?>