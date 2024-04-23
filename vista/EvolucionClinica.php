<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro HC</title>
    <link rel="stylesheet" href="../styles/RegistroPacientes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
    rel="stylesheet"
    /> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
            
        $id = isset($_GET['id']) ? $_GET['id'] : "";

        include("./Nav.php");
        include '../modelo/conexionfiltrar.php';
            $objeto = new Conexion();
            $conexion = $objeto->conectar();

            $sql1 = "SELECT id, name, surname FROM users WHERE profile = 'Medico'";

            $resultado = $conexion->prepare($sql1);
            $resultado->execute();
            $users = $resultado->fetchAll();

            $sql2 = "SELECT id, date, description, attending_physycian	FROM clinical_evolutions WHERE id_clinic_history = $id";

        $resultado = $conexion->prepare($sql2);
        $resultado->execute();
        $clinic_history = $resultado->fetchAll();



if(isset($_POST['btnAgregarEC']))
    {

        $datos = [
            'id_clinic_history'         => $_POST['id_clinic_history'],
            'date'                      => $_POST['date'],
            'description'               => $_POST['description'],
            'attending_physycian'       => $_POST['attending_physycian'],
        ];
        

        if($datos['id_clinic_history'] == ""|| $datos['date'] == ""|| $datos['description'] == ""|| $datos['attending_physycian'] == "") {
            echo "<script> Swal.fire('Todos los campos son obligatorios') </script> ";
        }
        else{
            $sql = "INSERT INTO clinical_evolutions (id_clinic_history,date, description,attending_physycian) values (:id_clinic_history,:date,:description,:attending_physycian)";

            $resultado = $conexion->prepare($sql);
            $resultado->execute($datos);

            echo "<script> Swal.fire('Evolucion registrada exitosamente') </script> ";
        }
    }

?>
<div class="registro-pacientes">
        <div class="form-container-registro">
            <p class='title-registro-pacientes'>Registro de Evolución Clínica</p>

            <form action="" method="post" class="form-registro-pacientes" >
                <input type='hidden' name='id_clinic_history' value='<?php echo $id; ?>' class='input-reg input-address'/>

                <div class='div-content'>
                    <label for="birthdate" class='label-reg'>Fecha:</label>
                    <input type="datetime-local" id="date" name="date" class='input-reg'></input>
                </div>
                <div class='div-content'>
                    <label for='' class='label-reg'>Evolucion medica:</label>
                    <textarea type='text' name='description' placeholder='Ingrese la evolución del paciente' class='input-reg input-address'></textarea>

                </div>
                <div class='div-content'>
                    <label for="identification_type" class='label-reg'>Atendido por:</label>
                    <select name="attending_physycian" class='input-reg' >

                        <option value="" selected disabled>Seleccione el medico</option>
                        <?php 
                            foreach($users as $u){
                              echo "
                                <option value='{$u['id']}'>{$u['name']} {$u['surname']}</option>
                              ";  
                            }
                        ?>
                        
                    </select>
                </div>
                <div class='div-buttons'>       
                    <button class='primary-button-reg' name='btnAgregarEC'>Agregar</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
                <table  class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Atendido por</th>
                        </tr>
                    </thead>
                    
                    <?php
                    
                        foreach ($clinic_history as $key => $ch) {
                            echo "
                                <tr>
                                    <td>{$ch["date"]}</td>
                                    <td>{$ch["description"]}</td>
                                    <td>{$ch["attending_physycian"]}</td>
                                </tr>
                            ";
                        }
                    ?>
                </table>
        </div>     
</div>

      