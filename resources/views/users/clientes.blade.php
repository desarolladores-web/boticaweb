@extends('layouts.admin')

@section('content')
<style>
    .table-red-lines thead {
        background-color: #f8f9fa;
    }

    .table-red-lines tbody tr {
        border-bottom: 2px solid #dc3545; /* rojo */
    }

    .table-red-lines td,
    .table-red-lines th {
        vertical-align: middle;
        padding: 0.75rem;
    }

    .table-red-lines img {
        object-fit: cover;
    }

    .table-red-lines .fw-bold {
        font-size: 1rem;
    }

    .table-red-lines small {
        font-size: 0.85rem;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Lista de Usuarios</h2>

    <table class="table table-red-lines align-middle">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Dirección</th>
                <th>Tipo Documento</th>
                <th>Teléfono</th>
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
                                <div class="fw-bold">
                                    {{ $user->name }} {{ $user->cliente?->apellido_paterno ?? '' }}
                                </div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->cliente?->direccion ?? '-' }}</td>
                    <td>
                        @if($user->tipoDocumento && $user->tipoDocumento->nombre_documento === 'DNI')
                            {{ $user->cliente?->DNI ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $user->cliente?->telefono ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
