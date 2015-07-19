<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_TelMember extends Model
{
    // use Authenticatable, CanResetPassword;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tel_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tel_id', 'user_id', 'roll'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token'];
}
