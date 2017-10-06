<?php

session_start();
if (isset($_SESSION["user"])) {
  header("location:SIGA/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Sistema Integrado de Gestion y Autocontrol</title>
<link href="favicon.ico" rel="icon" type="image/x-icon"/>

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<link rel="stylesheet"  href="Fonts/style.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id="header">
    <center>
  <img src="logo.png">
  </div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2 "></div>
		<div class="container multi-form-wrapper">
		 <div class="form-container row">
			<div id="main-login" class="module-form  col-xs-12 col-sm-5 col-md-5 col-lg-5">
        <div class="form-header">
        	<div class="form-top-left">
            <center>
		          <h2>Iniciar Sesión</h2>
		          <p>Sistema de Gestion Ambiental </p>
		      </div>
		      <div class="form-top-right">
<img src="2.png"/>
<center>
            </div>
 <br style="clear:both"/>
          </div>
        <div class="form-body">
			<form role="form">
            <div class="form-group usn">
              <label for="USN"> <span class="icon-user-check"> </span> Usuario</label>
        	  <input type="textbox" class="form-control form-element" id="user" name="user" placeholder="Usuario">
            </div>
            <div class="form-group password">
              <label for="pass"><span class="icon-eye-minus"></span> Contraseña</label>
			    <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña">
            </div>
      <div class="form-group">
        <input type="button" name="login" id="login" value="Ingresar" class="btn btn-warning btn-success btn-block submit-btn login-btn">
      </div>
      <span id="result"></span>
      </form>

        </div>

        <div class="modal-footer">
          <div class="pull-left message" id="login-message"></div>
           <p>Olvidaste la <a id="forgot-password" href="#"> Contraseña?</a></p><br>
        </div>
      </div>

		</div>
	</div>
	</div>
  <div class="modal fade" id="forgot-password-modal" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4> Recuperar Contraseña</h4>
        </div>
        <div class="modal-body">
          <form role="form">
            <div class="form-group">
              <label for="usuario"><span class="glyphicon glyphicon-user"></span> Usuario</label>
              <input type="text" class="form-control" id="usrname" placeholder="Ingrese el correo">
            </div>

            <div class="form-group">
              <label for="contraseña"><span class="glyphicon glyphicon-eye-open"></span>Nueva Contraseña</label>
              <input type="password" class="form-control password-validation" id="new-password" placeholder="Nueva contraseña">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span>Confirmar contraseña</label>
              <input type="password" class="form-control confirm-password-validation" id="confirm-new-password" placeholder="Confirmar contraseña">
            </div>
              <button type="button" id="send-email-confirmation-button" class="btn btn-warning btn-block"> <span class="glyphicon glyphicon-envelope"></span> &nbsp;Enviar correo de verificacion</button>
          </form>
        </div>
        <div class="modal-footer">
          <p id="forgot-password-message"></p>
        </div>
      </div>

    </div>
  </div>



</body>
</html>

<script type="text/javascript">



  $(document).ready(function() {
    $('#login').click(function(){
      var user = $('#user').val();
      var pass = $('#pass').val();
      if($.trim(user).length > 0 && $.trim(pass).length > 0){
        $.ajax({
          url:"logueame.php",
          method:"POST",
          data:{user:user, pass:pass},
          cache:"false",
          beforeSend:function() {
            $('#login').val("Conectando...");
          },
          success:function(data) {
            $('#login').val("Ingresar");
            if (data=="1") {
              $(location).attr('href','SIGA/index.php');
            } else {
              $("#result").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Error</strong> los datos son incorrectos.</div>");
            }
          }
        });
      };
    });
  });

  $("#forgot-password").click(function(){
      $("#forgot-password-modal").modal();
  });

  $('#send-email-confirmation-button').on('click',function(){
  	invalid_fields_on_page =  0;
  	$('#new-password').trigger('blur');
  	$('#confirm-new-password').trigger('blur');

  	var email = $('#usrname').val();
  	var new_password = $('#new-password').val();
  	var confirm_new_password = $('#confirm-new-password').val();
  	if(invalid_fields_on_page == 0){
  	   $.post("forgot-password.php",{new_password:new_password,email:email,confirm_new_password:confirm_new_password},response);
  	 function response(res){
  	   	console.log(res);
  	   	var obj = JSON.parse(res);
  	   	if(obj.success == true){
  	   		$('#forgot-password-message').css('color','green');
  	   		$('#forgot-password-message').text(obj.message);
  	   	}else{
  	   		$('#forgot-password-message').css('color','red');
  	   		$('#forgot-password-message').text(obj.message);
  	   	}
  	   }
  	}

  });

</script>
