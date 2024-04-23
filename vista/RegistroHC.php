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
        include("./Nav.php");
    ?>

    <div class="registro-pacientes">
        <div class="form-container-registro">
            <p class='title-registro-pacientes'>Registro de Historia Clinica</p>

            <form action="" method="post" class="form-registro-pacientes" >

                <div class='div-content'>
                    <label for="identification_number" class="label-reg">Numero documento:</label>
                    <input type="text" name="identification_number" placeholder="0123456789" class="input-reg input-address"/>
                </div>
                
                <div class='div-buttons'>
                    <button class="primary-button-reg" name="btnConsulta">Buscar</button>
                </div>
            </form>

            <!-- modulo consulta -->
            <?php
                include '../modelo/conexionfiltrar.php';
                $objeto = new Conexion();
                $conexion = $objeto->conectar();

                if(isset($_POST['btnConsulta'])){
                    $identification_number = $_POST['identification_number'];

                    if($identification_number == ""){
                        echo "<script> Swal.fire('Digite un numero de documento') </script> ";
                    } else{

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
                            it.description,
                            
                            ch.id ch_id,
                            ch.emergency_number,
                            ch.diagnostic,   
                            ch.background,
                            ch.referring_physician,
                            ch.medical_evaluation,
                            ch.recommended_sessions,
                            ch.attending_physician,

                            u.name u_name,
                            u.surname u_surname

                        FROM people p
                        INNER JOIN identification_types it ON p.identification_type = it.id
                        LEFT JOIN clinic_historys ch ON ch.person_id = p.id
                        LEFT JOIN users u ON ch.attending_physician = u.id
                        WHERE p.identification_number = ?";

                        $resultado = $conexion->prepare($sql);
                        $resultado->execute([$identification_number]);
                        $people = $resultado->fetchAll();

                        if (!count($people)) 
                            echo "<script> Swal.fire('El numero de documento no existe en la base de datos') </script> ";
                    }


                }

                //Guardar HC
                if(isset($_POST['btnGuardarHC']))
                {
                    $datos = [
                        'person_id'             => $_POST['person_id'],
                        'emergency_number'      => $_POST['emergency_number'],
                        'diagnostic'            => $_POST['diagnostic'],
                        'referring_physician'   => $_POST['referring_physician'],
                        'background'            => $_POST['background'],
                        'medical_evaluation'    => $_POST['medical_evaluation'],
                        'recommended_sessions'  => $_POST['recommended_sessions'],
                        'attending_physician'   => $_POST['attending_physician'],
                    ];

                    if($datos['person_id'] == "" || $datos['emergency_number'] == "" || $datos['diagnostic'] == "" || $datos['referring_physician'] == ""|| $datos['background'] == ""||$datos['medical_evaluation'] == ""|| $datos['recommended_sessions'] == ""|| $datos['attending_physician']== "") {
                        echo "<script> Swal.fire('Todos los campos son obligatorios') </script> ";
                    }
                    else{
                        $sql = "INSERT INTO clinic_historys (person_id, emergency_number, diagnostic, referring_physician, background, medical_evaluation, recommended_sessions,attending_physician) values (:person_id, :emergency_number, :diagnostic,:referring_physician,:background,:medical_evaluation,:recommended_sessions,:attending_physician                              )";

                        $resultado = $conexion->prepare($sql);
                        $resultado->execute($datos);

                        echo "<script> Swal.fire('Datos registrados exitosamente') </script> ";
                    }
                }

                // if(isset($_POST['btnEliminar'])){
                //     $id = $_POST['id'];

                //     if($id == ""){
                //         echo "<script> Swal.fire('ocurrio un problema intente de nuevo mas tarde') </script> ";
                //     } else{
                //         $sql = "DELETE FROM people WHERE id=?";
                //         $stmt= $conexion->prepare($sql);
                //         $stmt->execute([ $id]);
                //         echo "<script> Swal.fire('persona eliminada') </script> ";
                //     }


                // }
            ?>
            <div class="table-responsive">
                <table class="table table-striped mt-3 ">
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
                        <th>Acciones</th>   
                    </tr>
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
                                <td><a href='../vista/EvolucionClinica.php?id={$person["ch_id"]}' class='secondary-button-reg' style='width:100%'>Evolucion</a></td>

                                <td>
                                    <div class='d-flex'>
                                        <form action='' method='post' class='form-registro-pacientes'>
                                            <input name='id' type='hidden' value='{$person["id"]}'/>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            ";
                        }
                    }
                    ?>
                </table>

                <?php
                    if(isset($_POST['btnConsulta'])){
                        if(!$identification_number == ""){
                            foreach ($people as $key => $person)
                            echo "
                                <form action='' method='post' class='form-registro-pacientes' >
                                    <input type='hidden' name='person_id' value='{$person["id"]}' class='input-reg input-address'/>
                                    <div class='div-content'>
                                        <label for='' class='label-reg'>Numero de emergencia:</label>
                                        <input type='text' name='emergency_number' value='{$person["emergency_number"]}' placeholder='Ingrese el numero de emergencia' class='input-reg input-address'/>
                                    </div>
                                    <div class='div-content'>
                                        <label for='' class='label-reg'>Diagnostico:</label>
                                        <input type='text' name='diagnostic'  value='{$person["diagnostic"]}' placeholder='Ingrese el diagostico del paciente' class='input-reg input-address'/>
                                    </div>
                                    <div class='div-content'>
                                        <label for='' class='label-reg'>Medico que lo refiere:</label>
                                        <input type='text' name='referring_physician' value='{$person["referring_physician"]}' placeholder='Ingrese medico que lo refiere' class='input-reg input-address'/>
                                    </div>
                                    <div class='div-content'>
                                        <label for='' class='label-reg'>Antecedentes medicos:</label>
                                        <input type='text' name='background' value='{$person["background"]}' placeholder='Ingrese los  antecedentes medicos del paciente' class='input-reg input-address'/>
                                    </div>
                                    <div class='div-content'>
                                        <label for='' class='label-reg'>Valoración medica:</label>
                                        <textarea type='text' name='medical_evaluation' placeholder='Ingrese la valoración del paciente' class='input-reg input-address'>{$person["medical_evaluation"]}</textarea>

                                    </div>
                                    <div class='div-content'>
                                        <label for='' class='label-reg'>Sesiones recomendadas:</label>
                                        <input type='number' name='recommended_sessions' value='{$person["recommended_sessions"]}' placeholder='Ingrese las  sesiones recomendadas' class='input-reg input-address'/>
                                    </div>

                                    <div class='div-content'>
                                        <label for='' class='label-reg'>Medico valorante:</label>   
                                        <input type='text' name='attending_physician' value='{$person["u_name"]} {$person["u_surname"]}' class='input-reg input-address'/>
                                    </div>
                                    
                                    <div class='div-buttons'>
                                        <button class='primary-button-reg' name='btnGuardarHC'>Guardar</button>
                                    </div>
                                </form>
                            ";
                        }
                    }
                    
                ?>
            </div>
        </div>
    </div>    
</body>
</html>

