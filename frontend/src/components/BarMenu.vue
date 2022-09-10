<template>
    <v-container>
      <v-app-bar app elevation="3" color="pink">
        <v-app-bar-nav-icon @click="drawer = true" dark></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <v-app-bar-title class="white--text">Aulas</v-app-bar-title>
        <v-spacer></v-spacer>
        <v-btn small text fab>
          <v-icon color="white">mdi-cog-outline</v-icon>
        </v-btn>
        <v-btn small text fab>
          <v-icon color="white">mdi-exit-run</v-icon>
        </v-btn>
      </v-app-bar>
      <v-navigation-drawer app v-model="drawer" temporary color="white">
        <v-list-item>
            <v-img
          alt="Aulas Logo"
          class="shrink mr-2"
          contain
          :src="require('../assets/aulas.png')"
          transition="scale-transition"
          width="73"
        />
          <v-list-item-content>
            <v-list-item-title class="text-left text-h5">
              Aulas
            </v-list-item-title>
            <v-list-item-subtitle class="text-left text-h7">
              Fei 2022
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item-title class="text-center text-h6"> Menu </v-list-item-title>
        <v-divider></v-divider>
        <v-list dense>
          <v-list-item v-for="item in items" :key="item.title" :to="item.to" link>
            <v-list-item-icon>
              <v-icon color="indigo darken-4">{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title class="text-h8">{{
                item.title
              }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </v-container>
  </template>
  
  <script>
  export default {
    name: "BarMenu",
    data: () => ({
     drawer: false,
      items: [
        { title: "Home", icon: "mdi-home", to: "/" },
        { title: 'Acerca de', icon: 'mdi-text', to: '/about' }
        ],
    }),
    mounted(){
      
    },
    computed: {
      
    }
  }
        
  </script>