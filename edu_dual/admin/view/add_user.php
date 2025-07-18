<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!--  ESTA VERSION DE ALERTA ES SweetAlert2 (Swal2) SE DESCARGO DIRECTAMENTE PARA QUE NO GENERE ERRORES-->
	<script src="js/sweet_alert.js"></script>
    <style>
        .container-form {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 50px;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 10px;
            background-color: #f7f7f7;
        }
        .preview-img {
            max-width: 100px;
            max-height: 100px;
            margin-top: 10px;
        }
        input.text-uppercase {
            text-transform: uppercase;
        }
    </style>
	<!--ESTAS SON LAS LLAMADAS A LAS LIBRERIAS DE JS -->
<link rel="stylesheet" href="../alerts/style.css" />
<script src="../alerts/cute-alert.js"></script>
    
</head>

<?php 
 if (isset($_GET['idalumno'])) {
    $idAlumno = $_GET['idalumno'];
    $nombre = $_GET['nombre'];
    $apellidoP = $_GET['apellidop'];
    $apellidoM = $_GET['apellidom'];
    $correo = $_GET['correo'];
    $celular = $_GET['celular'];
} else {
    echo "No se recibieron los datos.";
}
?>
<body>
    <div class="container container-form">
        <h5 class="text-center">Registrar Cuenta de Usuario para Alumno</h5><br>
        <form id="userForm" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="apellidos"><b>Apellidos:</b></b></label>
					<input type="text" class="form-control text-uppercase" id="idperfil" name="idperfil" placeholder="idperfil" value="5" hidden> <!-- 5 es idperfil de alumno-->
                    <input type="text" class="form-control text-uppercase" id="apellidos" name="apellidos" placeholder="APELLIDOS" value="<?php echo $apellidoP . " ".$apellidoM; ?>" required >
                </div>
                <div class="form-group col-md-6">
                    <label for="nombres"><b>Nombres:</b></label>
                    <input type="text" class="form-control text-uppercase" id="nombres" name="nombres" placeholder="NOMBRE" value="<?php echo $nombre;?>" required >
                </div>
            </div>
			
			<div class="form-row">
    <div class="form-group col-md-6">
        
		
		<label for="email"><b>Correo Electrónico:</b></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $correo;?>" required >
    </div>
    <div class="form-group col-md-6">
        <label for="clave_sie"><b>Usuario:</b></label>
        <div class="input-group">
            <input type="text" class="form-control text-lowercase" id="clave_sie" name="clave_sie" placeholder="Usuario (seleccione la casilla si desea usar su Email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <input type="checkbox" id="copy_email" title="Usar mi Email como Usuario">
                </div>
            </div>
        </div>
    </div>
</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="telefono"><b>Tel&eacute;fono:</b></label>
                    <input type="text" class="form-control text-uppercase" id="telefono" name="telefono" placeholder="TELEFONO" value="<?php echo $celular;?>" required >
                </div>
                <div class="form-group col-md-6">
                    <label for="photo"><b>Foto de Perfil:</b></label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                    <img id="preview" class="preview-img" src="#" alt="Vista previa de imagen" style="display: none;">
				</div>
            </div>
			
			<div class="form-row">
    <div class="form-group col-md-6">
        <label for="contrasenia"><b>Contraseña:</b></label>
        <div class="input-group">
            <input type="password" class="form-control" id="contrasenia" name="contrasenia" placeholder="PASSWORD" required>
            <div class="input-group-append">
                <button class="btn btn-secondary" type="button" id="generate_password">Generar</button>
            </div>
        </div>
    </div>
    <div class="form-group col-md-6">
        <label for="confirm_contrasenia"><b>Confirmar Contraseña:</b></label>
        <input type="password" class="form-control" id="confirm_contrasenia" name="confirm_contrasenia" placeholder="PASSWORD" required>
    </div>
</div>
<div class="form-check">
    <input type="checkbox" class="form-check-input" id="toggle_visibility">
    <label class="form-check-label" for="toggle_visibility">Mostrar contraseñas</label><br>
</div>
			 <div class="form-row">
			 <div class="form-group col-md-12">
        <label for="perfil"><b>Perfil de Usuario:</b></label>
        <select id="perfil" name="perfil" class="form-control" required>
            <option value="SELECCIONE UN REGISTRO">SELECCIONE UN REGISTRO</option>
        </select>
    </div>
	</div>
	
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
        </form>
    </div>

