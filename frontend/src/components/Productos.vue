<template>
  <div class="container">
    <h1>Lista de productos</h1>

    <button class="boton-principal" @click="mostrarFormularioCrear = !mostrarFormularioCrear">
      {{ mostrarFormularioCrear ? 'Cancelar' : 'Agregar producto' }}
    </button>

    <div v-if="mostrarFormularioCrear" class="formulario">
      <h2>Nuevo Producto</h2>
      <input v-model="nuevo.descripcion" placeholder="Descripción" />
      <input v-model="nuevo.categoria" placeholder="Categoría" />
      <input v-model.number="nuevo.precio" type="number" placeholder="Precio" />
      <input v-model.number="nuevo.stockminimo" type="number" placeholder="Stock mínimo" />
      <input v-model="nuevo.unidadmedida" placeholder="Unidad medida" />
      <input type="checkbox" v-model="nuevo.activo" /> <div style="text-align: center;">Activo</div>
      <button @click="crearProducto">Crear</button>
    </div>

    <div v-if="editar.id" class="formulario">
      <h2>Editar Producto</h2>
      <input v-model="editar.descripcion" placeholder="Descripción" />
      <input v-model="editar.categoria" placeholder="Categoría" />
      <input v-model.number="editar.precio" type="number" placeholder="Precio" />
      <input v-model.number="editar.stockminimo" type="number" placeholder="Stock mínimo" />
      <input v-model="editar.unidadmedida" placeholder="Unidad medida" />
      <input type="checkbox" v-model="editar.activo" /> <div style="text-align: center;">Activo</div>
      <button @click="guardarCambios">Guardar</button>
      <button @click="cancelarEdicion">Cancelar</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>Descripción</th>
          <th>Categoría</th>
          <th>Precio</th>
          <th>Stock Mínimo</th>
          <th>Unidad Medida</th>
          <th>Activo</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="p in productos" :key="p.id">
          <td>{{ p.descripcion }}</td>
          <td>{{ p.categoria }}</td>
          <td>${{ Number(p.precio).toFixed(2) }}</td>
          <td>{{ p.stockminimo }}</td>
          <td>{{ p.unidadmedida }}</td>
          <td>{{ p.activo ? 'Sí' : 'No' }}</td>
          <td>
            <button @click="editarProducto(p)">Editar</button>
            <button @click="eliminarProducto(p.id)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const productos = ref([])
const mostrarFormularioCrear = ref(false)

const nuevo = ref({
  descripcion: '',
  categoria: '',
  precio: 0,
  stockminimo: 0,
  unidadmedida: '',
  activo: true
})

const editar = ref({
  id: null,
  descripcion: '',
  categoria: '',
  precio: 0,
  stockminimo: 0,
  unidadmedida: '',
  activo: true
})

const api = 'http://localhost:8000/api/productos'

const cargarProductos = async () => {
  try {
    const res = await fetch(api)
    const data = await res.json()
    productos.value = Array.isArray(data) ? data : []
  } catch (err) {
    console.error('Error al cargar productos:', err)
  }
}

const crearProducto = async () => {
  try {
    await fetch(api, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(nuevo.value)
    })
    mostrarFormularioCrear.value = false
    Object.assign(nuevo.value, {
      descripcion: '', categoria: '', precio: 0,
      stockminimo: 0, unidadmedida: '', activo: true
    })
    await cargarProductos()
  } catch (err) {
    console.error('Error al crear producto:', err)
  }
}

const editarProducto = (producto) => {
  editar.value = { ...producto }
}

const guardarCambios = async () => {
  try {
    await fetch(`${api}/${editar.value.id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(editar.value)
    })
    editar.value = { id: null }
    await cargarProductos()
  } catch (err) {
    console.error('Error al guardar cambios:', err)
  }
}

const cancelarEdicion = () => {
  editar.value = { id: null }
}

const eliminarProducto = async (id) => {
  if (!confirm('¿Estás seguro de eliminar este producto?')) return
  try {
    await fetch(`${api}/${id}`, { method: 'DELETE' })
    await cargarProductos()
  } catch (err) {
    console.error('Error al eliminar producto:', err)
  }
}

onMounted(() => {
  cargarProductos()
})
</script>

<style scoped>
.container {
  max-width: 900px;
  margin: auto;
  padding: 30px;
  font-family: Arial, sans-serif;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

.boton-principal {
  background-color: #4caf50;
  color: white;
  padding: 8px 16px;
  margin-bottom: 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.boton-principal:hover {
  background-color: #45a049;
}

.formulario {
  margin-bottom: 20px;
  padding: 15px;
  background-color: #f7f7f7;
  border: 1px solid #ddd;
  border-radius: 5px;
}

input {
  display: block;
  margin-bottom: 10px;
  padding: 6px;
  width: 100%;
  box-sizing: border-box;
  border-radius: 4px;
  border: 1px solid #ccc;
}

button {
  margin-right: 10px;
  padding: 6px 12px;
  cursor: pointer;
  border-radius: 4px;
  border: none;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

tr:hover {
  background-color: #f1f1f1;
}
</style>
