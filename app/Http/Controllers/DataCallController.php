<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\DataCall; 
use App\Models\Data; 
use App\Models\Departamento; 
use App\Models\Pdp; 
use Inertia\Inertia; 
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataCallController extends Controller
{
    public function callstart(Request $request): Response
    { 
            if (DataCall::join("data","data.iddata","=","data_calls.iddata")
                ->where('data.status', '=',1)
                ->where('data_calls.status', '=',9)
                ->whereDate('fechareg', DB::raw('CURRENT_DATE'))
                ->where('data_calls.iduser', '=', Auth::id())->exists()) {
              
              $callin=DataCall::select("data.*")
              ->join("data","data.iddata","=","data_calls.iddata")
              ->where('data.status', '=',1)
              ->where('data_calls.status', '=',9)
              ->whereDate('fechareg', DB::raw('CURRENT_DATE'))
              ->where('data_calls.iduser', '=', Auth::id()) 
              ->first();
              $datain= Data::where('iddata',$callin->iddata)->with("cambios")->with("lastCambio")->first();
              
            }else{ 
                $aux=Data::where('status', '=',0);
                $datain=Data::where('status', '=',1)
                ->whereDate('statusfecha',"<", DB::raw('CURRENT_DATE'))
                ->union($aux) 
                ->inRandomOrder()
                ->with("cambios")->with("lastCambio")
                ->first(); 
               if($datain){ 
                Data::where('iddata',$datain->iddata)->update(['status' => 1,'statusfecha' => DB::raw('CURRENT_DATE')]);
                DataCall::create(['iddata' => $datain->iddata,'iduser' =>Auth::id(),'status' => 9]);
               }
            }
            $dep= Departamento::where('activo',1)->orderBy('iddepartamento')->get();  
            $Pdp= Pdp::where('activo',1)->orderBy('idpdps')->get();  
            return Inertia::render('Call', [ 
                'datain' => $datain ,
                'dep' => $dep ,
                'pdp' => $Pdp 
            ]); 
    }
    public function callstartid(Request $request): Response
    {       $datain=Data::where('iddata', '=',$request->iddata) 
                ->with("cambios")->with("lastCambio")
                ->first(); 
               if($datain){ 
                Data::where('iddata',$datain->iddata)->update(['status' => 1,'statusfecha' => DB::raw('CURRENT_DATE')]);
                DataCall::create(['iddata' => $datain->iddata,'iduser' =>Auth::id(),'status' => 9]);
               } 
            $dep= Departamento::where('activo',1)->orderBy('iddepartamento')->get();  
            $Pdp= Pdp::where('activo',1)->orderBy('idpdps')->get();  
            return Inertia::render('Call', [ 
                'datain' => $datain ,
                'dep' => $dep ,
                'pdp' => $Pdp,
                'reg' => $request->reg,
                'search' => $request->search
            ]); 
    }
    public function callstart2(Request $request): RedirectResponse
    { 
        switch ($request->reg) {
            case 0: 
                return redirect('/dashboard');
                break; 
            case 1:
                return redirect('/llamada'); 
                break; 
            case 2: 
                return redirect()->route('listaLlamadas', ['search' => $request->search]);
                break;
        }        
    }
    public function regllamada(Request $request):RedirectResponse
    {  
        Data::where('iddata',$request->iddata)->update(['status' => $request->status,'statusfecha' => DB::raw('CURRENT_DATE')]); 
        DataCall::where('status', '=',9)->update(['status' => 10]);
        $llam=DataCall::create([
            'iddata' => $request->iddata,
            'iduser' => Auth::id(),
            'iddepartamento' => $request->iddepartamento,
            'idpdp' => $request->idpdp,
            'contacto' => $request->contacto,
            'telmod' => $request->telmod,
            'dirmod' => $request->dirmod,
            'correomod' => $request->correomod,
            'obs' => $request->obs,
            'obs1' => $request->obs1,
            'obs2' => $request->obs2,
            'obs3' => $request->obs3,
            'obs4' => $request->obs4,
            'status' =>  $request->status 
        ]);    
       
        return redirect()->route('callstart2', ['reg' => $request->reg,'search' => $request->search]);
    }
}