<script>
    function validateFile() {
        // Obtiene el input de tipo file
        const fileInput = document.getElementById("photo");

        // Verifica si se ha seleccionado un archivo
        if (!fileInput.files || fileInput.files.length === 0) {
            alert("Por favor, seleccione un archivo.");
            return false;
        }

        // Si pasa la validación, puede continuar
        alert("Archivo seleccionado correctamente.");
        return true;
    }
</script>

  <script>
        $(document).ready(function() {
        $('#userForm').on('submit', function(e) {
            e.preventDefault(); // Prevenir el comportamiento predeterminado del formulario
			
			//validamos que se seleccione un imagen
			const fileInput = document.getElementById("photo");

        // Verifica si se ha seleccionado un archivo
        if (!fileInput.files || fileInput.files.length === 0) {
           // alert("Por favor, seleccione un archivo.");
			 Swal.fire('¡Advertencia!', 'Por favor, seleccione un archivo.', 'warning');
            return false;
        }
			//fin de validacion

            var formData = new FormData(this);

            $.ajax({
                url: '../controller/procesar_registro.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
               success: function(response) {
    console.log("Respuesta recibida:", response); // Ver la respuesta en la consola

    try {
        var jsonResponse = response;

        if (jsonResponse.status === "success") {

			Swal.fire({
    title: '¡Éxito!',
    text: 'El Usuario se ha agregado correctamente. Acontinuación se enviarán los datos de acceso a la cuenta de correo.',
    icon: 'success',
    confirmButtonText: 'Aceptar'
}).then((result) => {
    if (result.isConfirmed) { // Si se hace clic en "Aceptar"
        // Limpiar el input file y la vista previa
        const fileInput = document.getElementById('photo');
        const preview = document.getElementById('preview');

        fileInput.value = null;
        preview.src = '#';
        preview.style.display = 'none';
		
		
		
/*AQUI ANTES DE REDIRECCIONAR SE DEBE ENVIAR EL CORREO ELECTRONICO*/
var apellidos = document.getElementById("apellidos").value;
var nombre = document.getElementById("nombres").value;
var email = document.getElementById("email").value;
var cuenta = document.getElementById("clave_sie").value; // es la cuenta creada
var contrasenia = document.getElementById("contrasenia").value;

// Crear la URL con los parámetros
var url = "send_mailregistro.php?apellidos=" + encodeURIComponent(apellidos) +
          "&nombre=" + encodeURIComponent(nombre) + " " + encodeURIComponent(apellidos) +
          "&email=" + encodeURIComponent(email) +
          "&cuenta=" + encodeURIComponent(cuenta) +
          "&pass=" + encodeURIComponent(contrasenia);
		  //alert(url);
		  var formDataAccount = {
                    apellidos: apellidos,
                    nombre: nombre + ' ' + apellidos,
                    email: email,
                    cuenta: cuenta,
                    pass: contrasenia
                };

		$.ajax({
    url: 'send_mailregistro.php',
    type: 'POST',
    data: formDataAccount,
    success: function(response) {
        console.log("Respuesta recibida:", response);
        var res = JSON.parse(response);

        // Mostrar alerta con SweetAlert2
        Swal.fire({
            icon: res.success ? 'success' : 'error',
            title: res.success ? '¡Éxito!' : '¡Error!',
            text: res.message,
            confirmButtonText: 'Aceptar'
        }).then(() => {
            if (res.success) {
                // Resetear el formulario si es exitoso
                $('#userForm')[0].reset();

                // Redireccionar al archivo
                window.location.href = "formcat_alumnos.php";
            }
        });
    },
    error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "Error al enviar la solicitud: " + textStatus + ": " + errorThrown,
            confirmButtonText: 'Aceptar'
        });
    }
});
//SE AGREGO ESTO NUEVO	
    }
});
			
        } else if (jsonResponse.status === "error") {
            //alert(jsonResponse.message);
			
			cuteAlert({
      type: "warning",
      title: "Mensaje de Advertencia",
      message: jsonResponse.message,
      buttonText: "Cerrar"
  })
			
			
        }
    } catch (e) {
        console.log("Error en el parseo JSON:", e);
        alert("Ocurrió un error inesperado.");
    }
},
                error: function(xhr, status, error) {
                    // Manejo de errores de la solicitud AJAX
                   console.log("Error de solicitud:", xhr.responseText);  // Mostrar la respuesta completa del servidor
    console.log("Status:", status);
    console.log("Error:", error);
                    alert("Ocurrió un error al intentar registrar al usuario.");
                }
            });
        });
    });

        // Validar que las contraseñas coincidan
        function validateForm() {
            var password = document.getElementById("contrasenia").value;
            var confirmPassword = document.getElementById("confirm_contrasenia").value;
            var email = document.getElementById("email").value;
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Patrón para validar correo electrónico

            if (!emailPattern.test(email)) {
                alert("Por favor, ingrese un correo electrónico válido.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Las contraseñas no coinciden.");
                return false;
            }

            return true;
        }

        // Vista previa de la imagen seleccionada
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById("preview");
                preview.src = reader.result;
                preview.style.display = "block";
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

	
	<script>

