<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    private function obtenerProductos(Request $request): array
    {
        return $request->session()->get('productos', [
            1 => ['id' => 1, 'nombre' => 'Laptop', 'categoria' => 'Tecnología', 'precio' => 15999],
            2 => ['id' => 2, 'nombre' => 'Mouse', 'categoria' => 'Tecnología', 'precio' => 299],
            3 => ['id' => 3, 'nombre' => 'Escritorio', 'categoria' => 'Muebles', 'precio' => 2499],
            4 => ['id' => 4, 'nombre' => 'Silla', 'categoria' => 'Muebles', 'precio' => 1899],
        ]);
    }

    public function index(Request $request)
    {
        $todos = $this->obtenerProductos($request);
        $buscar = $request->query('buscar', '');
        $categoria = $request->query('categoria', '');

        $productos = collect($todos);

        if ($buscar !== '') {
            $productos = $productos->filter(
                fn ($p) => str_contains(
                    mb_strtolower($p['nombre']),
                    mb_strtolower($buscar)
                )
            );
        }

        if ($categoria !== '') {
            $productos = $productos->where('categoria', $categoria);
        }

        return view('productos.index', [
            'productos' => $productos,
            'categorias' => collect($todos)->pluck('categoria')->unique(),
            'buscar' => $buscar,
            'categoria' => $categoria,
        ]);
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|min:3|max:100',
            'categoria' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
        ]);

        $productos = $this->obtenerProductos($request);
        $id = empty($productos) ? 1 : max(array_keys($productos)) + 1;
        $productos[$id] = ['id' => $id] + $datos;

        $request->session()->put('productos', $productos);

        return redirect()->route('productos.index')
            ->with('ok', 'Producto creado correctamente.');
    }

    public function edit(Request $request, int $id)
    {
        $productos = $this->obtenerProductos($request);
        abort_unless(isset($productos[$id]), 404);

        return view('productos.edit', ['producto' => $productos[$id]]);
    }

    public function update(Request $request, int $id)
    {
        $productos = $this->obtenerProductos($request);
        abort_unless(isset($productos[$id]), 404);

        $datos = $request->validate([
            'nombre' => 'required|string|min:3|max:100',
            'categoria' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
        ]);

        $productos[$id] = ['id' => $id] + $datos;
        $request->session()->put('productos', $productos);

        return redirect()->route('productos.index')
            ->with('ok', 'Producto actualizado correctamente.');
    }

    public function destroy(Request $request, int $id)
    {
        $productos = $this->obtenerProductos($request);
        abort_unless(isset($productos[$id]), 404);

        unset($productos[$id]);
        $request->session()->put('productos', $productos);

        return redirect()->route('productos.index')
            ->with('ok', 'Producto eliminado correctamente.');
    }
}