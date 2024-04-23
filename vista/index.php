<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/index.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> 
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
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js
    "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css
    " rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Inicio</title>
</head>
<body>
    <?php
        include("./Nav.php");

        include '../modelo/conexionfiltrar.php';
            $objeto = new Conexion();
            $conexion = $objeto->conectar();

            $sql = "SELECT * FROM people ";

        $resultado = $conexion->prepare($sql);
        $resultado->execute();
        $people = $resultado->fetchAll();


    if(isset($_POST['btnGuardar']))
    {

        $datos = [
            'person_id'        => $_POST['person_id'],
            'date'             => $_POST['date'],
            'diagnostic'       => $_POST['diagnostic'],
            'cost'             => $_POST['cost'],
        ];
        
        if($datos['person_id'] == "" || $datos['date'] == ""|| $datos['diagnostic'] == ""|| $datos['cost'] == "") {
            echo "<script> Swal.fire('Todos los campos son obligatorios') </script> ";
        }
        else{
            $sql = "INSERT INTO appointment (person_id,date,diagnostic, cost) values (:person_id,:date,:diagnostic,:cost)";

            $resultado = $conexion->prepare($sql);
            $resultado->execute($datos);

            echo "<script> Swal.fire('Cita registrada exitosamente') </script> ";
        }
    }

    ?>
    
    <div class="jumbotron jumbotron-fluid">
        <h1 class="display-4">Bienvenid@, <?php echo $_SESSION['name']; ?>!</h1>
        <p class="lead">Tu perfil de acceso es: <?php echo$_SESSION['profile'];?>.</p>
        <hr class="my-4">
    </div>

    <div class="registro-pacientes">
        <div class='div-buttons'>
            <a href="ListadoCitas.php" class="secondary-button-reg button-cancel><button class="secondary-button-reg button-cancel">Listar citas</button></a>        
        </div>

        <div class="form-container-registro">
            <p class='title-registro-pacientes'>Agendar cita</p>

            <form action="" method="post" class="form-registro-pacientes" >
                
                <div class='div-content'>
                    <label for="identification_type" class='label-reg'>Paciente:</label>
                    <select name="person_id" class='input-reg' >

                        <option value="" selected disabled>Seleccione el paciente</option>
                        <?php 
                            foreach($people as $p){
                              echo "
                                <option value='{$p['id']}'>{$p['name']} {$p['surname']}</option>
                              ";  
                            }
                        ?>
                        
                    </select>
                </div>
    
                <div class='div-content'>
                    <label for="date_at" class="label-reg">Fecha:</label>
                    <input type="datetime-local" name="date" required class="input-reg input-address"/>
                </div>
                
                <div class='div-content'>
                    <label for="cell_phone" class="label-reg">Diagnostico:</label>
                    <input type="text" name="diagnostic" required placeholder="Ingrese el diagnostico" class="input-reg input-address"/>
                </div>                
                
                <div class='div-content'>
                    <label for="occupation" class="label-reg">Costo:</label>
                    <input type="text" name="cost" required placeholder="Ingrese el costo" class="input-reg input-diagnostic"/>
                </div>
    
                <div class='div-buttons'>
                    <!-- <button class="secondary-button-reg button-cancel">Cancelar</button> -->
                    <button class="primary-button-reg" name="btnGuardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

 