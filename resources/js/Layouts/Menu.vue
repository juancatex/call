<script setup> 
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link,usePage  } from '@inertiajs/vue3';
import { onMounted } from 'vue';
function clickbu() {
    var body = $('body');
    if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
}
function clickmenu() {
    $('.sidebar-offcanvas').toggleClass('active');
}
function clickmenulist() {
    $("#right-sidebar").toggleClass("open");
}

const page = usePage();

onMounted(()=>{
 
console.log(page.props.auth.user.rol);
})
</script>

<template>
     <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        
        <Link :href="route('dashboard')" class="navbar-brand brand-logo mr-1">  
            <img src="images/logo.svg" class="mr-2" alt="logo"/>
       </Link>
        <Link :href="route('dashboard')" class="navbar-brand brand-logo-mini">  
            <img src="images/logo.svg" alt="logo"/>
       </Link>

      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button"  @click="clickbu">
          <span class="icon-menu"></span>
        </button>
        
        <ul class="navbar-nav navbar-nav-right"> 
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="images/faces/user.png" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown"> 
              <DropdownLink :href="route('logout')" class="dropdown-item" method="post" as="button">
                <i class="ti-power-off text-success"></i>
                                            Cerrar session
              </DropdownLink> 
            </div>
          </li>
          
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" @click="clickmenu">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <div class="container-fluid page-body-wrapper">
         
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul v-if="page.props.auth.user.rol==0" class="nav">
          <li class="nav-item"> 
            <Link :href="route('data')" class="nav-link">  
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Data</span> 
            </Link>
          </li>
          <li class="nav-item"> 
            <Link :href="route('usuario')" class="nav-link">  
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Usuarios</span> 
            </Link>
          </li>

          <li class="nav-item"> 
            <Link :href="route('callstart2',{ reg: 1 })" class="nav-link">  
              <i class="icon-microphone menu-icon"></i>
              <span class="menu-title">LLamada</span> 
            </Link>
          </li>
          <li class="nav-item"> 
            <Link :href="route('listaLlamadas')" class="nav-link">  
              <i class="icon-microphone menu-icon"></i>
              <span class="menu-title">Listado de LLamadas</span> 
            </Link>
          </li>
           
        </ul>
        <ul v-else class="nav"> 
          <li class="nav-item"> 
            <Link :href="route('callstart2',{ reg: 1 })" class="nav-link">  
              <i class="icon-microphone menu-icon"></i>
              <span class="menu-title">LLamada</span> 
            </Link>
          </li>
          <li class="nav-item"> 
            <Link :href="route('listaLlamadas')" class="nav-link">  
              <i class="icon-microphone menu-icon"></i>
              <span class="menu-title">Listado de LLamadas</span> 
            </Link>
          </li> 
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <slot />
        </div>
      </div>
    </div>
          
    </div>
</template>
