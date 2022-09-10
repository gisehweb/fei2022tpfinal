<template>
  <v-app>
    <BarMenu></BarMenu>
    
    <v-main>  
      <v-container fluid>
        <router-view/>
      </v-container></v-main><MyFooter />
     </v-app> 
  </template>
  
 <script>
import BarMenu from "./components/BarMenu.vue";
import MyFooter from "./components/MyFooter.vue"

export default {
  name: "App",
  
  components: {
    BarMenu,
    MyFooter
  },

  data: () => ({

    //
  }),
};
</script>
