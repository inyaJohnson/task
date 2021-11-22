<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSubsidiary extends Model
{
    use HasFactory;

    protected $fillable = ['consultant_id', 'client_id', 'name', 'percentage_holding', 'nature', 'nature_of_business'];
}
