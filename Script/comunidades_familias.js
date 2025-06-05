document.addEventListener('DOMContentLoaded', function() {
    fetch('../modales/get_comunidades.php')
        .then(response => response.json())
        .then(data => {
            const selects = document.querySelectorAll('#id_familia_comunidad');
            selects.forEach(select => {
                data.forEach(comunidad => {
                    const option = document.createElement('option');
                    option.value = comunidad.Id_comunidad;
                    option.textContent = comunidad.Nombre_comunidad;
                    select.appendChild(option);
                });
            });
        })
        .catch(error => console.error('Error cargando comunidades:', error));
});
