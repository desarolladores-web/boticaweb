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

// 🔄 Función global para refrescar el sidebar del carrito
window.actualizarSidebarCarrito = function () {
    fetch("/carrito/sidebar")
        .then((res) => {
            if (!res.ok) throw new Error("Error al cargar sidebar");
            return res.text();
        })
        .then((html) => {
            const sidebar = document.querySelector(
                "#cartSidebar .offcanvas-body"
            );
            if (sidebar) {
                sidebar.innerHTML = html;
            }
        })
        .catch((err) => {
            console.error("[carrito] Error actualizando sidebar:", err);
        });
};

// 🗑️ Eliminar producto del carrito
document.body.addEventListener("click", function (e) {
    const btn = e.target.closest(".eliminar-producto-btn");
    if (!btn) return;

    const productoId = btn.dataset.id;
    if (!productoId) return;

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

            // Restaurar botón "Agregar" en la carta de producto
            const container = document.getElementById(
                "carrito-container-" + productoId
            );
            const template = document.getElementById(
                "form-agregar-" + productoId
            );

            if (container && template) {
                container.innerHTML = template.innerHTML;
            }

            // Refrescar el sidebar
            if (typeof actualizarSidebarCarrito === "function") {
                actualizarSidebarCarrito();
            }
        })
        .catch((err) => {
            console.error("Error eliminando producto del carrito:", err);
        });
});

// ➕➖ Botones de cantidad
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

        // Actualizar input oculto del formulario siguiente
        const form = container.nextElementSibling;
        if (form && form.classList.contains("agregar-carrito-form")) {
            const inputOculto = form.querySelector("input[name='cantidad']");
            if (inputOculto) {
                inputOculto.value = cantidad;
            }
        }
    }
});
