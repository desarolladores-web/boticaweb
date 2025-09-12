import "./bootstrap";

/**
 * app.js corregido (usar en Vite / resources/js/app.js)
 * - No redefine actualizarSidebarCarrito (usa la función que ya tienes en app.blade).
 * - Restaura el template del producto al eliminar.
 * - Sincroniza input visible (.input-number) con input oculto name="cantidad".
 */

document.addEventListener("DOMContentLoaded", function () {
    // Sidebar open/close
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

    // Restaurar scroll guardado
    const savedScroll = sessionStorage.getItem("scrollPosition");
    if (savedScroll) {
        window.scrollTo(0, parseInt(savedScroll));
        sessionStorage.removeItem("scrollPosition");
    }

    // Guardar scroll antes de enviar formularios (mantener UX)
    const forms = document.querySelectorAll("form.agregar-carrito-form");
    forms.forEach((form) => {
        form.addEventListener("submit", function () {
            sessionStorage.setItem("scrollPosition", window.scrollY);
        });
    });
});

/* ===========================
   Eliminar producto (delegación)
   =========================== */
document.body.addEventListener("click", function (e) {
    const btn = e.target.closest(".eliminar-producto-btn");
    if (!btn) return;

    const productoId = btn.dataset.id;
    if (!productoId) return;

    // petición al backend
    fetch(`/carrito/eliminar/${productoId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
        },
    })
        .then((res) => {
            // intentar leer JSON (la ruta en tu app devuelve JSON)
            if (!res.ok) throw res;
            return res.json();
        })
        .then((data) => {
            // Si tu backend devuelve { eliminado: true, producto_id, cantidadTotal, ... }
            const idResp = data.producto_id ?? productoId;

            // Restaurar el template del producto (si existe en la vista)
            const tarjetaContainer = document.getElementById(
                "carrito-container-" + idResp
            );
            const template = document.getElementById("form-agregar-" + idResp);
            if (tarjetaContainer && template) {
                tarjetaContainer.innerHTML = template.innerHTML;
            }

            // Actualizar contador global si viene en la respuesta
            if (typeof data.cantidadTotal !== "undefined") {
                const contador = document.getElementById("contador-carrito");
                if (contador) contador.textContent = data.cantidadTotal;
            }

            // Llamar a la función del layout (definida en app.blade) para refrescar items y total
            if (typeof window.actualizarSidebarCarrito === "function") {
                window.actualizarSidebarCarrito();
            } else {
                // Si por alguna razón no existe, lo notificamos en consola
                console.warn(
                    "[app.js] window.actualizarSidebarCarrito() no definida"
                );
            }
        })
        .catch((err) => {
            // Mostrar errores de la petición o errores de CORS/419/500
            console.error("Error eliminando producto del carrito:", err);
            // Si err es Response, puedes revisar err.status en consola
            if (err && err.status) console.error("Status:", err.status);
        });
});

/* ===========================
   Botones + / - de cantidad (delegación, compatible con DOM dinámico)
   =========================== */
document.addEventListener("click", function (e) {
    const minusBtn = e.target.closest(".quantity-left-minus");
    const plusBtn = e.target.closest(".quantity-right-plus");

    if (!minusBtn && !plusBtn) return;

    // localizar el contenedor .product-qty donde están los botones e input visible
    const btn = minusBtn || plusBtn;
    const productQty = btn.closest(".product-qty");
    if (!productQty) return;

    // input visible (el que el usuario ve)
    const inputVisible =
        productQty.querySelector("input.input-number") ||
        productQty.querySelector("input[type='text']");
    let cantidad = parseInt(inputVisible?.value) || 1;

    if (plusBtn) cantidad += 1;
    else if (minusBtn && cantidad > 1) cantidad -= 1;

    // actualizar visible
    if (inputVisible) inputVisible.value = cantidad;

    // actualizar el input oculto del form siguiente (si existe)
    const form = productQty.nextElementSibling;
    if (form && form.classList.contains("agregar-carrito-form")) {
        const inputOculto = form.querySelector("input[name='cantidad']");
        if (inputOculto) inputOculto.value = cantidad;
    }
});
