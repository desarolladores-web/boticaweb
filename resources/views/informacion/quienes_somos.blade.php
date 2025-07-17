@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <!-- Sección: Nuestra Historia -->
        <div class="text-center mb-5">
            <h6 class="text-danger fw-bold text-uppercase">Quienes somos</h6>
            <h2 class="fw-bold">Nuestra historia</h2>
        </div>

        <div class="row mb-5">
            <div class="col-md-4">
                <p>
                    La farmacia Arc de Triomf está situada al inicio del Paseo de San Juan, justo enfrente del emblemático
                    monumento, del que toma el nombre.Tiene una larga historia que se remonta al año 1935, cuando estaba
                    regentada por un farmacéutico
                    conocido como Sr. Enric Ruax. En 1987, el padre de la actual titular compró la farmacia y desde entonces
                    pertenece a la familia de Mª Àngels Salvadó.
                </p>
            </div>
            <div class="col-md-4">
                <p>
                    La Dra. Mª Àngels Salvadó, farmacéutica titular de la farmacia, ha tomado el relevo. Profesora de
                    Universidad, donde enseña la especialidad de galénica, su vocación didáctica le ha llevado a atender a
                    sus clientes de forma muy personalizada, aclarando dudas y dando consejos de salud, explicando siempre
                    el porqué de las cosas.
                </p>
            </div>
            <div class="col-md-4">
                <p>
                    Ahora, y aprovechando las ventajas de las nuevas tecnologías, ponemos en marcha la WEB de la farmacia,
                    donde nuestros clientes podrán seguir disfrutando de los consejos de salud y al mismo tiempo podrán
                    conocer las diferentes promociones que tenemos en la farmacia o incluso realizar pedidos desde casa para
                    recoger sin esperas.
                </p>
            </div>
        </div>

        <!-- Sección: Nuestro equipo -->
        <div class="text-center mb-4">
            <h6 class="text-danger fw-bold text-uppercase">Quienes somos</h6>
            <h2 class="fw-bold">Nuestro equipo</h2>
        </div>

        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Dra. Mª Àngels Salvadó</h5>
                <p class="text-muted mb-0">Farmacéutica Titular</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Maria Salazar</h5>
                <p class="text-muted mb-0">Farmacéutica Sustituta</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Jianing Zhou</h5>
                <p class="text-muted mb-0">Farmacéutico Sustituto</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">David Cuello</h5>
                <p class="text-muted mb-0">Técnico en Farmacia</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Álex Miralles</h5>
                <p class="text-muted mb-0">Auxiliar de Farmacia</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Josep Salvadó</h5>
                <p class="text-muted mb-0">Administración</p>
            </div>
        </div>
        <div class="container-fluid px-0">
            <span class="d-block">
                <div class="text-center">
                    <img width="1920" height="1080" src="{{ asset('imagenes/boticamirianfisico.png') }}" alt="Botica Mirian"
                        title="Botica Mirian" class="img-fluid w-50 mt-5">
                </div>
            </span>
        </div>

    </div>
@endsection