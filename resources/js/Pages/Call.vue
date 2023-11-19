<script setup>
import Menu from '@/Layouts/Menu.vue'; 
import { Head, Link, useForm,router } from '@inertiajs/vue3';
import {ref,onMounted} from 'vue';  
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import moment from 'moment'; 
const props =defineProps({ 
    datain: {
        type: Object,
    },
    dep: {
        type: Object,
    },
    pdp: {
        type: Object,
    },
    search: {
        type: String,
    },
    reg: {
        type: Number,
    },
});
var years=getantiguedad();  
var anios=getanios();  
const form = useForm({ 
    reg:props.reg?(props.reg):1,
    status:0,
    search:props.search?(props.search):'',
    iddata:props.datain?(props.datain.iddata):null,  
    telmod:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.telmod?props.datain.last_cambio.telmod:props.datain.tel):props.datain.tel):null, 
    correomod: props.datain?(props.datain.last_cambio?(props.datain.last_cambio.correomod?props.datain.last_cambio.correomod:props.datain.correo):props.datain.correo):null, 
    contacto:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.contacto?props.datain.last_cambio.contacto:null):null):null, 
    iddepartamento:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.iddepartamento?props.datain.last_cambio.iddepartamento:null):null):null, 
    idpdp:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.idpdp?props.datain.last_cambio.idpdp:null):null):null, 
    dirmod:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.dirmod?props.datain.last_cambio.dirmod:props.datain.dir):props.datain.dir):null,
    obs:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.obs?props.datain.last_cambio.obs:null):null):null,
    obs1:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.obs1?props.datain.last_cambio.obs1:null):null):null,
    obs2:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.obs2?props.datain.last_cambio.obs2:null):null):null,
    obs3:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.obs3?props.datain.last_cambio.obs3:null):null):null,
    obs4:props.datain?(props.datain.last_cambio?(props.datain.last_cambio.obs4?props.datain.last_cambio.obs4:null):null):null
});
 function getantiguedad(){
    var years=0;
    if(props.datain!=null&&props.datain.fechaini!=null){ 
    const iniciotrabajo=moment(props.datain.fechaini); 
    var hoy=moment();
    var anios=hoy.diff(iniciotrabajo,"years");
    years=anios;
    }
    return years;
 }
 function getanios(){
    var years=0;
    if(props.datain!=null&&props.datain.fechanac!=null){ 
    const iniciotrabajo=moment(props.datain.fechanac); 
    var hoy=moment();
    var anios=hoy.diff(iniciotrabajo,"years");
    years=anios;
    }
    return years;
 }
 
const procesar=async (tipo)=>{ 
    switch (tipo) {
        case 1:
        form.status=0;  
            break; 
        case 2:
        form.status=2;  
            break; 
        case 3:
        form.status=3;  
            break; 
    }
    if(form.reg>1){
        form.post(route('regllamada'),{onSuccess:()=>{ok('Registrado correctamente')}}); 
    }else{const alerta=Swal.mixin({buttonsStyling:true});
    alerta.fire({
        title:'¿Desea continuar con mas llamadas una vez concluido el registro?',
        icon:'question',showCancelButton:true,
        confirmButtonText:'<i class="ti-check"></i> Si',
        cancelButtonText:'<i class="ti-close"></i> No'
    }).then(
        (result)=>{
            Swal.fire({
            title: "Procesando datos...",
            allowOutsideClick: () => false,
            allowEscapeKey: () => false,
            showConfirmButton: false, 
            showCancelButton: false, 
            willOpen: function() {
                Swal.showLoading();
            }
        });
            if(result.isConfirmed){ 
                form.reg=1; 
            }else{
                form.reg=0; 
            } 
            form.post(route('regllamada'),{onSuccess:()=>{ok('Registrado correctamente')}});  
        }
    );}
    
} 
 
const ok =(msj)=>{ 
    form.reset();
    form.clearErrors(); 
    Swal.fire({title:msj,icon:'success'}); 
};
   
 
onMounted(async () => {  
    
})
</script>

