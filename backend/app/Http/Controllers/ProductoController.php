<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index() {
        return Producto::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'descripcion' => 'required',
            'categoria' => 'required',
            'precio' => 'required|numeric',
            'stockminimo' => 'required|integer',
            'unidadmedida' => 'required',
            'activo' => 'boolean',
        ]);

        return Producto::create($validated);
    }

    public function show($id) {
        return Producto::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());
        return $producto;
    }

    public function destroy($id) {
        return Producto::destroy($id);
    }
}

