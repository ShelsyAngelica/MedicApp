<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/registroSesion.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registro</title>
</head>
<body>
    <div class="registre">  
      <div class="form-container-registre">
        <img src="./assets/logo.png" alt="logo" class="logo-registre"/>
        <p class='title-registre'>Registrate</p>
          <form action="" method="post" class="form-registre">

            <label class="label">Nombre</label>
            <input type="text" name="name" placeholder="Ingrese su nombre" class="input input-name-registre"/>

            <label class="label">Apellido</label>
            <input type="text" name="surname" placeholder="Ingrese su apellido" class="input input-surname-registre"/>
  
            <label class="label">Perfil</label>
            <select name="profile" id="" class="input select-profile">
              <option >Seleccione</option>
              <option >Medico</option>
              <option >Paciente</option>
            </select>

            <label class="label">Correo electrónico</label>
            <input type="text" name="email" placeholder="Ingrese su correo electrónico" class="input input-email-registre"/>

            <label class="label">Contraseña</label>
            <input type="password" name="password" placeholder="Ingrese su contraseña" class="input input-password-registre"/>

            <button type="submit" name="btn-crear" class="primary-button registre-button">Crear cuenta</button>

            <a href="../ejercicioPHP/login.php">Ya tienes cuenta? Inicia sesion</a>

          <?php
            include_once './modelo/conexionfiltrar.php';
            $objeto = new Conexion();
            $conexion = $objeto->conectar();

            
            if(isset($_POST['btn-crear'])){

              $datos = [
                'name'     => $_POST['name'],
                'surname'  => $_POST['surname'],
                'profile'  => $_POST['profile'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
                
              ];
              
              if($datos['name'] == ""|| $datos['surname'] == ""|| $datos['profile'] == ""|| $datos['email'] == ""|| $datos['password'] == ""){
                echo "<script> Swal.fire('Todos los campos son obligatorios') </script> ";
              } 
              else {
                $sql = "INSERT INTO users (name, surname, profile, email, password) values (:name,:surname,:profile,:email,:password)";
                $resultado = $conexion->prepare($sql);
                $resultado->execute($datos);

                echo "<script> Swal.fire('Datos registrados exitosamente') </script> ";
              }

            }
          ?>


          </form>

      </div> 
    </div>

    <?php
        include("./vista/Footer.php");
    ?>
</body>
</html>