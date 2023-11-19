<script setup>
import Menu from '@/Layouts/Menu.vue'; 
import { Head, Link, useForm } from '@inertiajs/vue3';
import {onMounted} from 'vue';
import Swal from 'sweetalert2';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Paginations.vue';

const props =defineProps({ 
    users: {
        type: Object,
    }
});
const form = useForm({
    id: null,
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});
const guardarDatos=()=>{
    form.post(route('register'),{onSuccess:()=>{ok('Creado correctamente')}  });
};
const ok =(msj)=>{ 
    form.reset();
    form.clearErrors(); 
    Swal.fire({title:msj,icon:'success'});
};
const eliminarUser=(id)=>{
    
    const alerta=Swal.mixin({buttonsStyling:true});
    alerta.fire({
        title:'¿Esta seguro de eliminar el registro?',
        icon:'question',showCancelButton:true,
        confirmButtonText:'<i class="ti-check"></i> Si',
        cancelButtonText:'<i class="ti-close"></i> No'
    }).then(
        (result)=>{
            if(result.isConfirmed){ 
                form.id=id;
               form.post(route('usuarioEliminar'),{onSuccess:()=>{ok('Eliminado correctamente')}  });
            } 
        }
    );
    };
onMounted(async () => {  
})
</script>

<template>
    <Head title="Usuario" /> 
    <Menu>  
          <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="card-title">Nuevo usuario</h4>
                          
                          <form class="forms-sample" @submit.prevent="guardarDatos">
                              <div class="form-group">
                                  <label for="exampleInputUsername1">Nombre de usuario</label> 
                                    <TextInput
                                        id="exampleInputUsername1"
                                        type="text"
                                        class="form-control"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        placeholder="Usuario"
                                    /> 
                                    <InputError class="text-danger" :message="form.errors.name" />
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Correo electronico</label> 
                                  <TextInput
                                    id="exampleInputEmail1"
                                    type="email"
                                    class="form-control"
                                    v-model="form.email"
                                    required
                                    placeholder="Correo electronico"
                                /> 
                                <InputError class="text-danger" :message="form.errors.email" />
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Contraseña</label> 
                                      <TextInput
                                        id="exampleInputPassword1"
                                        type="password"
                                        class="form-control"
                                        v-model="form.password"
                                        required
                                        placeholder="Contraseña"
                                    /> 
                                    <InputError class="text-danger" :message="form.errors.password" />
                                    
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputConfirmPassword1">Confirmar Contraseña</label>
                                    <TextInput
                                        id="exampleInputConfirmPassword1"
                                        type="password"
                                        class="form-control"
                                        v-model="form.password_confirmation"
                                        required
                                        placeholder="Confirmar contraseña"
                                    /> 
                                    <InputError class="text-danger" :message="form.errors.password_confirmation" />
                              </div>
                              
                                 <PrimaryButton class="btn btn-primary mr-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Registrar
                                </PrimaryButton>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="card-title">Usuarios registrados</h4> 
                          <div class="table-responsive">
                              <table class="table table-hover">
                                  <thead>
                                      <tr>
                                          <th>Usuario</th>
                                          <th>Correo Electronico</th>
                                          <th>Opciones</th> 
                                      </tr>
                                  </thead>
                                  <tbody> 
                                      <tr v-for="user in users.data" :key="user.id">
                                            <td>{{ user.name}}</td> 
                                            <td>{{ user.email }}</td> 
                                            <td >   
                                                    <button class="btn btn-sm btn-danger btn-rounded " @click="eliminarUser(user.id)">
                                                        <i class="ti-close"></i>
                                                    </button>  
                                            </td> 
                                        </tr>
                                  </tbody>
                              </table>
                             
                          </div>
                          <pagination class="mt-6" :links="users.links" />
                      </div>
                  </div>
              </div>
          </div>
         
    </Menu>
</template>
