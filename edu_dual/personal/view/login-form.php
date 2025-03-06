<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edu Dual Connect</title>
<link href="./view/css/form.css" rel="stylesheet" type="text/css" />
<style>
body {
    font-family: Arial;
    color: #333;
    font-size: 0.95em;
    
    /* Imagen de fondo */
    background-image: url("./view/images/background2.jpg");
    
    /* Hacer la imagen de fondo responsiva */
    background-size: cover;            /* Ajusta la imagen para cubrir toda la pantalla */
    background-position: center;       /* Centra la imagen de fondo */
    background-repeat: no-repeat;      /* Evita que la imagen se repita */
    
    /* Opcionalmente, puedes añadir estas propiedades si deseas efectos adicionales */
    background-attachment: fixed;      /* Mantiene la imagen fija al hacer scroll */
}
</style>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
	
</head>
<body>
	<div>
		<form action="login-action.php" method="post" id="frmLogin"
			onSubmit="return validate();">
			<div class="login-form-container">

				<div class="form-head">Iniciar Sesi&oacute;n</div>
                <?php
                if (isset($_SESSION["errorMessage"])) {
                    ?>
                <div class="error-message"><?php  echo $_SESSION["errorMessage"]; ?></div>
                <?php
                    unset($_SESSION["errorMessage"]);
                }
                ?>
                <div class="field-column">
					<div>
						<label for="username"><b>Usuario:</b></label><span id="user_info"
							class="error-info"></span>
					</div>
					<div>
						<input name="user_name" id="user_name" type="text"
							class="demo-input-box" placeholder="Ingrese el nombre de Usuario">
					</div>
				</div>
				<div class="field-column">
					<div>
						<label for="password"><b>Contrase&ntilde;a:</b></label><span id="password_info"
							class="error-info"></span>
					</div>
					<div>
						<input name="password" id="password" type="password"
							class="demo-input-box" placeholder="Ingrese la Contraseña">
					</div>
				</div>
				<div class=field-column>
					<div>
						<input type="submit" name="login" value="Ingresar" class="btnLogin"></span>
					</div>
				</div>
				<div class="form-nav-row">
					<a href="#" class="form-link">¿Olvidaste la Contrase&ntilde;a?</a>
					
				</div>
				<div class="form-nav-row">
				<br>
				</div>
				<div class="form-nav-row">
    <a class="navbar-brand" href="../index.html" style="font-size: 30px; color: #611232;">
        <i class="fas fa-home"></i>
    </a>
               </div>

				
				<div class="login-row form-nav-row">
					<img src="view/images/dgeti.png" alt="Descripción de la imagen" width="150" height="150">
				</div>

				
				
				<!--ESTO SE COMENTO PORQUE SOLO EL ADMINISTRADOR PODRA CREAR LAS CUENTAS DE USUARIO -->
				<!--
				<div class="login-row form-nav-row">
					<p>¿No tienes Cuenta?</p>
					<a href="view/add_user.php" class="btn form-link">Registrarse</a>
				</div>
				
				-->
				
				
				<!--
				<div class="login-row form-nav-row">
					<p>May also signup with</p>
					<a href="#"><img src="view/images/icon-facebook.png"
						class="signup-icon" /></a><a href="#"><img
						src="view/images/icon-twitter.png" class="signup-icon" /></a><a
						href="#"><img src="view/images/icon-linkedin.png"
						class="signup-icon" /></a>
				</div>
				
				-->
			</div>
		</form>
	</div>
	<script>
    function validate() {
        var $valid = true;
        document.getElementById("user_info").innerHTML = "";
        document.getElementById("password_info").innerHTML = "";
        
        var userName = document.getElementById("user_name").value;
        var password = document.getElementById("password").value;
        if(userName == "") 
        {
            document.getElementById("user_info").innerHTML = "Dato Requerido";
        	$valid = false;
        }
        if(password == "") 
        {
        	document.getElementById("password_info").innerHTML = "Dato Requerido";
            $valid = false;
        }
        return $valid;
    }
    </script>
</body>
</html>