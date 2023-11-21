<script setup>
import Menu from '@/Layouts/Menu.vue'; 
import { Head, Link, useForm } from '@inertiajs/vue3';
import {ref,onMounted} from 'vue'; 
import readXlsxFile,{readSheetNames} from 'read-excel-file';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss'

const archivof = ref();
var aizefile = '';
const archivotext = ref();
const fileinput = ref(null);
var filedata = []; 
const loading = ref(false);
function eventocargar() {
    archivof.value.click();
}

const form = useForm({
    datain: [], 
});
async function previewFiles(events) { 
    filedata = new Array(); 
    fileinput.value=events.target.files[0];
    loading.value=true;  
    var shetin = await readSheetNames(fileinput.value);
    aizefile='';
    for (let insheet = 0; insheet < shetin.length; insheet++) {
        const sheett = shetin[insheet];
        var dataxls = await readXlsxFile(fileinput.value, { sheet: sheett });
        filedata.push(dataxls);
        aizefile+=sheett+':'+(dataxls.length-1)+' ';
    }

     
    // form.datain=filedata; 
    loading.value=false;
    archivotext.value=fileinput.value.name; 
    
} 
    const procesar=async ()=>{ 
    
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
        form.post(route('regdato'),{onSuccess:()=>{ok('Procesado correctamente')}}); 
} 
const procesaraxios = async ()=>{
    startpro();
    try {
                    await axios.post("/starttruncate"); 
                    var posi=0;
                    var sizema=filedata.length;  
                    for (var element of filedata){
                       
                        posi++;
                        var valuestatus=parseInt((posi*100)/sizema); 
                        $('.progress-bar[id="save"]').css('width', valuestatus+'%').attr('aria-valuenow', valuestatus).text(valuestatus+'%');  
                        $('#text_saving').text('Procesando la hoja Nº'+posi);
                            await axios.post('regdatoaxios',{
                                'datain':element
                            }); 
                    } 
                    ok("Procesado correctamente");
                } catch (error) {
                    console.log(error);
                }
}
const ok =(msj)=>{ 
    form.reset();
    form.clearErrors(); 
    Swal.fire({title:msj,icon:'success'});
};
const startpro =()=>{ 
    Swal.fire({
        title: "Registrando los Datos",
        html: '<div class="progress" style="height: 22px;"><div id="save" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">0%</div></div> <span id="text_saving" style="font-size: 13px;"></span>',
        allowOutsideClick: () => false,
        allowEscapeKey:() => false,
        showConfirmButton:false,
        showCancelButton:false
        }); 
};
   
 
onMounted(async () => {  
})
</script>

<template>
    <Head title="Data" /> 
    <Menu>  
  
          <div class="row">
              <div class="col-12 grid-margin">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="card-title">Gestion de la información</h4>
                          <div v-if="!loading" class="form-sample">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <label>Archivo Excel</label>
                                          <input type="file" ref="archivof"  @change="previewFiles" class="file-upload-default">
                                          <div class="input-group col-xs-12">
                                              <input type="text"   v-model="archivotext"  class="form-control file-upload-info" disabled
                                                  placeholder="Seleccionar archivo .xls, .xlsx">
                                              <span class="input-group-append">
                                                  <button class="btn btn-success" @click="eventocargar"
                                                      type="button">Cargar</button>
                                              </span>
                                          </div>
                                          <p v-if="filedata.length>0" class="card-description">Se cargaron  <b>{{ aizefile }}</b> registros.</p>
                                      </div>
                                      
                                  </div>
                                 
                              </div>
                              <button  v-if="filedata.length>0"  @click="procesaraxios" class="btn btn-primary mr-2">Procesar</button>
                          </div>
                          <div v-else>
                            Cargando datos...
                          </div>
                      </div>
                  </div>
              </div>
          </div>
    </Menu>
</template>
