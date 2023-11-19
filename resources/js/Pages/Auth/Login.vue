<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Inicio" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0" style="    background: #797b83d4;">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo" style="text-align: center;">
                <img src="images/logo.svg" alt="logo">
              </div>
              <h4>Ingrese sus credenciales</h4> 
              <form @submit.prevent="submit" class="pt-3"> 
                <div class="form-group">
                   
                  <TextInput
                    id="exampleInputEmail1"
                    type="email"
                    class="form-control form-control-lg"
                    v-model="form.email"
                    required
                    autofocus 
                    placeholder="Correo Electronico"
                />
            
                </div>
                <div class="form-group"> 
                  <TextInput
                    id="exampleInputPassword1"
                    type="password"
                    class="form-control form-control-lg"
                    v-model="form.password"
                    required 
                    placeholder="Contraseña"
                /> 
                </div>
                <InputError class="text-danger" :message="form.errors.password" />
                <InputError class="text-danger" :message="form.errors.email" />

                <div class="mt-3"> 
                  <PrimaryButton class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Ingresar
                </PrimaryButton>

                </div> 
                 
              </form>
            </div>
          </div>
        </div>
      </div> 
    </div>  
    </GuestLayout>
</template>
