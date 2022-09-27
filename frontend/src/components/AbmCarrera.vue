<template>
  <v-container fluid grid-list-lg text-lg-left>
    <v-data-table
      :headers="headers"
      :items="carreras"
      sort-by="carrera"
      class="elevation-1"
     >
   <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Carreras</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="pink" dark class="mb-2" v-bind="attrs" v-on="on">
               Agregar Carrera
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
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        v-model="editedItem.id"
                        label="Codigo Carrera"
                        disabled
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        v-model="editedItem.nombre"
                        label="Nombre Carrera"
                      ></v-text-field>
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
            <v-card>
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
            </v-card>
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
  name: "AbmCarrera",
  data() {
    return {
      carrera: "",
      dialog: false,
      snackbar:false,
      textsnack:'¡Registro Eliminado!',
      dialogDelete: false,
     headers: [
        { text: "Id", value: "id" },
        { text: "Nombre", value: "nombre" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      carreras: [],
      editedIndex: -1,
      editedItem: {
        id: "",
        nombre: "",
      },
      defaultItem: {
        id: "",
        nombre: "",
      },
    };
  },
  async mounted() {
    this.listaDeCarreras();
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
    }
  },
  created() {
    this.initialize();
  },
  methods: {
    initialize() {},
    editItem(item) {
      this.editedIndex = this.carreras.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.editedIndex = this.carreras.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      this.carreras.splice(this.editedIndex, 1);
      this.eliminarCarrera(this.editedItem);
      console.log("error", this.errors);
      if (this.errors != true) {
        this.dialogAlerta = true;
        this.snackbar = true
      }
      this.closeDelete();
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
        this.editarCarrera();
        Object.assign(this.carreras[this.editedIndex], this.editedItem);
      } else {
        this.crearCarrera();
      }
      this.close();
    },

    async listaDeCarreras() {
      await this.axios
        .get("apiv1/carrera")
        .then((response) => {
          this.carreras = response.data;
          })
     },

    async crearCarrera() {
      await this.axios
        .post("apiv1/carrera", this.editedItem)
        .then((response) => {
          this.editedItem = response.data;
          this.carreras.push(this.editedItem);
          this.editItem.id = "";
          this.editItem.nombre = "";
          })
       },

     async editarCarrera() {
      await this.axios
        .put("apiv1/carrera/" + this.editedItem.id, this.editedItem)
        .then((response) => {
          if (response != null) {
            this.dialogAlerta = true;
          }
        })
        },
     async eliminarCarrera(item) {
      await this.axios.delete("apiv1/carrera/" + item.id)
      .catch(function(error){
          console.log(error);
       });
    },
  },
};
</script>