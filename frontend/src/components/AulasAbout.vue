<template>
    <div> 
        <v-img
          alt="acercade"
          class="shrink mr-2"
          contain
          :src="require('../assets/acerca.png')"
          transition="scale-transition"
          width="100%"
        />
        <router-link to="/">Go to Home</router-link>
        {{ id }}

      </div>  
  
</template>


<script>
export default {
    name: 'AulasAbout',
    computed: {
        id(){
            return this.$route.params.id
        }
    }
}
</script> 
 