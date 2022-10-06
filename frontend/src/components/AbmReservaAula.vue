<template>
    <v-container>
         <v-window v-model=step>
            <v-window-item :value="1">
                <v-toolbar-title>Reserva de Aulas</v-toolbar-title>
                <div>
                    <v-btn color="pink" dark title elevation="6" @click="(step = 2)">Realizar Reserva</v-btn>
                </div>
                <v-simple-table>

                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    Id
                                </th>
                                <th class="text-left">
                                    Aula
                                </th>
                                <th class="text-left">
                                    Fecha desde y Hora desde
                                </th>
                                <th class="text-left">
                                    Fecha hasta y Hora hasta
                                </th>
                                <th class="text-left">
                                    Observacion
                                </th>

                                <th class="text-left">
                                    Actions
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="Reserva in Reservas" :key="Reserva.id">
                                <td>{{ Reserva.id }}</td>
                                <td>{{ Reserva.id_aula }}</td>
                                <td>{{ Reserva.fh_desde }}</td>
                                <td>{{ Reserva.fh_hasta }}</td>
                                <td>{{ Reserva.observacion }}</td>

                                <v-btn color="blue-grey darken-3" dark title elevation="6"
                                    @click="mostrarReserva(Reserva.id, step = 3)">
                                    <v-icon center>mdi-pencil</v-icon>
                                </v-btn>

                                <v-btn color="red" dark title elevation="6" @click="borrarReserva(Reserva.id)">
                                    <v-icon center>mdi-delete-circle-outline</v-icon>
                                </v-btn>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </v-window-item>
            <v-window-item :value="2">
                <div>
                    <v-btn color="pink" elevation="10" dark title @click="(step = 1)">atras</v-btn>
                </div>
                <v-col cols="12" sm="6">
                    <v-card-text class="mt-12">
                        <h2 class="tex-center">Nueva Reserva</h2>
                        <v-spacer></v-spacer>
                        <v-row>
                         <v-col cols="12" sm="12">
                          <v-select v-model="nuevaReserva.id_aula" :items=aulas label="Reservar Aula"
                            item-value="id" required outlined dense color="pink" class="mt-4">
                         </v-select>
                      </v-col>
                     <div>

                <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                        transition="scale-transition" offset-y min-width="auto">
                         <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="date" label="Fecha" prepend-icon="mdi-calendar" readonly
                                  v-bind="attrs" v-on="on"></v-text-field>
                        </template>
                            <v-date-picker locale="es" v-model="date" :active-picker.sync="activePicker"
                               @change="save"></v-date-picker>
                                </v-menu>
                            </div>
                            <v-col cols="12" sm="12">
                                <v-select v-model="horad" :items=hora label="Hora D" required outlined dense
                                    color="blue-grey darken-3" class="mt-4">
                                </v-select>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-select v-model="horah" :items=hora label="Hora H" required outlined dense
                                    color="blue-grey darken-3" class="mt-4">
                                </v-select>
                            </v-col>



                 <v-col cols="12" sm="12">
              <v-text-field v-model="nuevaReserva.observacion" elevation="10" label="Observacion"
            outlined dense color="pink" class="mt-4"></v-text-field>
        </v-col>
         </v-row>
        <v-spacer></v-spacer>
    <v-btn color="blue-grey darken-3" dark block title elevation="10" @click="crearReserva(step = 1)">Crear
                        </v-btn>

                    </v-card-text>
                </v-col>
            </v-window-item>
            <v-window-item :value="3">
                <div>
                    <v-btn color="pink" elevation="10" dark title @click="(step = 1)">atras</v-btn>
                </div>
                <v-col cols="12" sm="6">
                    <v-card-text class="mt-12">
                        <h2 class="tex-center">Editar Reserva</h2>
                        <v-spacer></v-spacer>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <v-select v-model="aula_select" :items=aulas label="Aula Reservada" item-value="id"
                                    required outlined dense color="blue" class="mt-4">
                                </v-select>
                            </v-col>
                        <div>

                            <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                              transition="scale-transition" offset-y min-width="auto">
                           <template v-slot:activator="{ on, attrs }">
                                 <v-text-field v-model="date_select" label="Fecha" prepend-icon="mdi-calendar"
                                    readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker locale="es" v-model="date" :active-picker.sync="activePicker"
                                        @change="save"></v-date-picker>
                                </v-menu>
                            </div>
                            <v-col cols="12" sm="12">
                                <v-select v-model="horad_select" :items=hora label="Hora D" required outlined dense
                                    color="blue" class="mt-4">
                                </v-select>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-select v-model="horah_select" :items=hora label="Hora H" required outlined dense
                                    color="blue" class="mt-4">
                                </v-select>
                            </v-col>


                              <v-col cols="12" sm="12">
                                <v-text-field v-model="reservaModificada.observacion" elevation="10" label="Observacion"
                                    outlined dense color="blue" class="mt-4"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-spacer></v-spacer>
                        <v-btn color="blue-grey darken-3" dark block title elevation="10"
                            @click="editarReserva(reservaModificada.id, reservaModificada, step = 1)">Modificar Reserva
                        </v-btn>

                    </v-card-text>
                </v-col>
            </v-window-item>
        </v-window>
    </v-container>
