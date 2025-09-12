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

// ✅ Función central para refrescar sidebar y vista de productos
function actualizarSidebarCarrito() {
    fetch("/carrito/sidebar")
        .then((res) => res.text())
        .then((html) => {
            const cartSidebar = document.getElementById("cartSidebar");
            if (cartSidebar) {
                cartSidebar.innerHTML = html;
            }

            // --- 🔥 Extra: actualizar los botones de productos ---
            const productosEnCarrito = [
                ...document.querySelectorAll("#cartSidebar .cart-item"),
            ].map((item) => item.dataset.id); // ids de productos en carrito

            document
                .querySelectorAll("[id^='carrito-container-']")
                .forEach((container) => {
                    const productoId = container.id.replace(
                        "carrito-container-",
                        ""
                    );

                    if (productosEnCarrito.includes(productoId)) {
                        // Mostrar "Ver carrito"
                        container.innerHTML = `
                            <a href="/carrito/ver" class="btn btn-outline-success w-100 fw-semibold">
                                Ver carrito
                                <i class="bi bi-cart-check-fill ms-2"></i>
                            </a>
                        `;
                    } else {
                        // Mostrar "Agregar" otra vez
                        container.innerHTML = `
                            <div class="d-flex w-100 align-items-center">
                                <div class="input-group product-qty" style="width: 50%;">
                                    <button type="button" class="quantity-left-minus btn-number">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                                            <use xlink:href="#minus"></use>
                                        </svg>
                                    </button>
                                    <input type="text" class="form-control input-number text-center" value="1" style="max-width: 50px;">
                                    <button type="button" class="quantity-right-plus btn-number">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <use xlink:href="#plus"></use>
                                        </svg>
                                    </button>
                                </div>
                                <form method="POST" action="/carrito/agregar/${productoId}" class="agregar-carrito-form ms-3 flex-grow-1">
                                    <input type="hidden" name="_token" value="${
                                        document.querySelector(
                                            'meta[name="csrf-token"]'
                                        ).content
                                    }">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="w-100 fw-semibold btn-add-cart">
                                        Agregar
                                        <i class="bi bi-cart"></i>
                                    </button>
                                </form>
                            </div>
                        `;
                    }
                });
        })
        .catch((err) => console.error("Error actualizando carrito:", err));
}

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
