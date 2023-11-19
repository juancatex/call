<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataCall extends Model
{
    use HasFactory;
    protected $fillable = ['iddata','iduser','iddepartamento','idpdp','contacto','correomod','telmod','dirmod','obs','obs1','obs2','obs3','obs4','fechareg','status'];
    protected $primaryKey = 'iddatacall';    
}
