import './bootstrap'
import {createApp} from "vue";
import verTareas from "./components/verTareas.vue"

const el = document.getElementById( "ver_tarea");

createApp(verTareas, {
    nombre: el.getAttribute('data-nombre'),
    tareas: JSON.parse(el.getAttribute('data-tareas'))


}).mount('#ver_tarea');
