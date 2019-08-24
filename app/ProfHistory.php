<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfHistory extends Model
{
    protected $guarded = array('id');
    
    public static $rules = array(
        'prof_id' => "required",
        'prof_edit_at' => "required",
        );
}
