<?php
    ob_start();
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
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    
    <!-- video -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">      
    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
    <!--datables estilo bootstrap 4 CSS-->  
    <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
           
    <!--font awesome con CDN-->  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
</head>
<body>
    <?php
        include("./Nav.php");
        $sql = "SELECT 
            p.id,
            p.name,
            p.surname,
            p.identification_number,
            p.email,
            p.cell_phone,
            p.identification_type,
            p.residence_address,
            p.occupation,
            p.birthdate,
            it.description
        FROM people p
        INNER JOIN identification_types it ON p.identification_type = it.id ";

    $resultado = $conexion->prepare($sql);
    $resultado->execute();
    $people = $resultado->fetchAll();
    
    if(isset($_POST['btnEditar'])){
        $id = $_POST['id'];
        $sql = "SELECT * FROM appointment WHERE id=$id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $obj = $stmt->fetchObject();
    }
   
    if(isset($_POST['btnGuardar'])){
        $id             = $_POST['id'];
        $person_id      = $_POST['person_id'];
        $date           = $_POST['date'];
        $diagnostic     = $_POST['diagnostic'];
        $cost           = $_POST['cost'];
          
        if(!$person_id || !$date || !$diagnostic || !$cost ) {
            echo "<script> Swal.fire('Todos los campos son obligatorios') </script> ";
        }
        else{
            $sql = "UPDATE appointment set 
            person_id = '$person_id' , date = '$date', diagnostic = '$diagnostic',cost = '$cost' WHERE id = $id";

            $resultado = $conexion->prepare($sql);
            $resultado->execute();

            echo "<script> Swal.fire('Cita actualizada exitosamente') </script> ";
            $_SESSION["updated"] = 'Se ha actualizado la cita!';
            header('location:ListadoCitas.php');
        }
    }

        

    ?>
           <div class="form-container-registro">
            <p class='title-registro-pacientes'>Editar cita</p>

            <form action="" method="post" class="form-registro-pacientes" >
                <input type="hidden" name="id" <?php echo "value='$obj->id'"?>>
                <div class='div-content'>
                    <label for="identification_type" class='label-reg'>Paciente:</label>
                    <select name="person_id" class='input-reg' >

                        <?php 
                            foreach($people as $date){
                              
                                if($date['id'] == $obj->person_id ){
                                    echo "<option selected value='{$date['id']}'>{$date['name']} {$date['surname']}</option>"; 
                                }
                            }
                        ?>
                    </select>
                </div>
    
                <div class='div-content'>
                    <label for="date_at" class="label-reg">Fecha:</label>
                    <input type="datetime-local" name="date" required class="input-reg input-address" <?php echo "value='$obj->date'"?>/>
                </div>
                
                <div class='div-content'>
                    <label for="cell_phone" class="label-reg">Diagnostico:</label>
                    <input type="text" name="diagnostic" required placeholder="Ingrese el diagnostico" class="input-reg input-address" <?php echo "value='$obj->diagnostic'"?>/>
                </div>                
                
                <div class='div-content'>
                    <label for="occupation" class="label-reg">Costo:</label>
                    <input type="text" name="cost" required placeholder="Ingrese el costo" class="input-reg input-diagnostic" <?php echo "value='$obj->cost'"?>/>
                </div>
    
                <div class='div-buttons'>
                    <!-- <button class="secondary-button-reg button-cancel">Cancelar</button> -->
                    <button class="primary-button-reg" name="btnGuardar">Guardar</button>
                </div>
            </form>

            <a href="ListadoCitas.php"><button type="button" class="secondary-button-reg button-cancel">Cancelar</button></a>
        </div>    
        </div>
    </div>    
    
    <!-- Pooper bootstrap -->
    <script type="text/javascript" src="../jquery/jquery-3.3.1.min.js"></script>


     <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="../jquery/jquery-3.3.1.min.js"></script>
    <script src="../popper/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="../datatables/datatables.min.js"></script>    
     
    <!-- para usar botones en datatables JS -->  
    <script src="../datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="../datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="../datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="../datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="../datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
     
    <!-- código JS propìo-->    
    <script type="text/javascript" src="../js/main.js"></script>  
    
</body>
</html>