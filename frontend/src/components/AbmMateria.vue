<template>
  <v-container fluid grid-list-lg text-lg-left>
    <v-data-table
      :headers="headers"
      :items="materias"
      sort-by="materia"
      class="elevation-1"
     >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Materias</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="pink" dark class="mb-2" v-bind="attrs" v-on="on">
               Cargar Materia
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
                        v-model="editedItem.nombre"
                        label="Nombre"
                        required
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.cant_alumnos"
                        label="Cantidad de Alumnos"
                        required
                      ></v-text-field>
                      <v-select
                        v-model="editedItem.id_carrera"
                        label="Carrera"
                        :items="carreras"
                        :hint="`${editedItem.id_carrera.id}, ${editedItem.id_carrera.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                        required
                      ></v-select>
                      <v-select
                        v-model="editedItem.id_profesor"
                        label="Profesor"
                        :items="profesores"
                        :hint="`${editedItem.id_profesor.id}, ${editedItem.id_profesor.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                        required
                      ></v-select>
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
  /* eslint-disable */
export default {
  name: "AbmMateria",
  data() {
    return {
      materia: "",
      snackbar:false,
      textsnack:'¡Registro Eliminado!',
      dialog: false,
      dialogDelete: false,
      dialogError: false,
      carreras: "",
      profesores: "",
      headers: [
        { text: "Id", value: "id" },
        { text: "Nombre", value: "nombre" },
        { text: "Cantidad de Alumnos", value: "cant_alumnos" },
        { text: "Carrera", value: "id_carrera.nombre" },
        { text: "Profesor", value: "id_profesor.nombre" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      materias: [],
      editedIndex: -1,
      editedItem: {
        id: "",
        nombre: "",
        cant_alumnos: "",
        id_carrera: {
          id: "",
          nombre: "",
        },
        id_profesor: {
          id: "",
          nombre: "",
          apellido: "",
          mostrar: "",
        },
      },
      defaultItem: {
        id: "",
        nombre: "",
        cant_alumnos: "",
        id_carrera: "",
        id_profesor: "",
      },
    };
  },
  mounted() {
    this.listaDeMaterias();
    this.listaDeProfes();
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
    },
  },
  created() {
    this.initialize();
  },
  methods: {
    initialize() {},
    editItem(item) {
      console.log("item inicial", item);
      this.editedIndex = this.materias.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.editedIndex = this.materias.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      this.materias.splice(this.editedIndex, 1);
      this.borrarMateria(this.editedItem);
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
        this.editarMateria();
      } else {
        this.crearMateria();
      }
      this.close();
    },
    async listaDeMaterias() {
      await this.axios
        .get("apiv1/materia")
        .then((response) => {
          this.materias = response.data;
        })
        .catch(function(error){
              console.log(error);
        });
    },
    async listaDeProfes() {
      await this.axios
        .get("apiv1/profesor")
        .then((response) => {
          this.profesores = response.data;
      })
      .catch(function(error){
            console.log(error);
        });
    },
    async listaDeCarreras() {
      await this.axios
        .get("apiv1/carrera")
        .then((response) => {
          this.carreras = response.data;
        })
        .catch(function(error){
            console.log(error);
        });
    },
    async crearMateria() {
      await this.axios
        .post("apiv1/materia", this.editedItem)
        .then((response) => {
          this.editedItem = response.data;
          this.materias.push(this.editedItem);
         })
         .catch(function(error){
              console.log(error);
        });
    },
    async borrarMateria(item) {
      await this.axios.delete("apiv1/materia/" + item.id)
          .catch(function(error){
              console.log(error);
      });
    },
    async editarMateria() {
      await this.axios
        .put("apiv1/materia/" + this.editedItem.id,
         this.editedItem)
        .then((response) => {
          this.editedItem = response.data;
          if (response != null) {
           }
        })
        .catch(function(error){
              console.log(error);
        });
    },
  },
};
</script>