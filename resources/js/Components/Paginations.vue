<script setup> 
import { Link } from '@inertiajs/vue3'; 
const props = defineProps({
    links: {
        type: Array 
    },
    search: {
        type: String 
    }
}); 
function ver(object){
    if(object.includes('next')||object.includes('Siguiente')){
        object=">>";
    }
    if(object.includes('previous')||object.includes('Anterior')){
        object="<<";
    }
    return object;
}
</script>

<template>
    
     

      <nav>
          <ul class="pagination">
            <template v-for="(link, k) in links" :key="k">
              <li v-if="link.url === null"  :class="link.active?'page-item active':'page-item'">  
                  <div class="page-link" v-html="ver(link.label)" ></div>
              </li>
              
              <li v-else  :class="link.active?'page-item active':'page-item'"> 
                  <Link   :href="search?link.url+'&'+search:link.url"  class="page-link" style="color: #fff;
    background-color: #57B657;
    background: #57B657;
    border-color: #57B657;">{{ ver(link.label)}}</Link>
              </li>
             </template>  
          </ul>
      </nav>
    
  </template>