</script>
<script>
$(document).ready(function(){
    // Hacer la solicitud AJAX para obtener los perfiles
    $.ajax({
        url: '../controller/obtener_perfiles.php',  // Archivo PHP que obtiene los perfiles
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var select = $('#perfil');
            select.empty();  // Limpiar el select
            
            // Opción por defecto
            select.append('<option value="">SELECCIONE UN REGISTRO</option>');
            
            // Recorrer los perfiles y agregarlos al select
            $.each(data, function(index, perfil) {
                select.append('<option value="' + perfil.idperfil + '">' + perfil.nombre_perfil + '</option>');
            });

            // Intentar seleccionar automáticamente la opción con valor "ALUMNO"
            setTimeout(function() {
                select.find('option').each(function() {
                    if ($(this).text().trim() === 'ALUMNO') { // Verifica el texto de la opción
                        $(this).prop('selected', true);
                        return false; // Salir del bucle
                    }
                });
            }, 100); // Asegura que las opciones están completamente cargadas
        },
        error: function() {
            alert('Hubo un error al cargar los perfiles.');
        }
    });
});
</script>

<script>
    document.getElementById('copy_email').addEventListener('change', function () {
        const emailInput = document.getElementById('email');
        const claveSIEInput = document.getElementById('clave_sie');
        
        // Solo ejecutar la alerta si el checkbox está marcado
        if (this.checked) {
            Swal.fire({
                title: '¿Desea usar el correo como cuenta de Usuario?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, copiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Verificar si el campo de correo está vacío
                    if (emailInput.value.trim() === "") {
                        Swal.fire('¡Advertencia!', 'El campo Correo está vacío', 'warning');
                        this.checked = false; // Desmarcar el checkbox
                        return; // Salir de la función
                    }
                    
                    // Copiar el valor del correo al campo clave_sie
                    claveSIEInput.value = emailInput.value;
                    Swal.fire('¡Copiado!', 'El correo se ha copiado.', 'success');
                } else {
                    this.checked = false; // Desmarcar el checkbox si se cancela
                }
            });
        } else { claveSIEInput.value = "";}
    });
</script>

<script>
    document.getElementById('generate_password').addEventListener('click', function () {
        const passwordLength = 8; // Longitud mínima de la contraseña
        const upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowerCase = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        const specialChars = '!@#$%&*()+[]{}<>?';

        // Función para obtener un carácter aleatorio de una cadena
        function getRandomChar(charSet) {
            return charSet[Math.floor(Math.random() * charSet.length)];
        }

        // Generar una contraseña con al menos un carácter de cada conjunto
        let password = [
            getRandomChar(upperCase),
            getRandomChar(lowerCase),
            getRandomChar(numbers),
            getRandomChar(specialChars)
        ];

        // Completar la longitud restante con una mezcla de todos los conjuntos
        const allChars = upperCase + lowerCase + numbers + specialChars;
        for (let i = password.length; i < passwordLength; i++) {
            password.push(getRandomChar(allChars));
        }

        // Mezclar la contraseña para que los caracteres no estén en orden predecible
        password = password.sort(() => Math.random() - 0.5).join('');

        // Establecer la contraseña generada en ambos campos
        document.getElementById('contrasenia').value = password;
        document.getElementById('confirm_contrasenia').value = password;

        // Mostrar la contraseña generada al usuario (opcional)
       // alert('Se ha generado la siguiente contraseña: ' + password);
    });

    document.getElementById('toggle_visibility').addEventListener('change', function () {
        const passwordFields = ['contrasenia', 'confirm_contrasenia'];
        passwordFields.forEach(id => {
            const input = document.getElementById(id);
            input.type = this.checked ? 'text' : 'password';
        });
    });
</script>
</body>
</html>
