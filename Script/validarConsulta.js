document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.ContainerConsulta form');
    form.addEventListener('submit', function(e) {
        const tipo = document.getElementById('tipoDocumento').value;
        const numero = document.getElementById('numeroDocumento').value.trim();
        if (!tipo || !numero) {
            alert('Por favor, complete todos los campos.');
            e.preventDefault();
        }
        // Solo permitir números en el campo de documento
        if (!/^\d+$/.test(numero)) {
            alert('El número de documento debe contener solo números.');
            e.preventDefault();
        }
    });
});