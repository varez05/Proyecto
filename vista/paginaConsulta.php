<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- <div class="main-container">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#beneficiarioModal">
            Consultar información de beneficiario
        </button>
    </div> -->
    
    <!-- Modal -->
    <div class="modal fade" id="beneficiarioModal" tabindex="-1" aria-labelledby="beneficiarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="beneficiarioModalLabel">Información importante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-info-circle fa-3x text-primary mb-3"></i>
                        <h3>Si eres beneficiario</h3>
                        <p class="lead">Como beneficiario, tienes acceso a diversos servicios y recursos disponibles en nuestra plataforma.</p>
                    </div>
                    <div class="table-responsive">
                        <h5 class="text-center mb-3">Información del beneficiario</h5>
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Documento</th>
                                    <td id="documento"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Nombre</th>
                                    <td id="nombre"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Apellido</th>
                                    <td id="apellido"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Fecha inscripción</th>
                                    <td id="fecha_inscri"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Tipo usuario</th>
                                    <td id="tipo_usuar"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Dirección</th>
                                    <td id="direcc"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Madre</th>
                                    <td id="madre"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Padre</th>
                                    <td id="padre"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Cuidador</th>
                                    <td id="cuidador"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Fecha de nacimiento</th>
                                    <td id="fecha_nacimiento"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Lugar de nacimiento</th>
                                    <td id="lugar_nacimiento"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Sexo</th>
                                    <td id="sexo"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Teléfono</th>
                                    <td id="telefono"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Correo</th>
                                    <td id="correo"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Autoreconocido</th>
                                    <td id="autoreconocido"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Etnia</th>
                                    <td id="etnia"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <p>Para más información, por favor contacta con nuestro servicio de atención al cliente o visita nuestra sección de ayuda.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
        // Automatically show the modal when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('beneficiarioModal'));
            myModal.show();

            // Realizar solicitud AJAX para obtener los datos del beneficiario
            // Obtener los parámetros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const tipoDocumento = urlParams.get('tipo');
            const numeroDocumento = urlParams.get('numero');

            fetch('../Controladores/ctlbeneficiario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `tipoDocumento=${encodeURIComponent(tipoDocumento)}&numeroDocumento=${encodeURIComponent(numeroDocumento)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar los campos de la tabla con los datos obtenidos
                    document.getElementById('documento').textContent = data.data.Numero_documento;
                    document.getElementById('nombre').textContent = data.data.Nombres;
                    document.getElementById('apellido').textContent = data.data.Apellidos;
                    document.getElementById('fecha_inscri').textContent = data.data.Fecha_inscripcion;
                    document.getElementById('tipo_usuar').textContent = data.data.Tipo_usuario;
                    document.getElementById('direcc').textContent = data.data.Direccion;
                    document.getElementById('madre').textContent = data.data.Madre_Nombres || '';
                    document.getElementById('padre').textContent = data.data.Padre_Nombres || '';
                    document.getElementById('cuidador').textContent = data.data.Cuidador_Nombres || '';
                    document.getElementById('fecha_nacimiento').textContent = data.data.Fecha_nacimiento || '';
                    document.getElementById('lugar_nacimiento').textContent = data.data.Lugar_nacimiento || '';
                    document.getElementById('sexo').textContent = data.data.Sexo || '';
                    document.getElementById('telefono').textContent = data.data.Telefono || '';
                    document.getElementById('correo').textContent = data.data.Correo || '';
                    document.getElementById('autoreconocido').textContent = data.data.Autoreconicido || '';
                    document.getElementById('etnia').textContent = data.data.Etnia || '';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al obtener los datos del beneficiario.');
            });

            // Redirigir a la página principal al cerrar o continuar
            document.querySelectorAll('.modal-footer .btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    window.location.href = 'Paginaprincipal.php';
                });
            });
        });
    </script>
</body>
</html>