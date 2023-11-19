<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Data extends Model
{
    use HasFactory;
    protected $fillable = ['user','menbresia2','rango','fechaini','tipouser','ci','patrocinador','correo','menbresia1','fechanac','nombrecompleto','tel'];
    protected $primaryKey = 'iddata';    
    
    public function cambios():HasMany 
    {
        return $this->hasMany(DataCall::class,"iddata");
    }
    public function lastCambio():HasOne 
    {
        // return $this->hasOne(DataCall::class,"iddata")->ofMany('edadgest', 'max');
        return $this->hasOne(DataCall::class,"iddata")->where('status', '<',9)->latest();
    }
}
