<?php include('cat_noticias/noticias.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Educación dual: la combinación de estudios académicos con experiencia laboral">
    <title>Educación Dual</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background-color: #d6dbdf;
        }
        .navbar img {
            max-width: 150px;
            height: auto;
        }

        .carousel-item {
            height: 400px;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .section-title {
            text-align: center;
            margin-top: 50px;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e2a38;
        }

        .info-card, .news-card, .news-detail {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .info-card h3, .news-card h4 {
            color: #611232; /* ff6600*/
        }

        .info-card p, .news-card p {
            color: #777;
            font-size: 1.1rem;
        }

        .news-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cta-section {
            background-color: #A57F2C;
            color: white;
            padding: 40px 20px;
            text-align: center;
            border-radius: 10px;
            margin-top: 50px;
        }

        .cta-btn {
            padding: 12px 25px;
            background-color: #1e2a38;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            font-size: 1.1rem;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #1e2a38;
            color: white;
            margin-top: 50px;
        }

        footer a {
            color: white;
            margin: 0 10px;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .carousel-item {
                height: 300px;
            }
            .cta-btn {
                padding: 10px 20px;
                font-size: 1rem;
            }
            .news-card {
                flex-direction: column;
                text-align: center;
            }
        }
		
		.carousel-control-prev, .carousel-control-next {
        width: 40px;
        height: 40px;
        top: 50%; /* Alinea los botones verticalmente al centro */
        transform: translateY(-50%); /* Ajusta la posición para centrar verticalmente */
    }
    .carousel-control-prev {
        left: 10%; /* Ajusta la distancia desde el borde izquierdo */
    }
    .carousel-control-next {
        right: 10%; /* Ajusta la distancia desde el borde derecho */
    }
    .carousel-control-prev-icon, .carousel-control-next-icon {
        filter: invert(1); /* Cambia el ícono a blanco para contraste */
    }
	
	@media (max-width: 768px) {
            .carousel-item {
                height: 300px; /* Reduce la altura en pantallas pequeñas */
            }

            .carousel-item img {
                object-fit: contain; /* Asegura que las imágenes no se recorten */
            }
        }
    </style>
</head>
<body>

    <!-- Barra Superior con Logotipo -->
    <nav class="navbar">
        <img src="img/cbtis_logo.png" alt="Logotipo">
    </nav>
    <br><br>
    
    <!-- Carrusel de imágenes -->
    <div id="carouselExample" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/1.jpg" class="d-block mx-auto" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="img/2.jpg" class="d-block mx-auto" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="img/3.jpg" class="d-block mx-auto" alt="Imagen 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="background-color: #611232; border-radius: 50%; left: 10%;">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="background-color: #611232; border-radius: 50%; right: 10%;">
            <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
	
	<style>
    .carousel-item img {
        width: 50%; /* Asegura que la imagen ocupe el ancho completo del contenedor */
        height: auto; /* Ajusta automáticamente la altura según las proporciones */
        object-fit: contain; /* Ajusta la imagen dentro del contenedor sin recortarla */
        object-position: center; /* Centra la imagen dentro del espacio disponible */
    }
</style>

    <!-- Sección Informativa: Introducción -->
    <section>
        <h4 class="section-title">¿Qué es la Educación Dual?</h4>
        <div class="container">
            <div class="info-card">
                <h3>Un Enfoque Integrado</h3>
                <p>La educación dual combina la formación teórica en el aula con la experiencia práctica en empresas. Este modelo permite que los estudiantes adquieran habilidades valiosas que aumentan su empleabilidad al mismo tiempo que reciben una educación académica sólida.</p>
            </div>
        </div>
    </section>
    <!-- Sección de Noticias -->
    <h2 class='section-title'>Noticias Recientes</h2>
    <?php
     $noticias = cargarNoticias();
     $totalNoticias = count($noticias);
    if ($totalNoticias === 0) {
        echo "<p class='text-center text-muted'>No hay noticias disponibles.</p>";
      } else {
        foreach ($noticias as $noticia) {
            $imagen = $noticia['imagen']; // Ruta de la imagen
        echo "<section>";
        
        echo "<div class='container' id='news-container'>";

        echo "<div class='news-card'>";
        echo "<div>";
        echo "<h4>{$noticia['titulo']}</h4>";
        echo "<h5>{$noticia['subtitulo']} </h5>";
        echo "<h5>{$noticia['fecha']}</h5>";
       
        echo "<p>{$noticia['descripcion']}</p>";
        echo "</div>";
        echo "<img src='{$imagen}' alt='Imagen de la noticia' style='width: 150px; height: 150px; border-radius: 50%; object-fit: cover;'>";
        echo "</div>";

        echo "</section>";
    }
}
?>

    <!-- Llamada a la acción -->
    <section class="cta-section">
        <h2>¡Únete al Futuro de la Educación!</h2>
        <p>Descubre más sobre cómo puedes formar parte de este innovador modelo educativo que te prepara para el futuro.</p>
        <a href="#" class="cta-btn">Más Información</a>
    </section>

    <!-- Detalle de Noticias -->
    <div id="noticia1" class="news-detail" style="display:none;">
        <div>
            <h4>Nuevo Programa de Becas</h4>
            <p>Detalles completos sobre el nuevo programa de becas para estudiantes en el modelo de educación dual.</p>
            <p><strong>Fecha de publicación:</strong> 1 de noviembre de 2024</p>
            <p>Este programa proporciona recursos financieros a los estudiantes que se inscriban en instituciones educativas que ofrezcan programas de educación dual...</p>
        </div>
        <button class="btn btn-secondary" onclick="cerrarNoticia()">Cerrar</button>
    </div>

    <div id="noticia2" class="news-detail" style="display:none;">
        <div>
            <h4>Empresas que Adoptan la Educación Dual</h4>
            <p>Detalles completos sobre cómo las empresas están adoptando la educación dual como parte de su estrategia de contratación.</p>
            <p><strong>Fecha de publicación:</strong> 20 de noviembre de 2024</p>
            <p>Las empresas están reconociendo el valor de los estudiantes con experiencia práctica, lo que ha llevado a más empresas a implementar programas...</p>
        </div>
        <button class="btn btn-secondary" onclick="cerrarNoticia()">Cerrar</button>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para mostrar la noticia completa
        function mostrarNoticia(noticiaId) {
            const detallesNoticias = document.querySelectorAll('.news-detail');
            detallesNoticias.forEach(detail => detail.style.display = 'none');
            const noticia = document.getElementById(noticiaId);
            noticia.style.display = 'block';
            window.location.hash = noticiaId;
        }

        // Función para cerrar la noticia
        function cerrarNoticia() {
            const detallesNoticias = document.querySelectorAll('.news-detail');
            detallesNoticias.forEach(detail => detail.style.display = 'none');
            window.location.hash = '';
        }
    </script>

    <!-- Pie de página -->
	<!--
    <footer>
        <p>&copy; 2024 Educación Dual. Todos los derechos reservados.</p>
        <a href="#">Términos de uso</a> | <a href="#">Política de privacidad</a>
    </footer>
-->
</body>
</html>
