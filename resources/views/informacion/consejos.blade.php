@extends('layouts.app')
<title>Consejos</title>

@section('content')
    <div class="container py-5">
        <!-- Título -->
        <div class="text-center mb-5">
            <h2 class="titulo-principal">Consejos de Salud - Botica Mirian</h2>
            <div class="linea-decorativa"></div>
            <p class="subtitulo-principal mt-3">
                Los mejores consejos de salud para tu día a día. Aquí encontrarás cómo mejorar tus<br>
                rutinas, hábitos saludables, prevención y mucho más.
            </p>
        </div>

        <!-- Consejos en filas de 3 -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @php
                $consejos = [
                    [
                        'titulo' => 'Golpe de calor',
                        'descripcion' =>
                            'Durante los días calurosos, evita la exposición prolongada al sol, especialmente entre las 11 a. m. y las 3 p. m. Usa ropa ligera, un sombrero de ala ancha y bebe agua frecuentemente para mantenerte hidratado. Reconoce signos como mareos, sudor excesivo o piel enrojecida.',
                        'imagen' => 'imagenes/imagenes de consejo/golpe-calor.jpg',
                        'recomendaciones' => ['Suero oral', 'Sombreros amplios', 'Bloqueador solar', 'Agua mineral'],
                    ],
                    [
                        'titulo' => 'Picaduras de insectos',
                        'descripcion' =>
                            'Para prevenir picaduras, evita zonas húmedas con vegetación alta, usa ropa que cubra brazos y piernas y aplica repelente. Si eres picado, limpia bien la zona, aplica un ungüento y evita rascarte para evitar infecciones.',
                        'imagen' => 'imagenes/imagenes de consejo/picaduras_insectos.jpg',
                        'recomendaciones' => [
                            'Repelente OFF',
                            'Ungüento anti picaduras',
                            'Antihistamínico',
                            'Alcohol medicinal',
                        ],
                    ],
                    [
                        'titulo' => 'Protección solar',
                        'descripcion' =>
                            'La exposición al sol sin protección puede causar daños irreversibles en la piel. Aplica protector solar de amplio espectro (SPF 50+) cada 2 horas, usa gafas con protección UV y evita la exposición directa al sol durante las horas de mayor radiación.',
                        'imagen' => 'imagenes/imagenes de consejo/Protección solar.jpg',
                        'recomendaciones' => ['Bloqueador SPF 50+', 'Gafas UV', 'Sombrilla portátil', 'After Sun'],
                    ],
                    [
                        'titulo' => 'Alimentación saludable',
                        'descripcion' =>
                            'Una dieta balanceada es clave para prevenir enfermedades y mantener la energía. Incluye frutas, verduras, proteínas magras y cereales integrales en tus comidas diarias. Evita el exceso de azúcares y alimentos procesados.',
                        'imagen' => 'imagenes/imagenes de consejo/Alimentación saludable.jpg',
                        'recomendaciones' => ['Multivitamínicos', 'Batidos verdes', 'Fibra natural', 'Omega 3'],
                    ],
                    [
                        'titulo' => 'Evita el estrés',
                        'descripcion' =>
                            'El estrés crónico puede afectar tu salud mental y física. Dedica tiempo al descanso, realiza actividades que disfrutes, practica ejercicios de respiración y mantén una rutina diaria equilibrada. Dormir bien también es clave.',
                        'imagen' => 'imagenes/imagenes de consejo/Evita el estrés.jpg',
                        'recomendaciones' => ['Té relajante', 'Melatonina', 'Aceites esenciales', 'Rescue Remedy'],
                    ],
                    [
                        'titulo' => 'Cuidado de la piel',
                        'descripcion' =>
                            'La piel es la primera barrera de defensa contra agentes externos. Límpiala diariamente con productos suaves, hidrátala adecuadamente y evita el uso de productos abrasivos o sin certificación dermatológica.',
                        'imagen' => 'imagenes/imagenes de consejo/Cuidado de la piel.jpg',
                        'recomendaciones' => [
                            'Gel limpiador neutro',
                            'Crema hidratante',
                            'Agua micelar',
                            'Protector facial',
                        ],
                    ],
                    [
                        'titulo' => 'Lavado de manos',
                        'descripcion' =>
                            'Lavarse las manos correctamente es una de las formas más efectivas de prevenir enfermedades. Hazlo con agua y jabón durante al menos 20 segundos, especialmente antes de comer y después de ir al baño.',
                        'imagen' => 'imagenes/imagenes de consejo/Lavado de manos.png',
                        'recomendaciones' => [
                            'Jabón antibacterial',
                            'Alcohol en gel',
                            'Toallas húmedas',
                            'Crema de manos',
                        ],
                    ],
                    [
                        'titulo' => 'Ejercicio diario',
                        'descripcion' =>
                            'Realizar actividad física mejora tu salud cardiovascular, fortalece tus músculos y eleva tu estado de ánimo. Intenta caminar, bailar o practicar algún deporte al menos 30 minutos al día, cinco veces a la semana.',
                        'imagen' => 'imagenes/imagenes de consejo/Ejercicio diario.jpg',
                        'recomendaciones' => ['Magnesio', 'Proteína en polvo', 'Rodillera elástica', 'Agua alcalina'],
                    ],
                    [
                        'titulo' => 'Cuidado del sueño',
                        'descripcion' =>
                            'Dormir entre 7 y 8 horas diarias ayuda al cuerpo a recuperarse y mejora tu salud mental. Mantén una rutina de sueño, evita pantallas antes de dormir y crea un ambiente tranquilo en tu habitación.',
                        'imagen' => 'imagenes/imagenes de consejo/Cuidado del sueño.jpg',
                        'recomendaciones' => [
                            'Melatonina',
                            'Té de valeriana',
                            'Difusor de lavanda',
                            'Tapones para los oídos',
                        ],
                    ],
                ];
            @endphp



            @foreach ($consejos as $index => $consejo)
                <div class="col-md-4 d-flex justify-content-center mb-4">
                    <div class="card border-0 shadow rounded-4 text-start h-100 d-flex flex-column"
                        style="max-width: 100%; width: 100%;">
                        <img src="{{ asset($consejo['imagen']) }}" class="card-img-top rounded-top-4 object-fit-cover"
                            style="height: 230px;" alt="{{ $consejo['titulo'] }}">

                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title fw-bold">{{ $consejo['titulo'] }}</h5>
                                <p class="card-text text-muted">{{ $consejo['descripcion'] }}</p>
                            </div>

                            <div class="mt-auto pt-3 text-center">
                                <button class="btn btn-danger rounded-pill btn-sm px-4" style="min-width: 160px;"
                                    data-bs-toggle="modal" data-bs-target="#modal{{ $index }}">
                                    Ver Recomendaciones
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="modal{{ $index }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $index }}">Recomendaciones -
                                    {{ $consejo['titulo'] }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($consejo['recomendaciones'] as $item)
                                        <li class="list-group-item">{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Estilos personalizados para títulos -->
<style>
    .titulo-principal {
        font-family: 'Poppins', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .subtitulo-principal {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1rem;
        color: #6c757d;
    }
</style>

<style>
    .object-fit-cover {
        object-fit: cover;
    }
</style>
