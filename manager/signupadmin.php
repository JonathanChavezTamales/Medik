
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/estilo.css">
    <link href="https://fonts.googleapis.com/css?family=Oxygen|Nunito|Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="../logo_arriba/Logojoy download (231e8f95-0f91-11e8-991f-01aca75f720d)/Social Media Assets/Favicon/favicon_symbol.png">


    <title>Medik - Inicio</title>
  </head>
  <body style="background: #fff;">
    
    <!-- Just an image -->
    <nav class="navbar navbar-light">
      <a style="margin: auto;" class="navbar-brand" href="../index.html">
        <img src="../logo_izquierda/Logojoy download (56ef895c-0f96-11e8-8f63-353313cad141)/svg/color_logo_transparent.svg" width="auto" height="50rem" alt="medik">
      </a>
    </nav>

    <section class="container p-4">
      
      <h1>Registro de administrador</h1>

      <div class="alert alert-danger" id="roller" style="display:none;" role="alert">
             ss
          </div>

      <form method="post">
        <div class="pb-5 pt-2 pr-5 pl-5">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputPhone">Correo electrónico</label>
              <input type="email" class="form-control w-75" name="email" id="inputPhone" placeholder="ejemplo@correo.com" required autofocus>
            </div>
            <div class="form-group col-md-12">
              <label for="inputAddress">Nombre de usuario</label>
              <input type="text" class="form-control" id="inputAddress" name="username" placeholder="Ejemplo: 078D52ADF8" required>
              <small id="Help" class="form-text text-muted">Con este nombre de usuario iniciarás sesión.</small>
            </div>
            <div class="form-group col-md-4">
              <label for="inputPassword">Contraseña</label>
              <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Contraseña" required>
              <small id="Help" class="form-text text-muted">Mínimo 8 caracteres.</small>
            </div>
            <div class="form-group col-md-4">
              <label for="inputPassword2">Confirmar contraseña</label>
              <input type="password" class="form-control" id="inputPassword2" name="password2" placeholder="Contraseña" required>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Recibir actualizaciones por correo
              </label>
            </div>
          </div>
          <button type="submit" name="register" class="btn btn-primary btn-lg">Hecho</button>
        </div>
      </form>

    </section>

    <?php
ob_start();
session_start();
require('../config/index.php');

if(isset($_SESSION['admins'])):
    header('Location: admin.php');
else:
    if(isset($_POST['register'])):
        if(empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password'])):
            echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
                        document.getElementById("roller").innerHTML = "Hay campos blancos.";
                      </script>';
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)):
            echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
                        document.getElementById("roller").innerHTML = "Email invalido.";
                      </script>';
        elseif(strlen($_POST['username']) > 30 || strlen($_POST['username']) < 5):
            echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
                        document.getElementById("roller").innerHTML = "Usuario debe ser mayor a 5 caracteres y menor a 30.";
                      </script>';
        elseif($_POST['password'] != $_POST['password2']):
            echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
            document.getElementById("roller").innerHTML = "Contraseñas no coinciden"; </script>';
        else:
            $email = mysqli_query($connection, "SELECT email FROM admins WHERE email = '".mysqli_real_escape_string($connection, $_POST['email'])."'");
            if($email1 = mysqli_fetch_assoc($email)):
                echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
                        document.getElementById("roller").innerHTML = "Este email ya se ha utilizado.";
                      </script>';
            else:
                $user = mysqli_query($connection, "SELECT username FROM admins WHERE username = '".mysqli_real_escape_string($connection, $_POST['username'])."'");
                if($user1 = mysqli_fetch_assoc($user)):
                    echo '<script type="text/javascript">document.getElementById("roller").style.display = "block";
                        document.getElementById("roller").innerHTML = "Este usuario ya se ha utlilizado.";
                      </script>';
                else:
                    mysqli_query($connection, "INSERT INTO admins(id,email,username,password,date,ip) VALUES ('', '".mysqli_real_escape_string($connection, $_POST['email'])."', '".mysqli_real_escape_string($connection, $_POST['username'])."', '".mysqli_real_escape_string($connection, hash('sha256', $_POST['password']))."', '".date("Y-m-d")."', '".$_SERVER['SERVER_ADDR']."')");
                    header('Location: loginadmin.php');
                endif;
            endif;
        endif;
    endif;
endif;
?>

             

    <section class="footer p-4">
      <footer>
        <div class="container my-3">
          <div class="row">
            <div class="col-sm-2">
              <img src="../logo_izquierda/Logojoy download (56ef895c-0f96-11e8-8f63-353313cad141)/svg/dark_logo_transparent.svg" width="auto" height="40rem" alt="medik">
            </div>
            <div class="col-sm-2">
              <h5>Legal</h5>
              <a href="#!" class="link-footer">Terminos de uso</a><br>
              <a href="#!" class="link-footer">Aviso de privacidad</a><br>
              <a href="#!" class="link-footer">Acta de empresa</a><br>
              <a href="#!" class="link-footer">Constitucion</a><br>
              <a href="#!" class="link-footer">Terminos de uso</a><br>
              <a href="#!" class="link-footer">Aviso de privacidad</a><br>
            </div>
            <div class="col-sm-2">
              <h5>Negocio</h5>
              <a href="#!" class="link-footer">Anuncios</a><br>
              <a href="#!" class="link-footer">Empresarial</a><br>
              <a href="#!" class="link-footer">Terminos de uso</a><br>
              <a href="#!" class="link-footer">Contacto</a><br>
              <a href="#!" class="link-footer">Terminos de uso</a><br>
              <a href="#!" class="link-footer">Aviso de privacidad</a><br>
            </div>
            <div class="col-sm-2">
              <h5>Empresa</h5>
              <a href="#!" class="link-footer">Trabajo</a><br>
              <a href="#!" class="link-footer">Prensa</a><br>
              <a href="#!" class="link-footer">Valores</a><br>
              <a href="#!" class="link-footer">Preguntas</a><br>
            </div>
            <div class="col-sm-2">
              <h5>Operaciones</h5>
              <a href="#!" class="link-footer">Reclamos</a><br>
              <a href="#!" class="link-footer">Sugerencias</a><br>
              <a href="#!" class="link-footer">Contacto al directivo</a><br>
              <a href="#!" class="link-footer">Aviso de privacidad</a><br>
              <a href="#!" class="link-footer">Terminos de uso</a><br>
              <a href="#!" class="link-footer">Aviso de privacidad</a><br>
            </div>
            <div class="col-sm-2">
              <ul class="list-inline">

                <li class="list-inline-item">
                  <a href="https://youtube.com" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                </li>

                <li class="list-inline-item">
                  <a href="https://facebook.com/weMedik" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>

                <li class="list-inline-item">
                  <a href="https://twitter.com" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>

                <li class="list-inline-item">
                  <a href="https://medium.com" target="_blank"><i class="fa fa-medium" aria-hidden="true"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="creditos text-center mt-4">
          <p class="mt-5 mb-0 text-muted">&copy; 2017-2018 Medik SAPI de CV</p>
        </div>
      </footer>
    </section>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>