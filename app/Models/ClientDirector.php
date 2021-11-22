<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDirector extends Model
{
    use HasFactory;

    protected $fillable = ['consultant_id', 'client_id', 'name', 'units_held', 'designation'];
}
