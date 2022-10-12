<template>
    <v-container fluid grid-list-lg text-lg-left>
      <v-data-table
        :headers="headers"
        :items="horarios"
        sort-by="reservaAula"
        class="elevation-1"
        >

       <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Horario Materias</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
           <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn color="pink" dark class="mb-2" v-bind="attrs" v-on="on">
                  Agregar Horario
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
                        <v-select
                          v-model="editedItem.id_materia"
                          label="Materia"
                          :items="materias"
                          :hint="`${editedItem.id_materia.id}, ${editedItem.id_materia.nombre}`"
                          item-text="nombre"
                          item-value="id"
                          single-line
                        ></v-select>
                        <v-select
                          v-model="editedItem.id_reserva"
                          label="Reserva"
                          :items="reservas"
                          :hint="`${editedItem.id_reserva.id}, ${editedItem.id_reserva.observacion}`"
                          item-text="observacion"
                          item-value="id"
                          single-line
                        ></v-select>
                        <v-select
                          v-model="editedItem.id_reserva"
                          label="Hora Desde"
                          :items="reservas"
                          :hint="`${editedItem.id_reserva.fh_desde}`"
                          item-text="fh_desde"
                          item-value="id"
                          single-line
                        ></v-select>
                        <v-select
                          v-model="editedItem.id_reserva"
                          label="Hora Hasta"
                          :items="reservas"
                          :hint="`${editedItem.id_reserva.fh_hasta}`"
                          item-text="fh_hasta"
                          item-value="id"
                          single-line
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
    name: "AbmHorarioMateria",
    data() {
      return {
        reservaAula: "",
        snackbar:false,
        textsnack:'¡Registro Eliminado!',
        errors: "",
        dialog: false,
        dialogDelete:false,
        materias: "",
        profesores: "",
        reservas: "",
        headers: [
          { text: "id", value: "id" },
          { text: "Materia", value: "id_materia.nombre" },
          { text: "Reserva", value: "id_reserva.observacion" },
          { text: "fh Desde", value: "id_reserva.fh_desde" },
          { text: "fh Hasta", value: "id_reserva.fh_hasta" },
          { text: "Actions", value: "actions", sortable: false },
        ],
        horarios: [],
        editedIndex: -1,
        editedItem: {
          id: "",
          id_materia: "",
          id_reserva: "",
        },
        defaultItem: {
          id: "",
          id_materia: "",
          id_reserva: "",
        },
      };
    },
    mounted() {
      this.listaDeReservas(), 
      this.listaDeMaterias();
      this.listaDeHorarios();
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
    methods: {
      initialize() {},
      editItem(item) {
        this.editedIndex = this.horarios.indexOf(item);
        this.editedItem = Object.assign({}, item);
        this.dialog = true;
      },
      deleteItem(item) {
        this.editedIndex = this.horarios.indexOf(item);
        this.editedItem = Object.assign({}, item);
        this.dialogDelete = true;
      },
      deleteItemConfirm() {
        this.horarios.splice(this.editedIndex, 1);
        this.borrarHorario(this.editedItem);
        this.closeDelete();
        this.snackbar = true

      },
      close() {
        this.dialog = false;
        this.dialog2 = false;
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
          this.actualizarHorario();
          Object.assign(this.horarios[this.editedIndex], this.editedItem);
        } else {
          this.crearHorario();
        }
        this.close();
      },
      changeState(valor) {
        this.editedItem.procesado = valor;
      },
      async listaDeHorarios() {
        await this.axios
          .get("apiv1/horariomateria")
          .then((response) => {
            this.horarios = response.data;
            console.log("horarios", this.horarios);
           
          })
          .catch(function(error){
          console.log(error);
       });
      },
      async listaDeReservas() {
        await this.axios
          .get("apiv1/reservaaula")
          .then((response) => {
            this.reservas = response.data;
         })
          .catch(function(error){
          console.log(error);
       });
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
      async borrarHorario(item) {
        await this.axios.delete("apiv1/horariomateria/" + item.id)
        .catch(function(error){
          console.log(error);
       });
      },
      async crearHorario() {
        await this.axios
          .post("apiv1/horariomateria", this.editedItem)
          .then((response) => {
            this.editedItem = response.data;
            this.horarios.push(this.editedItem);
            this.dialogAlerta = true;
          })
          .catch(function(error){
          console.log(error);
       });
      
      },
      async actualizarHorario() {
        await this.axios
          .put("apiv1/horariomateria/" + this.editedItem.id, this.editedItem)
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