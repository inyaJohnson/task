<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageDocument extends Model
{
    use HasFactory;

    protected $fillable = [ 'consultant_id', 'client_id', 'message_id', 'url'];
}
