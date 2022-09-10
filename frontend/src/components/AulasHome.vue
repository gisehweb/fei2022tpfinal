<template>
  <div>
    <v-img
          alt="Aulas SPA"
          class="shrink mr-2"
          contain
          :src="require('../assets/spa.png')"
          transition="scale-transition"
          width="100%"
        />
    <router-link to="/about/123123">Go to Acerca de</router-link>
  </div>
</template> 

<script>
  export default {
    name: 'AulasHome',
    components: {
    },
  }
</script> 