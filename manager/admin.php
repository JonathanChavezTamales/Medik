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
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="index.html">
        <img src="../logo_izquierda/Logojoy download (56ef895c-0f96-11e8-8f63-353313cad141)/svg/white_logo_transparent.svg" width="auto" height="50rem" alt="medik">
      </a>

      <div class="btn-group">
            <a href="../logout.php"><button type="button" class="btn btn-outline-danger mr-sm-2" data-toggle="modal" data-target="#LogIn">Salir</button></a>
            <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Acciones
            </button>
            <div class="dropdown-menu dropdown-menu-right" id="dropdown">
              <button class="dropdown-item" type="button">Action</button>
              <button class="dropdown-item" type="button">Another action</button>
              <div class="dropdown-divider"></div>
              <button class="dropdown-item" type="button">Salir</button>
            </div>
          </div>
    </nav>

    <?php
      ob_start();
      session_start();
      require('config/index.php');

      if(isset($_SESSION['admins'])):
          echo '<section class="container p-4"> <div class="h1">Bandeja de entrada de ';
            echo $_SESSION['admins'];
            echo '</div> <hr><section>';
          if(@$_GET['action'] == 'delete-receiver' AND isset($_GET['id'])):
              $mensaje = mysqli_query($connection, "SELECT id,title,message FROM messages WHERE id = '".mysqli_real_escape_string($connection, $_GET['id'])."' AND receiver = '".$_SESSION['admins']."'");
              if($mensaje1 = mysqli_fetch_assoc($mensaje)):
                  mysqli_query($connection, "DELETE FROM messages WHERE id = '".mysqli_real_escape_string($connection, $_GET['id'])."' AND receiver = '".$_SESSION['admins']."'");
                  header('Location: ?action=recibido');
              else:
                  echo 'No puedes eliminar este mensaje<br>';
              endif;
          elseif(@$_GET['action'] == 'recibido' AND isset($_GET['id'])):
              $mensaje = mysqli_query($connection, "SELECT id,title,message FROM messages WHERE id = '".mysqli_real_escape_string($connection, $_GET['id'])."' AND receiver = '".$_SESSION['admins']."'");
              if($mensaje1 = mysqli_fetch_assoc($mensaje)):
                  mysqli_query($connection, "UPDATE messages SET isRead = 'yes' WHERE id = '".mysqli_real_escape_string($connection, $_GET['id'])."' AND receiver = '".$_SESSION['admins']."'");
                  echo '<b>Titulo:</b> '.$mensaje1['title'].'<br><b>Mensaje:</b> '.$mensaje1['message'].'<br> <a href="?action=delete-receiver&id='.$mensaje1['id'].'">Eliminar mensaje</a><br>';
              else:
                  echo 'No puedes leer este mensaje<br>';
              endif;
          
          elseif(@$_GET['action'] == 'delete-sender' AND isset($_GET['id'])):
              $mensaje = mysqli_query($connection, "SELECT id,title,message FROM messages WHERE id = '".mysqli_real_escape_string($connection, $_GET['id'])."' AND sender = '".$_SESSION['admins']."'");
              if($mensaje1 = mysqli_fetch_assoc($mensaje)):
                  mysqli_query($connection, "DELETE FROM messages WHERE id = '".mysqli_real_escape_string($connection, $_GET['id'])."' AND sender = '".$_SESSION['admins']."'");
                  header('Location: ?action=enviado');
              else:
                  echo 'No puedes eliminar este mensaje<br>';
              endif;
          elseif(@$_GET['action'] == 'enviado' AND isset($_GET['id'])):
              $mensaje = mysqli_query($connection, "SELECT id,title,message FROM messages WHERE id = '".mysqli_real_escape_string($connection, $_GET['id'])."' AND sender = '".$_SESSION['admins']."'");
              if($mensaje1 = mysqli_fetch_assoc($mensaje)):
                  echo '<b>Titulo:</b> '.$mensaje1['title'].'<br><b>Mensaje:</b> '.$mensaje1['message'].' <a href="?action=delete-sender&id='.$mensaje1['id'].'">Eliminar mensaje</a><br>';
              else:
                  echo 'No puedes leer este mensaje<br>';
              endif;
          elseif(@$_GET['action'] == 'enviado'):
              echo '<b>Mensajes Enviados:</b><br>';
              $sender = mysqli_query($connection, "SELECT title FROM messages WHERE sender = '".$_SESSION['admins']."'");
              if($sender1 = mysqli_fetch_assoc($sender)):
                  $sender1 = mysqli_query($connection, "SELECT id,title FROM messages WHERE sender = '".$_SESSION['admins']."'");
                  while($sender2 = mysqli_fetch_assoc($sender1)):
                      echo '<a href="?action=enviado&id='.$sender2['id'].'">'.$sender2['title'].'</a><br>';
                  endwhile;
              else:
                  echo 'No haz enviado ningun mensaje<br><br>';
              endif;
          elseif(@$_GET['action'] == 'create'):
              if(isset($_POST['enviar'])):
                  if(empty($_POST['patient']) || empty($_POST['title']) || empty($_POST['message'])):
                      echo 'Haz dejado campos en blanco';
                  else:
                      $email = mysqli_fetch_assoc(mysqli_query($connection, "SELECT email FROM users WHERE patient = '".mysqli_real_escape_string($connection, $_POST['patient'])."'"));
                      if($email):
                              mysqli_query($connection, "INSERT INTO messages(id,sender,receiver,title,message,isRead,date,ip) VALUES ('', '".$_SESSION['admins']."', '".mysqli_real_escape_string($connection, $_POST['patient'])."', '".mysqli_real_escape_string($connection, $_POST['title'])."', '".mysqli_real_escape_string($connection, $_POST['message'])."', 'no', '".date("Y-m-d")."', '".$_SERVER['SERVER_ADDR']."')");
                              header('Location: ?action=enviado');
                      else:
                              echo 'El usuario no existe';
                      endif;
                  endif;
              endif;
              echo '<form action="" method="post">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">ID paciente</span>
                          </div>
                          <input type="text" name="patient" class="form-control" aria-label="ID paciente" aria-describedby="inputGroup-sizing-default">
                        </div>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Asunto</span>
                          </div>
                          <input type="text" name="title" class="form-control" aria-label="Asunto" aria-describedby="inputGroup-sizing-default">
                        </div>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Observación</span>
                          </div>
                          <textarea name="message" class="form-control" aria-label="Observaciones" placeholder="Mensaje para el familiar..." required ></textarea>
                        </div>
                        <div class="input-group mb-3">
                          <input name="enviar" class="btn btn-success" type="submit" value="Enviar mensaje">
                        </div>
                    </form>';
          endif;
              echo '<br><a href="?action=create">Nuevo mensaje</a> | <a href="?action=enviado">Mensajes enviados</a><hr>';
      else:
          header('Location: loginadmin.php'); /*A donde manda cuando se abre admin.php sin estar logeado*/
      endif;
      ?>
  
    </section>

    </section>
             
             

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