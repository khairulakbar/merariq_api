<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $table = 'tb_info_user';
    protected $guarded = ['id'];
}
