<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/productos">Productos Laravel</a>
        </div>
    </nav>

    <main class="container">
        @if (session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h1>Listado de productos</h1>
            <a href="{{ route('productos.create') }}" class="btn btn-success">Nuevo producto</a>
        </div>

        <form method="GET" action="{{ route('productos.index') }}" class="row g-2 mb-4">
            <div class="col-md-5">
                <input name="buscar" class="form-control" placeholder="Buscar producto..." value="{{ $buscar ?? '' }}">
            </div>
            <div class="col-md-4">
                <select name="categoria" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat }}" @selected(($categoria ?? '') === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary">Buscar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $p)
                            <tr>
                                <td>{{ $p['id'] }}</td>
                                <td>{{ $p['nombre'] }}</td>
                                <td>{{ $p['categoria'] }}</td>
                                <td>${{ number_format($p['precio'], 2) }}</td>
                                <td>
                                    <a href="{{ route('productos.edit', $p['id']) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form method="POST" action="{{ route('productos.destroy', $p['id']) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">No hay productos.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>