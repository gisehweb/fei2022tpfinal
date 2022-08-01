<template>
  <v-container>
     <v-app-bar
        app
        elevation="4"
    >
      <v-app-bar-nav-icon @click="$emit('toggle-menu')"></v-app-bar-nav-icon>
      <v-app-bar-title>Aulas Curza</v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn small text fab>
        <v-icon>mdi-cog-outline</v-icon>
      </v-btn>
      <v-btn small @click="logout">
        <v-icon>mdi-exit-to-app</v-icon>
      </v-btn>
    </v-app-bar>

  </v-container>
</template>

<script>
  export default {
    name: 'MainBar',
    data: () => ({
    }),
    methods: {
      logout(){
        console.log('Logout...')
      }
    }
  }
</script>