<template>
    <Head title="Llamada" /> 
    <Menu>  
  <div v-if="datain" class="row">
      <div class="col-12 grid-margin">
          <div class="card">
              <div class="card-body">
                  <h4 class="card-title">Registro de la llamada</h4>
                  <div class="form-sample">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="exampleInputUsername1">Usuario/Codigo</label>
                                  <input type="text" class="form-control" id="exampleInputUsername1" :value="datain.user" readonly>  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="ci">CI/NIT</label>
                                  <input type="text" class="form-control" id="ci" :value="datain.ci" readonly>
                              </div>
                          </div> 
                      </div>  
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="exampleInputUsername2">Nombre y Apellido</label>
                                  <input type="text" class="form-control" id="exampleInputUsername2" :value="datain.nombrecompleto" readonly>  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Telefono">Telefono</label>
                                  <input type="text" class="form-control" id="Telefono" v-model="form.telmod">
                              </div>
                          </div> 
                      </div>  
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Electronico">Correo Electronico</label>
                                  <input type="text" class="form-control" id="Electronico" v-model="form.correomod">  
                              </div>
                          </div>
                          <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Opcion de Contacto</label>
                                    <select class="form-control" :class="form.errors.contacto?'errorinput':''" id="exampleFormControlSelect2" v-model="form.contacto">
                                        <option value="null"  disabled >Seleccione</option>
                                        <option value="Whatsapp">Whatsapp</option>
                                        <option value="SMS">SMS</option>
                                        <option value="llamada Telefono Fijo">llamada Telefono Fijo</option> 
                                    </select> 
                                </div>
                          </div> 
                      </div> 
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Patrocinador">Patrocinador</label>
                                  <input type="text" class="form-control" id="Patrocinador" :value="datain.patrocinador" readonly>  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Contacto">Opcion de Contacto (Membresia)</label>
                                  <input type="text" class="form-control" id="Contacto" :value="datain.menbresia1" readonly>
                              </div>
                          </div> 
                      </div>  
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Opcion">Opcion de Contacto (Membresia2)</label>
                                  <input type="text" class="form-control" id="Opcion" :value="datain.menbresia2" readonly>  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Contacto1">Opcion de Contacto (Rango)</label>
                                  <input type="text" class="form-control" id="Contacto1" :value="datain.rango" readonly>
                              </div>
                          </div> 
                      </div> 
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Tiempo">Tiempo en la Empresa</label>
                                  <input type="text" class="form-control" id="Tiempo" :value="years+' años'" readonly>  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Tipo">Tipo de Usuario</label>
                                  <input type="text" class="form-control" id="Tipo" :value="datain.tipouser" readonly>
                              </div>
                          </div> 
                      </div> 
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Nacimiento">Fecha de Nacimiento</label>
                                  <input type="text" class="form-control" id="Nacimiento" :value="datain.fechanac" readonly>  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Edad">Edad</label>
                                  <input type="text" class="form-control" id="Edad" :value="anios+' años'" readonly>
                              </div>
                          </div> 
                      </div> 
                      <div class="row">
                        <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="Departamento">Departamento</label>
                                    <select class="form-control" v-model="form.iddepartamento">  
                                        <option value="null"  disabled >Seleccione Departamento</option>
                                        <option v-for="op in dep" :key="op.iddepartamento" :value="op.iddepartamento"  :selected="op.iddepartamento==form.iddepartamento">
                                            {{ op.nomdepartamento }}
                                        </option>
                                    </select> 
                                </div> 
                          </div>
                          <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="Compra">PDP de Compra</label>
                                    <select class="form-control" v-model="form.idpdp">  
                                        <option value="null"  disabled >Seleccione PDP</option>
                                        <option v-for="op in pdp" :key="op.idpdps" :value="op.idpdps"  :selected="op.idpdps==form.idpdp">
                                            {{ op.nompdp }} 
                                        </option>
                                    </select> 
                                </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="dir">Dirección</label>
                                  <input type="text" class="form-control" id="dir" v-model="form.dirmod" placeholder="Ingrese su dirección">  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Observaciones">Observaciones</label>
                                  <input type="text" class="form-control" id="Observaciones" v-model="form.obs" placeholder="Ingrese una observación">
                              </div>
                          </div> 
                      </div> 
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Observaciones2" class="blockquote-footer text-info">Observaciones 1</label>
                                  <input type="text" class="form-control" id="Observaciones2" v-model="form.obs1" placeholder="Ingrese una observación">  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Observaciones3" class="blockquote-footer text-info">Observaciones 2</label>
                                  <input type="text" class="form-control" id="Observaciones3" v-model="form.obs2" placeholder="Ingrese una observación">
                              </div>
                          </div> 
                      </div> 
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Observaciones4" class="blockquote-footer text-info">Observaciones 3</label>
                                  <input type="text" class="form-control" id="Observaciones4" v-model="form.obs3" placeholder="Ingrese una observación">  
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="Observaciones5" class="blockquote-footer text-info">Observaciones 4</label>
                                  <input type="text" class="form-control" id="Observaciones5" v-model="form.obs4" placeholder="Ingrese una observación">
                              </div>
                          </div> 
                      </div> 
                    
                    <div class="row">
                        <button type="button" class="btn btn-info col-sm-4 col-sm-2  col-lg-2 m-2" @click="procesar(1)">Guardar</button>
                        <button type="button" class="btn btn-success col-sm-4 m-2" @click="procesar(2)">Finalizar con exito</button>
                        <button type="button" class="btn btn-danger col-sm-4 m-2" @click="procesar(3)">Finalizar sin exito</button>
                    </div>
                    </div>
              </div>
          </div>
      </div>
  </div>
  <div v-else class="roww">
No Data
  </div>
    </Menu>
</template>
