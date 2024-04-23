<?php 
    include_once './modelo/conexionfiltrar.php';
    $objeto = new Conexion();
    $conexion = $objeto->conectar();

    session_start();    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.all.min.js
    "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.18/dist/sweetalert2.min.css
    " rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Inicio sesion</title>
</head>
<body>


<?php 
    if(isset($_POST['btn-login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        

        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $resultado = $conexion->prepare($sql);
        $resultado -> execute();

        
        if($resultado->rowCount() > 0){
            $row = $resultado->fetch(PDO::FETCH_ASSOC);

            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['surname'] = $row['surname'];
            $_SESSION['profile'] = $row['profile'];

            $userType = $row['profile'];

            if($userType == 'Medico'){
                header("Location: vista/index.php");
                
            } 
            elseif ($userType == 'Paciente'){
                header("Location: vista/ConsultaPaciente.php");
                
            }
        } 
        if(empty($email) || empty($password)){
            echo 
            "<script>
            Swal.fire({
              icon: 'warning',
              title: 'Oops...!',
              text: 'Todos los campos son obligatorios.',  
              })
            </script>";
        }
        else{
            echo 
            "<script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...!',
              text: 'Datos incorrectos.',  
              })
            </script>";
        }

    }
    
?>



    <div class="login"> 
        <div class="form-container">
            <img src="./assets/logo.png" alt="logo" class="logo"/>
            <p class='title-login'>Inicia sesion</p>
            <form action="" class="form" method="post">

                <label htmlFor="email" class="label">Correo electrónico</label>
                <input type="text" name="email" placeholder="Ingrese su correo" class="input input-email"/>

                <label htmlFor="password" class="label">Contraseña</label>
                <input type="password" name="password" placeholder="Ingrese su contraseña" class="input input-password"/>

                <button  name="btn-login" type="submit" class="primary-button login-button">Iniciar sesión</button>

                <a href="/">Olvide mi contraseña</a>
            </form>

        <button class="secondary-button signup-button" > <a class="a" href="../ejercicioPHP/registroSesion.php">Crear cuenta</a></button>
        </div>
    </div>
</body>
</html>