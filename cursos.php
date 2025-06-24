<?php
// Aquí podrías incluir lógica para sesión, base de datos, etc.
// Por ejemplo: session_start(); o include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cursos</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- NAVBAR -->
  <div class="navbar">
    <img src="assets/municipalidad.png" alt="Logo" class="logo">
    <nav>
      <a href="index.php" class="nav-link"><img src="assets/icono-panel.png" alt="Panel" class="nav-icon"> PANEL</a>
      <a href="cursos.php" class="nav-link active"><img src="assets/icono-cursos.png" alt="Cursos" class="nav-icon"> CURSOS</a>
    </nav>
    <div class="dropdown">
      <span>1º PRIMARIA</span><span class="arrow">&#9660;</span>
    </div>
  </div>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="cursos-container">
    <h1 class="titulo">Cursos</h1>
    <p class="subtitulo">Todos los cursos necesarios para un buen aprendizaje</p>

    <!-- Curso destacado -->
    <div class="curso-destacado">
      <img src="assets/math.png" alt="Matemáticas" class="img-destacada">
      <div>
        <div class="badge">RECOMENDADO</div>
        <h2 class="curso-titulo">Matemáticas</h2>
      </div>
    </div>

     <!-- Grid de cursos con imágenes -->
    <div class="grid-cursos">
      <a href="detalle.php" class="link-curso">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/escritura.png" alt="Matemáticas"></div>
          <span>Reconocimiento de números y su escritura.</span>
        </div>
      </a>
      <div class="curso-box">
        <div class="curso-imagen"><img src="assets/suma.png" alt="Suma hasta 10"></div>
        <span>Suma hasta 10</span>
      </div>
      <div class="curso-box">
        <div class="curso-imagen"><img src="assets/resta.png" alt="Resta hasta 10"></div>
        <span>Resta hasta 10</span>
      </div>
      <div class="curso-box">
        <div class="curso-imagen"><img src="assets/veinte.png" alt="Números del 11 al 20"></div>
        <span>Números del 11 al 20</span>
      </div>
      <div class="curso-box">
        <div class="curso-imagen"><img src="assets/figuras.png" alt="Figuras geométricas básicas"></div>
        <span>Figuras geométricas básicas</span>
      </div>
      <div class="curso-box">
        <div class="curso-imagen"><img src="assets/medicion.png" alt="Medición básica"></div>
        <span>Medición básica</span>
      </div>
      <div class="curso-box">
        <div class="curso-imagen"><img src="assets/direccion.png" alt="Orientación espacial"></div>
        <span>Orientación espacial</span>
      </div>
      <div class="curso-box">
        <div class="curso-imagen"><img src="assets/patron.png" alt="Clasificación y patrones"></div>
        <span>Clasificación y patrones</span>
      </div>
    </div>
  </div>
</body>
</html>






