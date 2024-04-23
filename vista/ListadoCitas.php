<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado citas</title>
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
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js
    "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css
    " rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
        include("./Nav.php");
    ?>
    
    <div class="registro-pacientes">
        <div class="form-container-registro">
            <p class='title-registro-pacientes'>Listado citas</p>

            <!-- modulo listado -->
            <?php
                include '../modelo/conexionfiltrar.php';
                $objeto = new Conexion();
                $conexion = $objeto->conectar();

                if (isset($_SESSION["updated"])) {
                    echo "<script> Swal.fire('{$_SESSION["updated"]}') </script> ";
                    $_SESSION["updated"] = null;
                }
                

                if(isset($_POST['btnEliminar'])){
                    $id = $_POST['id'];

                    if($id == ""){
                        echo "<script> Swal.fire('ocurrio un problema intente de nuevo mas tarde') </script> ";
                    } else{
                        $sql = "DELETE FROM appointment WHERE id=?";
                        $stmt= $conexion->prepare($sql);
                        $stmt->execute([ $id]);
                        echo "<script> Swal.fire('cita eliminada') </script> ";
                    }


                }

                $sql = "SELECT 
                            a.id,
                            p.name,
                            p.surname,
                            a.date,
                            a.diagnostic,
                            a.cost
                FROM appointment a 
                INNER JOIN people p ON a.person_id = p.id";

                $resultado = $conexion->prepare($sql);
                $resultado->execute();
                $appointment = $resultado->fetchAll();
    ?>
    

            <div class="table-responsive">
                <table id="example" class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha cita</th>
                            <th>Diagnostico</th>
                            <th>Costo</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    
                    <?php
                    if (isset($appointment)) {
                        foreach ($appointment as $key => $date) {
                            echo "
                                <tr>
                                    <td>{$date["name"]}</td>
                                    <td>{$date["surname"]}</td>
                                    <td>{$date["date"]}</td>
                                    <td>{$date["diagnostic"]}</td>
                                    <td>{$date["cost"]}</td>
                                    <td>

                                    
                                    <div class='d-flex'>
                                        <form action='' method='post' class='form-registro-pacientes'>
                                            <input name='id' type='hidden' value='{$date["id"]}'/>
                                            <button type='submit' class='btn btn-danger btn-sm text-white'  name='btnEliminar'>Borrar</button>
                                        </form>

                                        <form action='EditarCita.php' method='post' class='form-edicion-pacientes '>
                                            <input name='id' type='hidden' value='{$date["id"]}'/>
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
</body>
</html>