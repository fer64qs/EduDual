<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Recuperar contraseña EduDual</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
    }
    .container {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }
    input[type="email"] {
      width: 100%;
      padding: 0.75rem;
      margin: 1rem 0;
      font-size: 1rem;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #007bff;
      border: none;
      padding: 0.75rem 1.5rem;
      color: white;
      font-size: 1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.2s ease-in-out;
    }
    button:hover {
      background-color: #0056b3;
    }
    h2 {
      margin-bottom: 1rem;
      color: #333;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Recuperar contraseña</h2>
  <form action="procesar_recuperacion.php" method="POST">
    <input type="email" name="correo" placeholder="Introduce tu correo" required />
    <button type="submit">Enviar contraseña temporal</button>
  </form>
</div>

</body>
</html>