@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <!-- Sección: Nuestra Historia -->
        <div class="text-center mb-5">
            <h6 class="text-danger fw-bold text-uppercase">Quienes somos</h6>
            <h2 class="fw-bold">Nuestra historia</h2>
        </div>

        <div class="row mb-5">
            <div class="col-md-4 text-center ">
                <p>
                    La Botica Myryan, registrada ante SUNAT como HUILLCAHUAMAN POMA MIRIAN CATALINA (RUC: 10434953397),
                    inició operaciones el 1 de abril de 2019 en el distrito de La Tinguiña. Se dedica a la venta de
                    medicamentos,
                    productos médicos, cosméticos y artículos de tocador, cubriendo necesidades de salud y bienestar de la
                    comunidad.
                    Desde sus inicios, se ha caracterizado por brindar un servicio cercano, accesible y confiable.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <p>
                    Nuestra misión es ofrecer productos farmacéuticos y de cuidado personal con altos estándares de calidad,
                    contribuyendo al bienestar de nuestros clientes con atención personalizada y empática. Aspiramos a ser
                    una botica reconocida en el ámbito local por la confianza y la cercanía con la comunidad, garantizando
                    un abastecimiento constante y cumpliendo rigurosamente las disposiciones legales sanitarias y
                    tributarias.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <p>
                    Actualmente contamos con tres establecimientos en La Tinguiña y proyectamos expandirnos a Parcona. Nos
                    diferenciamos por nuestro compromiso con la salud, la ética profesional, la responsabilidad social y la
                    transparencia. Estamos implementando un sistema web para mejorar la gestión de inventarios, ventas y
                    atención al cliente, fortaleciendo así nuestra presencia digital y optimizando la experiencia de compra.
                </p>
            </div>
        </div>

        <!-- Sección: Nuestro equipo -->
        <div class="text-center mb-4">
            <h6 class="text-danger fw-bold text-uppercase">Quienes somos</h6>
            <h2 class="fw-bold">Nuestro equipo</h2>
        </div>

        <div class="row text-center mt-5">
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Mirian Catalina Huillcahuaman Poma</h5>
                <p class="text-muted mb-0">Propietaria / Administradora</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Técnicos y Asistentes de Farmacia</h5>
                <p class="text-muted mb-0">Atención al cliente y control de inventario</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold mb-1">Equipo de Desarrollo</h5>
                <p class="text-muted mb-0">Encargados del sistema web y soporte tecnológico</p>
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