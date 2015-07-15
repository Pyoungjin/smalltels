<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tels_event extends Model
{
    // use Authenticatable, CanResetPassword;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tels_event';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tels_id', 'user_id', 'event_contents'];

}
