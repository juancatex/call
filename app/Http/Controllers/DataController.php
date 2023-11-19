<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia; 
use Inertia\Response;
use App\Models\Data;
use App\Models\Departamento; 
use App\Models\Pdp; 
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataController extends Controller
{
     
    public function regdato(Request $request)
    { set_time_limit(0);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('data')->truncate();
        DB::table('data_calls')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
         
        ini_set('memory_limit', '1024M');
        ini_set ('max_execution_time', 3200);

        foreach ($request->datain as $key =>$dat) {
           if($key!=0){ 
            Data::create([
                'user' => $dat[1], 
                'menbresia1' => $dat[2], 
                'menbresia2' => $dat[3], 
                'rango' => $dat[4], 
                'fechaini' => $dat[6], 
                'tipouser' => $dat[7], 
                'ci' => $dat[9], 
                'patrocinador' => $dat[10], 
                'correo' => $dat[12], 
                'tel' => $dat[13], 
                'fechanac' => $dat[14], 
                'nombrecompleto' => $dat[15], 
                'dir' => $dat[18]
            ]);
  
           }
        } 
        return redirect('/data');
    }
    public function starttruncate(Request $request)
    {  
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('data')->truncate();
        DB::table('data_calls')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');  
    }
         
    public function regdatoaxios(Request $request)
    {   set_time_limit(0); 
        ini_set('memory_limit', '1024M');
        ini_set ('max_execution_time', 3200); 
        foreach ($request->datain as $key =>$dat) {
           if($key!=0){ 
            Data::create([
                'user' => $dat[1], 
                'menbresia1' => $dat[2], 
                'menbresia2' => $dat[3], 
                'rango' => $dat[4], 
                'fechaini' => $dat[6], 
                'tipouser' => $dat[7], 
                'ci' => $dat[9], 
                'patrocinador' => $dat[10], 
                'correo' => $dat[12], 
                'tel' => $dat[13], 
                'fechanac' => $dat[14], 
                'nombrecompleto' => $dat[15], 
                'dir' => $dat[18]
            ]);
  
           }
        }  
    }
    public function listarData(Request $request): Response
    {
 

        $datain=Data::orderBy('nombrecompleto');
        if(!empty($request->search)){ 
            $datain=$datain->where('nombrecompleto','like',"%".$request->search."%") ; 
        }
        // $datain=$datain->with("cambios")->with("lastCambio")->paginate(10); 
        $datain=$datain->with(["cambios"=> function (Builder $query) {
            $query->join("users","users.id","=","data_calls.iduser")
            ->leftJoin('departamentos', function($join) {
                $join->on('departamentos.iddepartamento', '=', 'data_calls.iddepartamento')->where('departamentos.activo',1);
            })
            ->leftJoin('pdps', function($join) {
                $join->on('pdps.idpdps', '=', 'data_calls.idpdp')->where('pdps.activo',1);
            })
            ->select("data_calls.*","users.name","departamentos.nomdepartamento","pdps.nompdp"); 
        }])->paginate(10); 
        
        $dep= Departamento::where('activo',1)->orderBy('iddepartamento')->get();  
        $Pdp= Pdp::where('activo',1)->orderBy('idpdps')->get();  
 
        return Inertia::render('Calling', [ 
            'datain' =>  $datain,
            'dep' => $dep ,
            'pdp' => $Pdp,
            'search' => (empty($request->search))?'':$request->search,
        ]);
    }
  
}
