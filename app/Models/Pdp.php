<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdp extends Model
{
    use HasFactory;
    protected $fillable = ['nompdp','activo'];
    protected $primaryKey = 'idpdps';  
}
