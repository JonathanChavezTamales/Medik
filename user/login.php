<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../logo_arriba/Logojoy download (231e8f95-0f91-11e8-991f-01aca75f720d)/Social Media Assets/Favicon/favicon_symbol.png">

    <title>Inicia sesión en Medik</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../estilos/singin.css" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/estilo.css">
  </head>

  <body class="text-center" style="background-color: #fff;">
    <form class="form-signin" action="" method="post">
      <img class="mb-4 img-fluid" src="../logo_izquierda/Logojoy download (56ef895c-0f96-11e8-8f63-353313cad141)/svg/color_logo_transparent.svg" alt="" width="" height="">
      <h1 class="h3 mb-3 font-weight-normal">Inicia sesión</h1>
      <div class="alert alert-danger" id="roller" style="display:none;" role="alert">
        Datos incorrectos.
      </div>
      <label for="inputPhone" class="sr-only">Teléfono</label>
      <input type="tel" name="phone" id="inputPhone" class="form-control" placeholder="Número de celular" required autofocus>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Recordar mi contraseña
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Iniciar sesión</button>
      <div class="text-center mt-3"><a href="#">Olvidé mi contraseña</a></div>
      <div class="text-center mt-3"><a href="../user/signup.php">¿No tienes cuenta? Regístrate</a></div>
      <div class="text-center mt-3"><a href="../index.html">Ir al inicio</a></div>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018 Medik SAPI de CV</p>
    </form>
  </body>
</html>

<?php
ob_start();
session_start();
require('../config/index.php');

if(isset($_SESSION['users'])):
    header('Location: user.php');
else:
    if(isset($_POST['login'])):
        if(empty($_POST['phone']) || empty($_POST['password'])):
            echo 'Hay datos en blanco';
        elseif(strlen($_POST['phone']) > 30):
            echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
                        document.getElementById("roller").innerHTML = "El teléfono no debe ser mayor a 15 dígitos.";
                      </script>';
        else:
            $login = mysqli_query($connection, "SELECT phone,password FROM users WHERE phone = '".mysqli_real_escape_string($connection, $_POST['phone'])."' AND password = '".mysqli_real_escape_string($connection, hash('sha256', $_POST['password']))."'");
            if($login1 = mysqli_fetch_assoc($login)):
                $_SESSION['users'] = $_POST['phone'];
                header('Location: user.php');
            else:
                echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
                      </script>';
            endif;
        endif;
    endif;
endif;
?>

