<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class M_TelTenant extends Model
{
    // use Authenticatable, CanResetPassword;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tel_tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tel_id','name', 'phone1', 'phone2','phone3',
        'birth_year', 'birth_month', 'birth_day',
        'gender', 'address', 'job', 'notice',
        'person1_name', 'person1_phone1','person1_phone2','person1_phone3','person1_notice',
        'person2_name', 'person2_phone1','person2_phone2','person2_phone3','person2_notice',
        ];
    
}
