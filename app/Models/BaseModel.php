<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/4/19
 * Time: 17:31
 */


namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BaseModel extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['deleted_at', 'extra'];
}
