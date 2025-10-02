    @extends('layouts.app')

    @section('content')
        <style>
            .text-primary {
                color: #717374ff !important;
            }

            .btn-warning {
                background-color: #eb0000ff;
                border-color: #0f0f0fff;
            }

            .btn-warning:hover {
                background-color: #e65c00;
            }

            .shadow-sm {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
            }

            .custom-text-color {
                color: #3a4257b9 !important;
            }
        </style>
        <div class="container py-5">
            <div class="row g-5">
                <!-- Miniaturas laterales -->
                <!-- <div class="col-md-1 d-none d-md-flex flex-column gap-3">
                                                                                                                        @for ($i = 0; $i < 4; $i++)
    <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" class="img-fluid rounded border" style="cursor:pointer;">
    @endfor
                                                                                                                    </div> -->

                <!-- Imagen principal -->


                <!-- Información del producto -->
                <div class="col-md-11">
                    <div class="bg-white border rounded-4 p-4 shadow d-flex align-items-start"
                        style=" border-radius: 25px ;font-size: 15px; color: #333; box-shadow: 0 0 12px rgba(0,0,0,0.08);">

                        {{-- Imagen a la izquierda --}}
                        <div class="me-4 d-flex align-items-center justify-content-center"
                            style="width: 600px; height: 500px;">
                            @if ($producto->imagen)
                                <img src="data:image/jpeg;base64,{{ base64_encode($producto->imagen) }}" class="img-fluid"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 25px;"
                                    alt="Producto">
                            @else
                                <img src="https://via.placeholder.com/240x240?text=Sin+Imagen" class="img-fluid"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 25px;"
                                    alt="Sin Imagen">
                            @endif
                        </div>

                        {{-- Información del producto a la derecha --}}
                        <div>
                            <!-- Categoría -->
                            <p class="text-muted mb-1" style="font-size: 17px;">
                                {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                            </p>

                            <!-- Nombre del producto -->
                            <h2 class="fw-semibold mb-3" style="color: #1c1c1c; font-size: 22px;">
                                {{ $producto->nombre }}
                            </h2>

                            <!-- Precio -->
                            <div class="mb-3">
                                <span class="fw-bold ms-2" style="color: #ff0000; font-size: 17px;">
                                    S/ {{ number_format($producto->pvp1, 2) }}
                                </span>
                            </div>



                            <!-- Lista de información -->
                            <ul class="list-group list-group-flush mb-4" style="font-size: 14px;">
                                <li class="list-group-item border-0 custom-text-color"><strong>Principio Activo:</strong>
                                    {{ $producto->principio_activo ?? 'N/A' }}</li>
                                <li class="list-group-item border-0 custom-text-color"><strong>Stock:</strong>
                                    {{ $producto->stock }}</li>
                                <li class="list-group-item border-0 custom-text-color"><strong>Vencimiento:</strong>
                                    {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}</li>
                                <li class="list-group-item border-0 custom-text-color"><strong>Categoría:</strong>
                                    {{ $producto->categoria->nombre ?? 'N/A' }}</li>
                                <li class="list-group-item border-0 custom-text-color"><strong>Laboratorio:</strong>
                                    {{ $producto->laboratorio->nombre_laboratorio ?? 'N/A' }}</li>
                            </ul>


                            @php
                                $carrito = session('carrito', []);
                                $enCarrito = isset($carrito[$producto->id]);
                                $presentacionSeleccionada = $enCarrito
                                    ? $carrito[$producto->id]['tipo_compra']
                                    : 'unidad';
                            @endphp
                            <!-- Opciones de compra (siempre visibles) -->
                            <div class="mb-3">
                                <h6 class="fw-bold mb-2" style="font-size: 16px;">Elige la presentación:</h6>
                                <div class="d-flex flex-column gap-2">

                                    <!-- Presentación por defecto -->
                                    <label
                                        class="form-check-label d-flex justify-content-between align-items-center border p-2 rounded">
                                        <div>
                                            <input class="form-check-input me-2 opcion-precio" type="radio"
                                                name="tipo_compra"
                                                value="{{ $producto->presentacion->tipo_presentacion ?? 'unidad' }}"
                                                data-precio="{{ $producto->pvp1 }}" checked>
                                            {{-- Nombre real de la presentación por defecto --}}
                                            {{ $producto->presentacion->tipo_presentacion ?? 'Unidad' }}
                                        </div>
                                        <span class="fw-bold text-danger">S/ {{ number_format($producto->pvp1, 2) }}</span>
                                    </label>



                                    <!-- Blister -->
                                    @if ($producto->precio_blister)
                                        <label
                                            class="form-check-label d-flex justify-content-between align-items-center border p-2 rounded">
                                            <div>
                                                <input class="form-check-input me-2 opcion-precio" type="radio"
                                                    name="tipo_compra" value="blister"
                                                    data-precio="{{ $producto->precio_blister }}"
                                                    {{ strtolower($presentacionSeleccionada) === 'blister' ? 'checked' : '' }}>
                                                Blister
                                            </div>
                                            <span class="fw-bold text-danger">S/
                                                {{ number_format($producto->precio_blister, 2) }}</span>
                                        </label>
                                    @endif

                                    <!-- Caja -->
                                    @if ($producto->precio_caja)
                                        <label
                                            class="form-check-label d-flex justify-content-between align-items-center border p-2 rounded">
                                            <div>
                                                <input class="form-check-input me-2 opcion-precio" type="radio"
                                                    name="tipo_compra" value="caja"
                                                    data-precio="{{ $producto->precio_caja }}"
                                                    {{ strtolower($presentacionSeleccionada) === 'caja' ? 'checked' : '' }}>
                                                Caja
                                            </div>
                                            <span class="fw-bold text-danger">S/
                                                {{ number_format($producto->precio_caja, 2) }}</span>
                                        </label>
                                    @endif

                                </div>
                            </div>




                            <!-- Método de entrega -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-2" style="font-size: 16px;">Método de entrega:</h6>

                                <div class="w-100 d-flex flex-column gap-1 py-3 px-3 bg-white rounded shadow-sm">
                                    <!-- Ícono y Título -->
                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Ícono SVG -->
                                        <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M20.4727 13.5503V17.2773C20.4727 19.3333 18.7621 21 16.6521 21H7.29625C5.18616 21 3.4756 19.3333 3.4756 17.2773V13.5131C3.35906 13.4279 3.24723 13.3359 3.1408 13.2375C2.41548 12.5666 2 11.6482 2 10.6818V9.25888C2 9.2216 2.00279 9.18496 2.00819 9.14914C2.00139 9.06234 2.01064 8.97288 2.03804 8.88455L3.04245 5.64587C3.52968 4.07481 5.01536 3 6.69976 3H17.2017C18.8557 3 20.3218 4.03698 20.8343 5.56925L21.9381 8.86963C21.9599 8.93488 21.9717 9.00097 21.9744 9.06631C21.9911 9.12776 22 9.19231 22 9.25888V10.6818C22 11.6482 21.5845 12.5666 20.8592 13.2375C20.7371 13.3504 20.608 13.4547 20.4727 13.5503ZM4.4661 6.06505C4.76367 5.10554 5.67103 4.44911 6.69976 4.44911H17.2017C18.2118 4.44911 19.1073 5.08243 19.4203 6.01825L20.4695 9.15536C20.4647 9.1892 20.4622 9.22376 20.4622 9.25888V10.6818C20.4622 11.2249 20.2293 11.7541 19.8005 12.1507C19.3704 12.5485 18.7788 12.7784 18.1541 12.7784C17.5293 12.7784 16.9378 12.5485 16.5076 12.1507C16.0788 11.7541 15.8459 11.2249 15.8459 10.6818V10.2075C15.8459 10.1532 15.84 10.1002 15.8288 10.0492C15.7542 9.71147 15.446 9.45827 15.077 9.45827C14.7055 9.45827 14.3954 9.71508 14.3238 10.0565C14.3135 10.1052 14.3081 10.1557 14.3081 10.2074V10.6817C14.3081 11.2248 14.0752 11.7541 13.6464 12.1507C13.2163 12.5485 12.6247 12.7784 12 12.7784C11.3753 12.7784 10.7837 12.5485 10.3536 12.1507C9.92477 11.7541 9.69187 11.2248 9.69187 10.6817V10.2075C9.69187 9.79372 9.34762 9.45827 8.92297 9.45827C8.52709 9.45827 8.20109 9.74978 8.15873 10.1245C8.156 10.1486 8.15445 10.1731 8.15413 10.1978L8.15407 10.2074V10.6817C8.15407 11.2248 7.92117 11.7541 7.49238 12.1507C7.06223 12.5485 6.47065 12.7784 5.84593 12.7784C5.22122 12.7784 4.62964 12.5485 4.19949 12.1507C3.7707 11.7541 3.5378 11.2249 3.5378 10.6818V9.25888C3.5378 9.20732 3.53246 9.15698 3.52228 9.10835L4.4661 6.06505ZM15.077 12.8387C14.9642 12.9793 14.84 13.1127 14.7051 13.2374C13.9812 13.907 13.0074 14.2768 12 14.2768C10.9926 14.2768 10.0188 13.907 9.29487 13.2374C9.15996 13.1127 9.03577 12.9793 8.92298 12.8387C8.81019 12.9793 8.68599 13.1127 8.55107 13.2375C7.82711 13.907 6.85338 14.2768 5.84593 14.2768C5.54671 14.2768 5.25045 14.2442 4.96283 14.1808V17.2773C4.96283 18.5329 6.00754 19.5509 7.29625 19.5509H16.6521C17.9408 19.5509 18.9855 18.5329 18.9855 17.2773V14.1918C18.7141 14.248 18.4354 14.2768 18.1541 14.2768C17.1466 14.2768 16.1729 13.907 15.4489 13.2375C15.314 13.1127 15.1898 12.9793 15.077 12.8387Z"
                                                fill="#243455" />
                                        </svg>
                                        <span class="fw-bold" style="font-size: 16px;">Retiro en botica (Gratis)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón -->
                            @if ($enCarrito)
                                <!-- Ya está en el carrito -->
                                <a href="{{ route('carrito.ver') }}" class="btn text-white w-100 mt-2"
                                    style="background-color: #333; font-size: 20px; border: 2px solid #fff; border-radius: 20px;">
                                    <i class="bi bi-cart-check me-2"></i> Ver carrito
                                </a>
                            @else
                                <!-- Formulario para agregar -->
                                <form method="POST" action="{{ route('carrito.agregar', $producto->id) }}"
                                    id="formAgregar">
                                    @csrf
                                    <input type="hidden" name="cantidad" value="1">
                                    <input type="hidden" name="tipo_compra" id="tipo_compra" value="unidad">
                                    <input type="hidden" name="precio_seleccionado" id="precio_seleccionado"
                                        value="{{ $producto->pvp1 }}">

                                    <button type="submit" class="btn text-white w-100 mt-2"
                                        style="background-color: #ff0000; font-size: 20px; border: 2px solid #fff; border-radius: 20px;">
                                        <i class="bi bi-cart-plus me-2"></i>Agregar al carrito
                                    </button>
                                </form>
                            @endif

                            <!-- Script -->
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    const radios = document.querySelectorAll(".opcion-precio");
                                    const enCarrito = @json($enCarrito);
                                    const productoId = @json($producto->id);

                                    radios.forEach(radio => {
                                        radio.addEventListener("change", function() {
                                            const tipo = this.value;
                                            const precio = this.dataset.precio;

                                            if (!enCarrito) {
                                                // Si aún no está en el carrito, solo actualizamos los inputs ocultos
                                                document.getElementById("tipo_compra").value = tipo;
                                                document.getElementById("precio_seleccionado").value = precio;
                                            } else {
                                                // Si YA está en el carrito -> hacemos AJAX para actualizar presentación
                                                fetch(`/carrito/actualizar-presentacion/${productoId}`, {
                                                        method: "POST",
                                                        headers: {
                                                            "Content-Type": "application/json",
                                                            "X-CSRF-TOKEN": document.querySelector(
                                                                'meta[name="csrf-token"]').content
                                                        },
                                                        body: JSON.stringify({
                                                            tipo_compra: tipo,
                                                            precio_seleccionado: precio
                                                        })
                                                    })
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        console.log("Carrito actualizado:", data);
                                                        // Opcional: refrescar sidebar del carrito
                                                        if (document.getElementById("cart-items")) {
                                                            document.getElementById("cart-items").innerHTML = data
                                                                .sidebar;
                                                        }
                                                    })
                                                    .catch(err => console.error(err));
                                            }
                                        });
                                    });
                                });
                            </script>





                            <!-- Bootstrap Icons -->
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
                                rel="stylesheet">
                        @endsection
