<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // You can change the Taable Name Here
    protected $table = 'posts';

    // You can change the Primery Key here
    public $primaryKey = 'id'; 

    // Time Stamps
    public $timestamps = true;

    public function user(){
        // Below line saya a single post belongs to a specific user
        return $this->belongsTo('App\User');
    }
}
