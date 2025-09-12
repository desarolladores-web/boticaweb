import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    const cartBtn = document.querySelector(".header-cart-icon");
    const cartSidebar = document.getElementById("cartSidebar");
    const closeCartBtn = document.getElementById("closeCartBtn");
    const backdrop = document.getElementById("cartBackdrop");

    if (cartBtn && cartSidebar && closeCartBtn && backdrop) {
        cartBtn.addEventListener("click", function (e) {
            e.preventDefault();
            cartSidebar.classList.add("show");
            backdrop.classList.add("show");
        });

        closeCartBtn.addEventListener("click", function () {
            cartSidebar.classList.remove("show");
            backdrop.classList.remove("show");
        });

        backdrop.addEventListener("click", function () {
            cartSidebar.classList.remove("show");
            backdrop.classList.remove("show");
        });
    }

    // ✅ Restaurar posición del scroll si fue guardada antes
    const savedScroll = sessionStorage.getItem("scrollPosition");
    if (savedScroll) {
        window.scrollTo(0, parseInt(savedScroll));
        sessionStorage.removeItem("scrollPosition");
    }

    // ✅ Guardar scroll antes de enviar el formulario de carrito
    const forms = document.querySelectorAll("form.agregar-carrito-form");
    forms.forEach((form) => {
        form.addEventListener("submit", function () {
            sessionStorage.setItem("scrollPosition", window.scrollY);
        });
    });
});

// Eliminar producto del carrito desde el sidebar (mejorado y robusto)
document.body.addEventListener("click", function (e) {
    const btn = e.target.closest(".eliminar-producto-btn");
    if (!btn) return;

    const productoId = btn.dataset.id;
    if (!productoId) return;

    // DEBUG temporal:
    console.log("[carrito] eliminar producto id=", productoId);

    fetch(`/carrito/eliminar/${productoId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((res) => {
            if (!res.ok) throw new Error("Respuesta no OK: " + res.status);
            // Ya fue eliminado en backend -> actualizar UI localmente:
            const container = document.getElementById(
                "carrito-container-" + productoId
            );
            const template = document.getElementById(
                "form-agregar-" + productoId
            );

            if (container) {
                if (template) {
                    // Restaurar el html original desde el <template> (recomendado)
                    container.innerHTML = template.innerHTML;
                    console.log(
                        "[carrito] restaurado desde template para producto",
                        productoId
                    );
                } else {
                    // Fallback: insertar un form básico (si no existe template)
                    container.innerHTML = `
                    <div class="d-flex w-100 align-items-center">
                        <div class="input-group product-qty" style="width: 50%;">
                            <button type="button" class="quantity-left-minus btn-number">-</button>
                            <input type="text" class="form-control input-number text-center" value="1" style="max-width:50px;">
                            <button type="button" class="quantity-right-plus btn-number">+</button>
                        </div>
                        <form method="POST" action="/carrito/agregar/${productoId}" class="agregar-carrito-form ms-3 flex-grow-1">
                            <input type="hidden" name="_token" value="${
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content
                            }">
                            <input type="hidden" name="cantidad" value="1">
                            <button type="submit" class="w-100 fw-semibold btn-add-cart">Agregar <i class="bi bi-cart"></i></button>
                        </form>
                    </div>
                `;
                    console.log(
                        "[carrito] restaurado con fallback para producto",
                        productoId
                    );
                }
            } else {
                console.warn(
                    "[carrito] no se encontró contenedor carrito-container-" +
                        productoId
                );
            }

            // Llamar a la función global que refresca el sidebar (si existe)
            if (typeof actualizarSidebarCarrito === "function") {
                actualizarSidebarCarrito();
            } else {
                console.warn(
                    "[carrito] actualizarSidebarCarrito() no está definida."
                );
            }
        })
        .catch((err) => {
            console.error("Error eliminando producto del carrito:", err);
        });
});

// Funcionalidad de botones + y - para cantidad
document.addEventListener("click", function (e) {
    const minusBtn = e.target.closest(".quantity-left-minus");
    const plusBtn = e.target.closest(".quantity-right-plus");

    if (minusBtn || plusBtn) {
        const container = e.target.closest(".product-qty");
        if (!container) return;

        const inputVisible = container.querySelector("input[name='cantidad']");
        let cantidad = parseInt(inputVisible.value);

        if (plusBtn) {
            cantidad += 1;
        } else if (minusBtn && cantidad > 1) {
            cantidad -= 1;
        }

        inputVisible.value = cantidad;

        // Actualizar el input oculto del formulario siguiente
        const form = container.nextElementSibling; // formulario está justo después del div con los botones
        if (form && form.classList.contains("agregar-carrito-form")) {
            const inputOculto = form.querySelector("input[name='cantidad']");
            if (inputOculto) {
                inputOculto.value = cantidad;
            }
        }
    }
});
