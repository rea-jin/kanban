<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
     //===ここから追加===
    //hasMany設定
    public function cards()
    {
        return $this->hasMany('App\Models\Card');
    }
    //===ここまで追加===
}
