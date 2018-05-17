<?php
ob_start();
session_start();
require('../config/index.php');

if(isset($_SESSION['admins'])):
    header('Location: admins.php');
else:
    if(isset($_POST['login'])):
        if(empty($_POST['username']) || empty($_POST['password'])):
            echo 'Hay datos en blanco';
        elseif(strlen($_POST['username']) > 30):
            echo 'El usuario no puede tener mas de 30 caracteres';
        elseif($_POST['password'] != $_POST['password2']):
            echo 'Contraseñas no coinciden';
        else:
            $login = mysqli_query($connection, "SELECT username,password FROM admins WHERE username = '".mysqli_real_escape_string($connection, $_POST['username'])."' AND password = '".mysqli_real_escape_string($connection, hash('sha256', $_POST['password']))."'");
            if($login1 = mysqli_fetch_assoc($login)):
                $_SESSION['admins'] = $_POST['username'];
                header('Location: admin.php');
                echo 'Datos correctos';
            else:
                echo 'Datos incorrectos';
            endif;
        endif;
    endif;
endif;
?>


<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../logo_arriba/Logojoy download (231e8f95-0f91-11e8-991f-01aca75f720d)/Social Media Assets/Favicon/favicon_symbol.png">

    <title>Login Administración</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../estilos/singin.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/estilo.css">
  </head>

  <body class="text-center" style="background-color: #343A40; color: white;">
    <form class="form-signin" action="" method="post">
      <img class="mb-4 img-fluid" src="../logo_izquierda/Logojoy download (56ef895c-0f96-11e8-8f63-353313cad141)/svg/white_logo_transparent.svg" alt="" width="" height="">
      <h1 class="h3 mb-3 font-weight-normal">Sesión administrativa</h1>
      <label for="inputID" class="sr-only">Nombre de usuario</label>
      <input type="text" name="username" id="inputEmail" class="form-control"  placeholder="Nombre de usuario" required autofocus>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Contraseña" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Recordar mi contraseña
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Iniciar sesión</button>
      <div class="text-center mt-3"><a style="color: #fff;" href="#">Olvidé mi contraseña</a></div>
      <div class="text-center mt-3"><a style="color: #fff;" href="../index.html">Ir al inicio</a></div>
      <p class="mt-5 mb-3 text-light">&copy; 2017-2018 Medik SAPI de CV</p>
    </form>
  </body>
</html>
