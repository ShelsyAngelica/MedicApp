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


    if(isset($_POST['btnEditar']))
    {

        $id = $_POST['id'];
        $sql = "SELECT * FROM people WHERE id=$id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $obj = $stmt->fetchObject();
    }

    ?>

    <?php
    if(isset($_POST['btnGuardar'])){
        $id                      = $_POST['id'];
        $name                    = $_POST['name'];
        $surname                 = $_POST['surname'];
        $identification_type     = $_POST['identification_type'];
        $identification_number   = $_POST['identification_number'];
        $birthdate               = $_POST['birthdate'];
        $residence_address       = $_POST['residence_address'];
        $cell_phone              = $_POST['cell_phone'];
        $occupation              = $_POST['occupation'];
        $email                   = $_POST['email'];

        
       


        if($name == "" || $surname == ""|| $identification_type == ""|| $identification_number == ""|| $birthdate == ""|| $residence_address == ""|| $cell_phone == ""|| $occupation == ""||  $email == "") {
            echo "<script> Swal.fire('Todos los campos son obligatorios') </script> ";
        }
        else{
            $sql = "UPDATE people set 
            name = '$name', surname = '$surname', identification_type = '$identification_type', identification_number = '$identification_number', birthdate = '$birthdate',residence_address = '$residence_address', cell_phone = '$cell_phone', occupation = '$occupation', email = '$email' WHERE id = $id";

            $resultado = $conexion->prepare($sql);
            $resultado->execute();

            echo "<script> Swal.fire('Datos registrados exitosamente') </script> ";
            header('location:listado.php');
        }



    }

    ?>

    <div class="registro-pacientes">
        <div class="form-container-registro">
            <p class='title-registro-pacientes'>Editar pacientes</p>

            <form action="" method="post" class="form-registro-pacientes" >
                <input name='id' type='hidden'  <?php echo "value='$obj->id'"?>/>

                <div class='div-content'>
                    <label for="name" class="label-reg">Nombres:</label>
                    <input type="text" name="name" placeholder="Ingrese su nombre " class="input-reg input-name-reg" <?php echo "value='$obj->name'"?>/>
                </div>
                
                <div class='div-content'>   
                    <label for="surname" class="label-reg">Apellidos:</label>
                    <input type="text" name="surname" placeholder="Ingrese su apellido" class="input-reg input-surname-reg" <?php echo "value='$obj->surname'"?>/>
                </div>
                
                <div class='div-content'>
                    <label for="identification_type" class='label-reg'>Tipo de documento:</label>
                    <select name="identification_type" id="identification_type" class='input-reg' >

                        <option value=""  disabled>Seleccione su tipo de documento</option>
                        <?php 
                            foreach($tipos_de_identificacion as $tipo_de_identificacion){
                                if($tipo_de_identificacion['id'] == $obj->identification_type){
                                    echo "
                                        <option selected value='{$tipo_de_identificacion['id']}'>{$tipo_de_identificacion['description']}</option>
                                    "; 
                                }else{
                                    echo "
                                        <option value='{$tipo_de_identificacion['id']}'>{$tipo_de_identificacion['description']}</option>
                                    "; 
                                }
                                 
                            }
                        ?>
                        
                    </select>
                </div>
    
                <div class='div-content'>
                    <label for="identification_number" class="label-reg">Numero identificación:</label>
                    <input type="text" name="identification_number" placeholder="Ingrese su numero de identificación" class="input-reg input-address" <?php echo "value='$obj->identification_number'"?>/>
                </div>
                
                <div class='div-content'>
                    <label for="birthdate" class='label-reg'>Fecha Nacimiento:</label>
                    <input type="date" id="birthdate" name="birthdate"value="2023-03-29" class='input-reg' <?php echo "value='$obj->birthdate'"?>></input>
                </div>
    
                <div class='div-content'>
                    <label for="residence_address" class="label-reg">Dirección:</label>
                    <input type="text" name="residence_address" placeholder="Ingrese su dirección" class="input-reg input-address" <?php echo "value='$obj->residence_address'"?>/>
                </div>
                
                <div class='div-content'>
                    <label for="cell_phone" class="label-reg">Telefono:</label>
                    <input type="text" name="cell_phone" placeholder="Ingrese su numero de telefono" class="input-reg input-address" <?php echo "value='$obj->cell_phone'"?>/>
                </div>                
                
                <div class='div-content'>
                    <label for="occupation" class="label-reg">Ocupacion:</label>
                    <input type="text" name="occupation" placeholder="Ingrese su ocupación" class="input-reg input-diagnostic" <?php echo "value='$obj->occupation'"?>/>
                </div>

                <div class='div-content'>
                    <label for="email" class="label-reg">Email:</label>
                    <input type="email" name="email" placeholder="Ingrese su email" class="input-reg input-diagnostic" <?php echo "value='$obj->email'"?>/>
                </div>
    
                <div class='div-buttons'>
                    <button class="primary-button-reg" name="btnGuardar">Guardar</button>
                </div>
            </form>

            <a href="listado.php"><button type="button" class="secondary-button-reg button-cancel">Cancelar</button></a>

        </div>
    </div>
</body>
</html>