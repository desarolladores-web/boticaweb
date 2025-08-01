@extends('layouts.admin')

@section('content')

<style>
    /* Estilo moderno para tabla con líneas horizontales rojas */
    table.table-red-lines thead {
        background-color: #f8f9fa;
    }

    table.table-red-lines tbody tr {
        border-bottom: 2px solid #dc3545 !important; /* Línea roja */
    }

    table.table-red-lines td,
    table.table-red-lines th {
        vertical-align: middle;
        padding: 0.75rem;
    }

    table.table-red-lines img {
        object-fit: cover;
    }

    table.table-red-lines .fw-bold {
        font-size: 1rem;
    }

    table.table-red-lines small {
        font-size: 0.85rem;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Lista de Usuarios</h2>
    
    <table class="table table-red-lines align-middle">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Rol</th>
                <th>Tipo Documento</th>
                <th>Estado</th><!-- Nueva columna para el botón -->
                <th>Acciones</th> <!-- Nueva columna para el botón -->
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- Imagen redonda --}}
                            @if($user->imagen)
                                <img src="data:image/jpeg;base64,{{ base64_encode($user->imagen) }}" 
                                     alt="avatar" class="rounded-circle me-3" width="48" height="48">
                            @else
                                <img src="{{ asset('default-avatar.png') }}" 
                                     alt="avatar" class="rounded-circle me-3" width="48" height="48">
                            @endif

                            {{-- Nombre y email --}}
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>

                    <td>{{ $user->rol->tipo ?? 'N/A' }}</td>

                    <td>
                        @if($user->tipoDocumento && $user->tipoDocumento->nombre_documento === 'DNI')
                            {{ $user->cliente?->DNI ?? '-' }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($user->estado)
                            <span class="badge bg-success estado-badge">Activo</span>
                        @else
                            <span class="badge bg-danger estado-badge">Inactivo</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('empleados.edit', $user->id) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
