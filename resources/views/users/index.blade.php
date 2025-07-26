@extends('layouts.admin') {{-- o el layout que uses --}}

@section('content')
<div class="container">
    <h2>Lista de Usuarios</h2>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Rol</th>
                <th>Tipo Documento</th>
                <th>Estado</th>
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
                    <td>{{ $user->rol->nombre ?? 'N/A' }}</td>
     <td>
        @if($user->tipoDocumento && $user->tipoDocumento->nombre_documento === 'DNI')
            {{ $user->cliente?->DNI ?? '-' }}
        @else
            -
        @endif
    </td>

                    
     

                    <td>{{ $user->estado ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
