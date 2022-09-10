<template>
    <v-footer
      dark
      padless
    >
      <v-card
        class="flex"
        flat
        tile
      >
        <v-card-title class="blue darken-3">
          <strong class="subheading">Ingresa a los siguientes enlaces:</strong>
  
          <v-spacer></v-spacer>
  
          <a href="http://siucurza.uncoma.edu.ar/curza/inicio_alumno">
 <v-img :src="require('@/assets/siu.png')"
 max-width="100"
 to=""
 width="100%">  </v-img> 
</a>

<a href="https://pedco.uncoma.edu.ar/">
 <v-img :src="require('@/assets/pedco.png')"
 max-width="100"
 to=""
 width="100%">  </v-img> 
</a>

<a href="https://web.curza.uncoma.edu.ar/">
 <v-img :src="require('@/assets/curza.png')"
 max-width="100"
 to=""
 width="100%">  </v-img> 
</a>
        </v-card-title>
  
        <v-card-text class="py-2 white--text text-center">
          {{ new Date().getFullYear() }} — <strong>Gisella Henriquez</strong>
        </v-card-text>
      </v-card>
    </v-footer>
  </template>
  <script>
    export default {
  name: "MyFooter",
};
  </script>