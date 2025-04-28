const formOpenBtn = document.querySelector("#Abrir_boton"),
      home = document.querySelector(".home"),
      container = document.querySelector(".Container"),
      closeFormBtn = document.querySelector(".form_close"),
      entrarBoton = document.querySelector("#Entrar_boton"),
      togglePassword = document.querySelector("#togglePassword"),
      passwordField = document.querySelector("#passwordField"),
      closeConsultaBtn = document.querySelector(".Consultar_close"),
      abrirConsultaBtn = document.querySelector("#Consultar_boton");

// Mostrar formulario de INGRESAR
formOpenBtn.addEventListener("click", () => {
    home.classList.add("Show");            // Mostrar login
    home.classList.remove("Show_consulta"); // Ocultar consulta
});

// Cerrar formulario de INGRESAR
closeFormBtn.addEventListener("click", () => {
    home.classList.remove("Show");
});

// Mostrar formulario de CONSULTAR
abrirConsultaBtn.addEventListener("click", () => {
    home.classList.add("Show_consulta");   // Mostrar consulta
    home.classList.remove("Show");         // Ocultar login
});

// Cerrar formulario de CONSULTAR
closeConsultaBtn.addEventListener("click", () => {
    home.classList.remove("Show_consulta");
});

// Mostrar/Ocultar contraseña
togglePassword.addEventListener("click", function() {
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
    this.classList.toggle("uil-eye");
    this.classList.toggle("uil-eye-slash");
});
