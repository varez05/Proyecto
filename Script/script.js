const formOpenBtn = document.querySelector("#Abrir_boton"),
      home = document.querySelector(".home"),
      container = document.querySelector(".Container"),
      closeFormBtn = document.querySelector(".form_close"),
      entrarBoton = document.querySelector("#Entrar_boton"),
      togglePassword = document.querySelector("#togglePassword"),
      passwordField = document.querySelector("#passwordField"),
      closeConsultaBtn = document.querySelector(".Consultar_close"),
      abrirConsultaBtn = document.querySelector("#Consultar_boton"),
      exitoBoton = document.querySelector("#Exito_boton"),
      modalContactanos = document.getElementById("modalContactanos"),
      closeModalContactanos = document.getElementById("closeModalContactanos");

// Mostrar formulario de INGRESAR
if (formOpenBtn && home) {
    formOpenBtn.addEventListener("click", () => {
        home.classList.add("Show");            // Mostrar login
        home.classList.remove("Show_consulta"); // Ocultar consulta
    });
}

// Cerrar formulario de INGRESAR
if (closeFormBtn && home) {
    closeFormBtn.addEventListener("click", () => {
        home.classList.remove("Show");
    });
}

// Mostrar formulario de CONSULTAR
if (abrirConsultaBtn && home) {
    abrirConsultaBtn.addEventListener("click", () => {
        home.classList.add("Show_consulta");   // Mostrar consulta
        home.classList.remove("Show");         // Ocultar login
    });
}

// Cerrar formulario de CONSULTAR
if (closeConsultaBtn && home) {
    closeConsultaBtn.addEventListener("click", () => {
        home.classList.remove("Show_consulta");
    });
}

// Mostrar/Ocultar contraseña
if (togglePassword && passwordField) {
    togglePassword.addEventListener("click", function() {
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        this.classList.toggle("uil-eye");
        this.classList.toggle("uil-eye-slash");
    });
}

// Mostrar el modal de Éxito
if (exitoBoton && modalContactanos) {
    exitoBoton.addEventListener("click", () => {
        modalContactanos.style.display = "block";
        document.body.style.overflow = "hidden"; // Deshabilitar scroll
    });
}

// Cerrar el modal de Contactanos
if (closeModalContactanos && modalContactanos) {
    closeModalContactanos.addEventListener("click", () => {
        console.log("Botón de cierre del modal clickeado");
        modalContactanos.style.display = "none";
        document.body.style.overflow = ""; // Restaurar scroll
    });
}

// Cerrar el modal al hacer clic fuera del contenido
if (modalContactanos) {
    modalContactanos.addEventListener("click", (event) => {
        if (event.target === modalContactanos) {
            modalContactanos.style.display = "none";
            document.body.style.overflow = "";
        }
    });
}

