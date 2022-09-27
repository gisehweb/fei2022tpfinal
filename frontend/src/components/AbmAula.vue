<template>
    <v-container fluid grid-list-lg text-lg-left>
      <v-data-table
        :headers="headers"
        :items="aulas"
        sort-by="aula"
        class="elevation-1"
       >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Aulas</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn color="pink" dark class="mb-2" v-bind="attrs" v-on="on">
                  Agregar Aula
                </v-btn>
              </template>

              <v-card>
                <v-toolbar color="pink" class="text-h4" dark>
                  <v-card-title>
                    <span class="text-h5">{{ formTitle }}</span>
                  </v-card-title>
                </v-toolbar>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="8" md="6">
                        <v-text-field
                          v-model="editedItem.descripcion"
                          label="Descripcion"
                        ></v-text-field>
                        <v-text-field
                          v-model="editedItem.ubicacion"
                          label="Ubicacion"
                        ></v-text-field>
                        <v-text-field
                          v-model="editedItem.cant_proyector"
                          label="Cantidad de Proyectores"
                          type="number"
                        ></v-text-field>
                        <v-text-field
                          v-model="editedItem.aforo"
                          label="Aforo"
                        ></v-text-field>
                      <v-checkbox v-model="editedItem.es_climatizada" label="Es climatizada">
                    </v-checkbox>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="error" @click="close"> Cancelar </v-btn>
                  <v-btn color="success" @click="save"> Guardar </v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
             
               <v-card-text>
                  <div class="text-h6 pa-12">
                    ¿Estas seguro de borrar este item?
                  </div>
                </v-card-text>
                <v-card-actions class="justify-end">
                  <v-spacer></v-spacer>
                  <v-btn color="error" @click="closeDelete">No</v-btn>
                  <v-btn color="success" @click="deleteItemConfirm()">Si</v-btn>
                  <v-spacer></v-spacer>
                </v-card-actions>
              
            </v-dialog>
            <!-- componente snackbar para mostrar mensaje de eliminación -->
        <v-snackbar v-model="snackbar" color="success"> {{textsnack}}
         <template v-slot:action="{attrs}">
          <v-btn text v-bind="attrs" @click="snackbar = false">Cerrar</v-btn>
      </template>
      </v-snackbar>
            </v-toolbar>
        </template>
       <template v-slot:[`item.actions`]="{ item }">
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn v-bind="attrs" v-on="on" text @click="editItem(item)">
                <v-icon small color="blue-grey darken-3" dark> mdi-pencil</v-icon>
              </v-btn>
            </template>
            <span>Editar</span>
          </v-tooltip>
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn v-bind="attrs" v-on="on" text @click="deleteItem(item)">
                <v-icon small color="error" dark> mdi-delete</v-icon>
              </v-btn>
            </template>
            <span>Eliminar</span>
          </v-tooltip>
        </template>
      </v-data-table>
    </v-container>
  </template>
  
  <script>
  export default {
    name: "AbmAula",
    data() {
      return {
        aula: "",
        snackbar:false,
        textsnack:'¡Registro Eliminado!',
        dialog: false,
        dialogDelete: false,
        headers: [
          { text: "Descripcion", value: "descripcion" },
          { text: "Ubicacion", value: "ubicacion" },
          { text: "Proyectores", value: "cant_proyector" },
          { text: "Aforo", value: "aforo" },
          { text: "Climatizada", value: "es_climatizada" },
          { text: "Actions", value: "actions", sortable: false },
        ],
        aulas: [],
        editedIndex: -1,
        editedItem: {
          descripcion: "",
          ubicacion: "",
          cant_proyector: "",
          aforo: "",
          es_climatizada: false,
        },
        defaultItem: {
          descripcion: "",
          ubicacion: "",
          cant_proyector: "",
          aforo: "",
          es_climatizada: "",
        },
      };
    },
    mounted() {
      this.listaDeAulas();
    },
    computed: {
      formTitle() {
        return this.editedIndex === -1 ? "Nuevo Item" : "Editar Item";
      },
    },
    watch: {
      dialog(val) {
        val || this.close();
      },
      dialogDelete(val) {
        val || this.closeDelete();
      },
     dialogError(val) {
        if (!val) return;
        val || this.closeDelete();
      },
    },
    created() {
      this.initialize();
    },
    methods: {
      initialize() {},
      editItem(item) {
        this.editedIndex = this.aulas.indexOf(item);
        this.editedItem = Object.assign({}, item);
        this.dialog = true;
      },
      deleteItem(item) {
        this.editedIndex = this.aulas.indexOf(item);
        this.editedItem = Object.assign({}, item);
        this.dialogDelete = true;
      },
      deleteItemConfirm() {
        this.aulas.splice(this.editedIndex, 1);
        this.borrarAula(this.editedItem);
        this.closeDelete();
        this.snackbar = true
      },
      close() {
        this.dialog = false;
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
        });
      },
      closeDelete() {
        this.dialogDelete = false;
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
        });
      },
      save() {
        if (this.editedIndex > -1) {
          this.actualizarAula();
          Object.assign(this.aulas[this.editedIndex], this.editedItem);
        } else {
          this.crearAula();
        }
        this.close();
      },
      
      async listaDeAulas() {
        await this.axios
          .get("apiv1/aula")
          .then((response) => {
            this.aulas = response.data;
         })
          .catch(function(error){
                console.log(error);
          });
      },
      async borrarAula(item) {
        await this.axios.delete("apiv1/aula/" + item.id)
        .catch(function(error){
                console.log(error);
          });
      },
      async crearAula() {
        await this.axios
          .post("apiv1/aula", this.editedItem)
          .then((response) => {
            this.editedItem = response.data;
            this.aulas.push(this.editedItem);
            this.dialogAlerta = true;
          })
          .catch(function(error){
                console.log(error);
          });
      },
      async actualizarAula() {
        await this.axios
          .put("apiv1/aula/" + this.editedItem.id, this.editedItem)
          .then((response) => {
            if (response != null) {
              this.dialogAlerta = true;
            }
          })
          .catch(function(error){
                console.log(error);
        });
      },
    },
  };
  </script>