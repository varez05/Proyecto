

async function cargarDatosDinamicos() {
    try {
        // Cargar cuidadores
        const responseCuidadores = await fetch('../Controladores/FamiliasController.php?obtener_cuidadores');
        const cuidadores = await responseCuidadores.json();
        const selectCuidador = document.getElementById('id_cuidador');
        selectCuidador.innerHTML = '<option value="">Seleccione un cuidador</option>';
        cuidadores.forEach(cuidador => {
            const option = document.createElement('option');
            option.value = cuidador.Id_cuidador;
            option.textContent = `${cuidador.Nombres} ${cuidador.Apellidos}`;
            selectCuidador.appendChild(option);
        });

        // Cargar padres
        const responsePadres = await fetch('../Controladores/FamiliasController.php?obtener_padres');
        const padres = await responsePadres.json();
        const selectPadre = document.getElementById('id_padre');
        selectPadre.innerHTML = '<option value="">Seleccione un padre</option>';
        padres.forEach(padre => {
            const option = document.createElement('option');
            option.value = padre.Id_padre;
            option.textContent = `${padre.Nombres} ${padre.Apellidos}`;
            selectPadre.appendChild(option);
        });

        // Cargar madres
        const responseMadres = await fetch('../Controladores/FamiliasController.php?obtener_madres');
        const madres = await responseMadres.json();
        const selectMadre = document.getElementById('id_madre');
        selectMadre.innerHTML = '<option value="">Seleccione una madre</option>';
        madres.forEach(madre => {
            const option = document.createElement('option');
            option.value = madre.Id_madre;
            option.textContent = `${madre.Nombres} ${madre.Apellidos}`;
            selectMadre.appendChild(option);
        });
    } catch (error) {
        console.error('Error al cargar los datos dinámicos:', error);
    }
}

// Llamar a la función al cargar la página o abrir el modal
cargarDatosDinamicos();

