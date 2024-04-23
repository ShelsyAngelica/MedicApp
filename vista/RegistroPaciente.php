<?php
    include_once '../modelo/conexionfiltrar.php';
    $objeto = new Conexion();
    $conexion = $objeto->conectar();

    $consulta = "SELECT * FROM identification_types";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $tipos_de_identificacion = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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


    <!-- Controlador de registrar -->
    <?php
    include("./Nav.php");


    if(isset($_POST['btnGuardar']))
    {

        $datos = [
            'name'                   => $_POST['name'],
            'surname'                => $_POST['surname'],
            'identification_type'    => isset($_POST['identification_type'])?$_POST['identification_type'] : "",
            'email'                  => $_POST['email'],
            'cell_phone'             => $_POST['cell_phone'],
            'identification_number'  => $_POST['identification_number'],
            'residence_address'      => $_POST['residence_address'],
            'occupation'             => $_POST['occupation'],
            'birthdate'              => $_POST['birthdate'],
        ];
        

        if($datos['name'] == "" || $datos['surname'] == ""|| $datos['identification_type'] == ""|| $datos['identification_number'] == ""|| $datos['birthdate'] == ""|| $datos['residence_address'] == ""|| $datos['cell_phone'] == ""|| $datos['occupation'] == ""||  $datos['email'] == "") {
            echo "<script> Swal.fire('Todos los campos son obligatorios') </script> ";
        }
        else{
            $sql = "INSERT INTO people (name,surname,identification_type, email, cell_phone, identification_number,residence_address,occupation, birthdate) values (:name,:surname,:identification_type,:email,:cell_phone,:identification_number,:residence_address,:occupation,:birthdate)";

            $resultado = $conexion->prepare($sql);
            $resultado->execute($datos);

            echo "<script> Swal.fire('Datos registrados exitosamente') </script> ";
        }
    }

    ?>

    <div class="registro-pacientes">
        <div class="form-container-registro">
            <p class='title-registro-pacientes'>Registro paciente</p>

            <form action="" method="post" class="form-registro-pacientes" >

                <div class='div-content'>
                    <label for="name" class="label-reg">Nombres:</label>
                    <input type="text" name="name" placeholder="Ingrese su nombre " class="input-reg input-name-reg"/>
                </div>
                
                <div class='div-content'>   
                    <label for="surname" class="label-reg">Apellidos:</label>
                    <input type="text" name="surname" placeholder="Ingrese su apellido" class="input-reg input-surname-reg"/>
                </div>
                
                <div class='div-content'>
                    <label for="identification_type" class='label-reg'>Tipo de documento:</label>
                    <select name="identification_type" id="identification_type" class='input-reg' >

                        <option value="" selected disabled>Seleccione su tipo de documento</option>
                        <?php 
                            foreach($tipos_de_identificacion as $tipo_de_identificacion){
                              echo "
                                 <option value='{$tipo_de_identificacion['id']}'>{$tipo_de_identificacion['description']}</option>
                              ";  
                            }
                        ?>
                        
                    </select>
                </div>
    
                <div class='div-content'>
                    <label for="identification_number" class="label-reg">Numero identificación:</label>
                    <input type="text" name="identification_number" placeholder="Ingrese su numero de identificación" class="input-reg input-address"/>
                </div>
                
                <div class='div-content'>
                    <label for="birthdate" class='label-reg'>Fecha Nacimiento:</label>
                    <input type="date" id="birthdate" name="birthdate"value="2023-03-29" class='input-reg'></input>
                </div>
    
                <div class='div-content'>
                    <label for="residence_address" class="label-reg">Dirección:</label>
                    <input type="text" name="residence_address" placeholder="Ingrese su dirección" class="input-reg input-address"/>
                </div>
                
                <div class='div-content'>
                    <label for="cell_phone" class="label-reg">Telefono:</label>
                    <input type="text" name="cell_phone" placeholder="Ingrese su numero de telefono" class="input-reg input-address"/>
                </div>                
                
                <div class='div-content'>
                    <label for="occupation" class="label-reg">Ocupacion:</label>
                    <input type="text" name="occupation" placeholder="Ingrese su ocupación" class="input-reg input-diagnostic"/>
                </div>

                <div class='div-content'>
                    <label for="email" class="label-reg">Email:</label>
                    <input type="email" name="email" placeholder="Ingrese su email" class="input-reg input-diagnostic"/>
                </div>
    
                <div class='div-buttons'>
                    <button class="secondary-button-reg button-cancel">Cancelar</button>
                    <button class="primary-button-reg" name="btnGuardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>