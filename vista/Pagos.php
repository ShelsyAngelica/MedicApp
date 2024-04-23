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
                            it.description
                        FROM people p
                        INNER JOIN identification_types it ON p.identification_type = it.id WHERE p.identification_number = ?";

                        $resultado = $conexion->prepare($sql);
                        $resultado->execute([$identification_number]);
                        $people = $resultado->fetchAll();

                        if (!count($people)) 
                            echo "<script> Swal.fire('El numero de documento no existe en la base de datos') </script> ";
                    }


                } 
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
                            if (count($people)) {
                                    
                            echo "
                                <form action='' method='post' class='form-registro-pacientes' >

                                    <div class='div-content'>
                                        <label for='identification_number' class='label-reg'>Antecedentes medicos:</label>
                                        <input type='text' name='' placeholder='Ingrese los  antecedentes medicos del paciente' class='input-reg input-address'/>
                                    </div>
                                    <div class='div-content'>
                                        <label for='identification_number' class='label-reg'>Valoración medica:</label>
                                        <textarea name=''  type='text' name='' id='' placeholder='Ingrese la valoración del paciente' class='input-reg input-address'></textarea>

                                    </div>

                                    <div class='div-content'>
                                        <label for='identification_number' class='label-reg'>Sesiones recomendadas:</label>
                                        <input type='number' name='' placeholder='Ingrese las  sesiones recomendadas' class='input-reg input-address'/>
                                    </div>

                                    <div class='div-content'>
                                        <label for='identification_number' class='label-reg'>Medico valorante:</label>
                                        <input type='text' name=''  class='input-reg input-address'/>
                                    </div>
                                    
                                    <div class='div-buttons'>
                                        <button class='primary-button-reg' name='btnGuardar'>Guardar</button>
                                    </div>
                                </form>
                            ";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>