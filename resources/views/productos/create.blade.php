
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('productos.index') }}">Productos Laravel</a>
        </div>
    </nav>

    <main class="container">
        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-header">
                <h1 class="h4 mb-0">Agregar producto</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('productos.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input id="nombre" name="nombre" type="text"
                               value="{{ old('nombre') }}"
                               class="form-control @error('nombre') is-invalid @enderror">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input id="categoria" name="categoria" type="text"
                               value="{{ old('categoria') }}"
                               class="form-control @error('categoria') is-invalid @enderror">
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input id="precio" name="precio" type="number" step="0.01" min="0"
                               value="{{ old('precio') }}"
                               class="form-control @error('precio') is-invalid @enderror">
                        @error('precio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Guardar producto</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
