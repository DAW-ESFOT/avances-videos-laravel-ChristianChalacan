<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\False_;

class Admin extends Model
{
    protected $fillable = ['credential_number'];
    public $timestamps = false;
    public function user(){
        return $this->morphOne('App\Models\User', 'userable');
    }
}
