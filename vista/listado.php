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
    ?>
    
    <div class="registro-pacientes">
        <div class="form-container-registro">
            <p class='title-registro-pacientes'>Listado Paciente</p>

            <!-- modulo listado -->
            <?php
                include '../modelo/conexionfiltrar.php';
                $objeto = new Conexion();
                $conexion = $objeto->conectar();
                
                if(isset($_POST['btnEliminar'])){
                    $id = $_POST['id'];

                    if($id == ""){
                        echo "<script> Swal.fire('ocurrio un problema intente de nuevo mas tarde') </script> ";
                    } else{
                        $sql = "DELETE FROM people WHERE id=?";
                        $stmt= $conexion->prepare($sql);
                        $stmt->execute([ $id]);
                        echo "<script> Swal.fire('persona eliminada') </script> ";
                    }


                }

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
            ?>

            <div class="table-responsive">
                <table id="example" class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Tipo de documento</th>
                            <th>Numero de documento</th>
                            <th>Fecha de nacimiento</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>Ocupacion</th>
                            <th>Email</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    
                    <?php
                    if (isset($people)) {
                        foreach ($people as $key => $person) {
                            echo "
                                <tr>
                                    <td>{$person["name"]}</td>
                                    <td>{$person["surname"]}</td>
                                    <td>{$person["description"]}</td>
                                    <td>{$person["identification_number"]}</td>
                                    <td>{$person["birthdate"]}</td>
                                    <td>{$person["residence_address"]}</td>
                                    <td>{$person["cell_phone"]}</td>
                                    <td>{$person["occupation"]}</td>
                                    <td>{$person["email"]}</td>
                                    <td>

                                    
                                    <div class='d-flex'>
                                        <form action='' method='post' class='form-registro-pacientes'>
                                            <input name='id' type='hidden' value='{$person["id"]}'/>
                                            <button type='submit' class='btn btn-danger btn-sm text-white' name='btnEliminar'>Borrar</button>
                                        </form>

                                        <form action='EdicionPaciente.php' method='post' class='form-edicion-pacientes '>
                                            <input name='id' type='hidden' value='{$person["id"]}'/>
                                            <button type='submit' class='btn btn-warning btn-sm  text-white button-edit'  name='btnEditar'>Editar</button>
                                        </form>
                                    </div>
                                    
                                    </td>
                                </tr>
                            ";
                        }
                    }
                    ?>
                </table>
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