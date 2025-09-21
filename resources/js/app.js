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

// Eliminar producto del carrito desde el sidebar
document.body.addEventListener("click", function (e) {
    if (e.target.classList.contains("eliminar-producto-btn")) {
        const productoId = e.target.dataset.id;

        fetch(`/carrito/eliminar/${productoId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        })
            .then((res) =>
                res.ok
                    ? actualizarSidebarCarrito()
                    : console.error("Error eliminando")
            )
            .catch((err) => console.error("Error:", err));
    }
});

// ✅ Funcionalidad de botones + y - para cantidad
document.addEventListener("click", function (e) {
    const minusBtn = e.target.closest(".quantity-left-minus");
    const plusBtn = e.target.closest(".quantity-right-plus");

    if (minusBtn || plusBtn) {
        const container = e.target.closest(".product-qty");
        if (!container) return;

        // 🔹 CORREGIDO: ahora busca el input visible .input-number
        const inputVisible = container.querySelector(".input-number");
        if (!inputVisible) return;

        let cantidad = parseInt(inputVisible.value) || 1;

        if (plusBtn) {
            cantidad += 1;
        } else if (minusBtn && cantidad > 1) {
            cantidad -= 1;
        }

        inputVisible.value = cantidad;

        // 🔹 sincronizar con el input hidden del form
        const form = container.nextElementSibling; // formulario justo después
        if (form && form.classList.contains("agregar-carrito-form")) {
            const inputOculto = form.querySelector("input[name='cantidad']");
            if (inputOculto) {
                inputOculto.value = cantidad;
            }
        }
    }
});

// ✅ Nuevo: sincronizar si el usuario escribe manualmente en el input visible
document.addEventListener("input", function (e) {
    if (e.target.classList.contains("input-number")) {
        let cantidad = parseInt(e.target.value) || 1;
        if (cantidad < 1) cantidad = 1;
        e.target.value = cantidad;

        // sincronizar hidden
        const container = e.target.closest(".product-qty");
        const form = container ? container.nextElementSibling : null;
        if (form && form.classList.contains("agregar-carrito-form")) {
            const inputOculto = form.querySelector("input[name='cantidad']");
            if (inputOculto) {
                inputOculto.value = cantidad;
            }
        }
    }
});
