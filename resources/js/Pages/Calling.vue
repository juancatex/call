<script setup>
import Menu from '@/Layouts/Menu.vue'; 
import { Head, Link, useForm,router} from '@inertiajs/vue3';
import {ref,onMounted,watch} from 'vue';  
import Swal from 'sweetalert2';
import { debounce } from 'lodash';
import 'sweetalert2/src/sweetalert2.scss';
import Pagination from '@/Components/Paginations.vue'; 

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
    }
});
const searchField=ref(props.search); 
const verhistorico=ref([]); 
watch(searchField, debounce(() => { 
    router.get('/listaLlamadas', {search: searchField.value}, {preserveState: true, preserveScroll: true, only: ['datain']})
}, 300));
const form = useForm({
    iddata: 0, 
    reg: 2,
    search:searchField.value
});
   
const ok =(msj)=>{ 
    form.reset();
    form.clearErrors(); 
    Swal.fire({title:msj,icon:'success'});
};
    function procesar(prodata) {   
        form.iddata=prodata;
        form.search=searchField.value;
        form.post(route('llamadaid')); 
    }
    function Ver(datain) {
        console.log(datain.cambios); 
        verhistorico.value=datain.cambios;
        $("#verModal").modal();
    }
    function closemodal() { 
        $("#verModal").modal("hide");
    }
onMounted(async () => {  
 
})
</script>

<template>
    <Head title="Llamadas" /> 
    <Menu>  
   <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="card-title">Listado de datos</h4> 
                         
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text bg-success text-white"><i class="icon-search menu-icon"></i></span>
                                  </div>
                                  <input type="text" class="form-control" v-model="searchField" placeholder="Ingrese el nombre a buscar"> 
                              </div>
                          </div>

                          <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Usuario</th>
                                          <th>Correo Electronico</th>
                                          <th>Estado</th> 
                                          <th>Opciones</th> 
                                      </tr>
                                  </thead>
                                  <tbody> 
                                      <tr v-for="datainonly in datain.data" :key="datainonly.iddata">
                                            <td>{{ datainonly.nombrecompleto}}</td> 
                                            <td>{{ datainonly.correo }}</td> 
                                            <td>    
                                                <label v-if="datainonly.status==0" class="badge badge-info">sin procesar</label> 
                                                <label v-if="datainonly.status==1" class="badge badge-warning">En atención</label> 
                                                <label v-if="datainonly.status==2" class="badge badge-success">Finalizado con exito</label>
                                                <label v-if="datainonly.status==3" class="badge badge-danger">Finalizado sin exito</label>
                                            </td> 
                                            <td>       
                                                      <button v-if="datainonly.status<=1" type="button" class="btn btn-sm  btn-outline-primary btn-icon-text" @click="procesar(datainonly)" >
                                                          <i class="icon-microphone menu-icon"></i>
                                                       Llamar
                                                      </button >
                                                      <button v-else  type="button" class="btn btn-sm  btn-info btn-icon-text" @click="Ver(datainonly)" >
                                                          <i class="icon-eye menu-icon"></i>
                                                       Ver historico
                                                      </button>
                                             </td> 
                                        </tr>
                                  </tbody>
                              </table>
                             
                          </div>
                          <pagination class="mt-6" :links="datain.links" :search="'search='+searchField"/>
                      </div>
                  </div>
              </div>
   </div> 

   
                  <div class="modal fade" id="verModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Historico de registros</h5>
                          <button type="button" class="close" @click="closemodal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Usuario</th>
                                          <th>Contacto</th>
                                          <th>Telefono</th>
                                          <th>Correo Electronico</th>
                                          <th>Dirección</th> 
                                          <th>Departamento</th> 
                                          <th>PDP</th> 
                                          <th>Obs</th>
                                          <th>Obs1</th>
                                          <th>Obs2</th>
                                          <th>Obs3</th>
                                          <th>Obs4</th>
                                          <th>Estado</th> 
                                          <th>Fecha Registro</th> 
                                      </tr>
                                  </thead>
                                  <tbody> 
                                      <tr v-for="dahis in verhistorico" :key="dahis.iddatacall">
                                            <td>{{ dahis.name}}</td> 
                                            <td>{{ dahis.contacto}}</td> 
                                            <td>{{ dahis.telmod}}</td> 
                                            <td>{{ dahis.correomod }}</td> 
                                            <td>{{ dahis.dirmod }}</td>  
                                            <td>{{ dahis.nomdepartamento }}</td>  
                                            <td>{{ dahis.nompdp }}</td>  
                                            <td>{{ dahis.obs }}</td>  
                                            <td>{{ dahis.obs1 }}</td>  
                                            <td>{{ dahis.obs2 }}</td>  
                                            <td>{{ dahis.obs3 }}</td>  
                                            <td>{{ dahis.obs4 }}</td>  
                                            <td>    
                                                <label v-if="dahis.status==0" class="badge badge-info">Guardado</label> 
                                                <label v-if="dahis.status==10" class="badge badge-warning">En atención</label> 
                                                <label v-if="dahis.status==2" class="badge badge-success">Finalizado con exito</label>
                                                <label v-if="dahis.status==3" class="badge badge-danger">Finalizado sin exito</label>
                                            </td>  
                                            <td> {{ dahis.fechareg }} </td> 
                                        </tr>
                                  </tbody>
                              </table>
                             
                          </div>
                        </div>
                        <div class="modal-footer"> 
                          <button type="button" class="btn btn-outline-danger btn-fw" @click="closemodal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>

    </Menu>
</template>
