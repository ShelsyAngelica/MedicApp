<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
}


?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    <link rel='stylesheet' href='../styles/Nav.css'>
</head>
<body>
    
</body>
</html>

<nav class='navbar navbar-expand-lg'>
        <div class='container-fluid'>
            <img src='../assets/logo.png' alt='logo' width='3%' >
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>

            <?php

            if ($_SESSION['profile'] == 'Medico') {
                echo"
                    <li class='nav-item'>
                        <a class='nav-link active text-white' aria-current='page' href='index.php'>Citas</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link text-white' href='listado.php'>Listado Pacientes</a>
                    </li>
                    <li class='nav- item'>
                        <a class='nav-link text-white' href='RegistroPaciente.php'>Registro Paciente</a>
                    </li>  
                    <li class='nav-item'>
                        <a class='nav-link text-white' href='RegistroHC.php'>Registro HC</a>
                    </li>
                ";
            } elseif($_SESSION['profile'] == 'Paciente'){
                echo" 
                    <li class='nav-item'>
                        <a class='nav-link text-white' href='ConsultaPaciente.php'>Consulta</a>
                    </li>
                ";
            }
            
            ?>
                </ul>

                <div class='logout'>
		            <a href='../logout.php' class='btn btn-dark text-white' title='Cerrar Sesión'><i class='fas fa-sign-out-alt'></i></a>
		        </div>
            </div>
        </div>
        
    </nav>