<template>
    <div>
        <h3>Hola desde componente de VUE para mostrar tareas</h3>

        {{ nombre }}
        {{ tareas}}
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <!-- Aquí puedes agregar más columnas según la estructura de tus datos -->
                </tr>
            </thead>
            <tbody>
                <tr v-for="tarea in tareas" :key="tarea.id">
                    <td>{{ tarea.IdTarea }}</td>
                    <td>{{ tarea.Descripcion }}</td>
                    <!-- Aquí puedes agregar más columnas según la estructura de tus datos -->
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import { onMounted } from 'vue';

const props = defineProps({
    tareas: {
        type: Array,
        default: []
    },
    nombre: {
        type: String,
        default: ""
    }
});

// Método para imprimir las tareas en la consola
onMounted(() => {
    console.log('Tareas recibidas:', props.tareas);
});
</script>
<style scoped>
    /* Estilos opcionales para la tabla */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }
</style>
