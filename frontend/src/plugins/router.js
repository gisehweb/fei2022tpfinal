import Vue from 'vue'
import VueRouter from 'vue-router'

import AulasHome from '../components/AulasHome'
import AulasAbout from '../components/AulasAbout'
import AbmCarrera from '../components/AbmCarrera'
import AbmProfesor from '../components/AbmProfesor'
import AbmMateria from '../components/AbmMateria'
import AbmAula from '../components/AbmAula'
import AbmReservaAula from '../components/AbmReservaAula'
import AbmHorarioMateria from '../components/AbmHorarioMateria'


Vue.use(VueRouter)

const routes = [
    {path: '/', name: 'AulasHome', component: AulasHome},
    {path: '/about/:id', name: 'AulasAbout', component: AulasAbout},
    {path: '/carrera/', name: 'AbmCarrera', component: AbmCarrera},
    {path: '/profesor/', name: 'AbmProfesor', component: AbmProfesor},
    {path: '/materia/', name: 'AbmMateria', component: AbmMateria},
    {path: '/aula/', name: 'AbmAula', component: AbmAula},
    {path: '/reservaAula/', name: 'AbmReservaAula', component: AbmReservaAula},
    {path: '/horarioMateria/', name: 'AbmHorarioMateria', component: AbmHorarioMateria},
   
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router 