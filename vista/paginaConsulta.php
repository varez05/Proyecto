<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .main-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .modal-header {
            background-color: #4e73df;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#beneficiarioModal">
            Consultar información de beneficiario
        </button>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="beneficiarioModal" tabindex="-1" aria-labelledby="beneficiarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="beneficiarioModalLabel">Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-info-circle fa-3x text-primary mb-3"></i>
                        <h3>Si eres beneficiario</h3>
                        <p class="lead">Como beneficiario, tienes acceso a diversos servicios y recursos disponibles en nuestra plataforma.</p>
                        <hr>
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
        });
    </script>
</body>
</html>