<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['consultant_id', 'client_id','title','message','sender','status'];

    public function documents(){
        return $this->hasMany(MessageDocument::class);
    }
}