</template>


<script>
import axios from "axios"
export default {
    name: 'AbmReservaAula',
    data() {
        return {
            activePicker: null,
            date: null,
            menu: false,
            hora: ['07:00:00','07:30:00','08:00:00','08:30:00','09:00:00','09:30:00','10:00:00','10:30:00',
                '11:00:00','11:30:00','12:00:00','12:30:00','13:00:00','13:30:00','14:00:00','14:30:00','15:00:00',
                '15:30:00','16:00:00','16:30:00','17:00:00','17:30:00','18:00:00','18:30:00','19:00:00',
                '19:30:00','20:00:00','20:30:00','21:00:00','21:30:00','22:00:00',
            ],
            Reservas: [],
            aulas: [],
            horad: '07:00:00',
            horah: '22:00:00',
            reservaModificada: {
                id_aula: '',
                fh_desde: '',
                fh_hasta: '',
                observacion: '',
            },
            nuevaReserva: {
                id_aula: '',
                fh_desde: '',
                fh_hasta: '',
                observacion: '',
            },
            reserva: {
                id: '',
                id_aula: '',
                fh_desde: '',
                fh_hasta: '',
                observacion: '',
            },
            aula: [],
            aula_select: '',
            horad_select: '',
            horah_select: '',
            date_select: '',
            step: 1,
        }
    },
    mounted: function () {
        var that = this
        that.listaDeReservas()
        that.listaDeAulas()
        
    },
    methods: {
        save(date) {
            var that = this
            that.$refs.menu.save(date)
            console.log(that.date)
            that.nuevaReserva.fh_desde = that.date
            that.nuevaReserva.fh_hasta = that.date
        },
        listaDeReservas() {
            var that = this
            axios.get("apiv1/reservaaula")
                .then(function (response) {
                    that.Reservas = response.data;
                })
        },
        crearReserva() {
            var that = this
            that.nuevaReserva.fh_desde += " " + that.horad
            that.nuevaReserva.fh_hasta += " " + that.horah
            console.log(that.nuevaReserva.fh_desde)
            axios.post("apiv1/reservaaula", this.nuevaReserva)
                .then(function (response) {
                    console.log(response)
                    that.listaDeReservas()
                    alert('Reserva creada')
                })
        },
        borrarReserva(id) {
            var that = this
            axios.delete("apiv1/reservaaula/" + id)
                .then(function (response) {
                    console.log(response);
                    that.listaDeReservas()
                    alert('Reserva eliminada')
                })
        },
        listaDeAulas() {
            var that = this
            axios.get("apiv1/aula")
                .then(function (response) {
                    for (let i = 0; i < response.data.length; i++) {
                        let aulas = []
                        aulas.id = response.data[i].id;
                        aulas.text = response.data[i].descripcion;
                        that.aulas.push(aulas)
                    }
                })
        },
        editarReserva(id, reserva) {
            var that = this
           axios.put("apiv1/reservaaula/" + id, reserva)
                .then(function () {
                    that.listaDeReservas()
                    alert('Reserva editada')
                })
        },
        mostrarReserva(id) {
            var that = this
            axios.get("apiv1/reservaaula/" + id)
                .then(function (response) {
                    const {
                        id,
                        fh_desde,
                        fh_hasta,
                        aula,
                        observacion,
                    } = response.data;
                    that.reservaModificada.id = id;
                    that.reservaModificada.id_aula = aula.id;
                    that.reservaModificada.fh_desde = fh_desde;
                    that.reservaModificada.fh_desde = fh_hasta;
                    that.reservaModificada.observacion = observacion
                    that.aula_select = { text: response.data.aula.descripcion, id: response.data.aula.id }
                    console.log(that.reservaModificada)
                })
        },
        capturarIdAula() {
            this.reservaModificada.id_aula = this.aula_select
        },
        Horad() {
            var that = this
            const date = that.reservaModificada.fh_desde.split(" ")
            that.date_select= date[0];
            that.horad_select=date[1];
            console.log(date)
        },
        Horah() {
            var that = this
            const date = that.reserva.fh_hasta.split(" ")
            that.date_select = date[0];
            that.horah_select = date[1];
             console.log(date)
        },
    }
}
</script>