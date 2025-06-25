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
  <style>
    .locked {
      pointer-events: auto;
      opacity: 0.5;
      cursor: not-allowed;
    }
  </style>
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

    <!-- Grid de cursos con imágenes y control de avance -->
    <div class="grid-cursos">
      <!-- Módulo I: siempre desbloqueado -->
      <a href="detalle.php?modulo=1" class="link-curso" id="cursoEscritura">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/escritura.png" alt="Matemáticas"></div>
          <span>Reconocimiento de números y su escritura.</span>
        </div>
      </a>
      <!-- Módulo II: desbloqueo progresivo -->
      <a href="#" class="link-curso" id="cursoSuma">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/suma.png" alt="Suma hasta 10"></div>
          <span>Suma hasta 10</span>
        </div>
      </a>
      <!-- Módulo III: desbloqueo progresivo -->
      <a href="#" class="link-curso" id="cursoResta">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/resta.png" alt="Resta hasta 10"></div>
          <span>Resta hasta 10</span>
        </div>
      </a>
      <!-- Módulo IV -->
      <a href="#" class="link-curso" id="cursoVeinte">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/veinte.png" alt="Números del 11 al 20"></div>
          <span>Números del 11 al 20</span>
        </div>
      </a>
      <!-- Módulo V -->
      <a href="#" class="link-curso" id="cursoFiguras">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/figuras.png" alt="Figuras geométricas básicas"></div>
          <span>Figuras geométricas básicas</span>
        </div>
      </a>
      <!-- Módulo VI -->
      <a href="#" class="link-curso" id="cursoMedicion">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/medicion.png" alt="Medición básica"></div>
          <span>Medición básica</span>
        </div>
      </a>
      <!-- Módulo VII -->
      <a href="#" class="link-curso" id="cursoOrientacion">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/direccion.png" alt="Orientación espacial"></div>
          <span>Orientación espacial</span>
        </div>
      </a>
      <!-- Módulo VIII -->
      <a href="#" class="link-curso" id="cursoPatrones">
        <div class="curso-box">
          <div class="curso-imagen"><img src="assets/patron.png" alt="Clasificación y patrones"></div>
          <span>Clasificación y patrones</span>
        </div>
      </a>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Escritura siempre disponible
      document.getElementById('cursoEscritura').onclick = function () {
        window.location.href = "detalle.php?modulo=1";
      };

      // Suma hasta 10 (solo si módulo 1 terminado)
      const mod1Done = localStorage.getItem('modulo1_terminado') === 'true';
      const cursoSuma = document.getElementById('cursoSuma');
      if (mod1Done) {
        cursoSuma.classList.remove('locked');
        cursoSuma.onclick = function () {
          window.location.href = "detalle.php?modulo=2";
        };
      } else {
        cursoSuma.classList.add('locked');
        cursoSuma.onclick = function (e) {
          e.preventDefault();
          alert('Debes completar "Reconocimiento de números y su escritura" antes de acceder a este módulo.');
        };
      }

      // Resta hasta 10 (solo si módulo 2 terminado)
      const mod2Done = localStorage.getItem('modulo2_terminado') === 'true';
      const cursoResta = document.getElementById('cursoResta');
      if (mod2Done) {
        cursoResta.classList.remove('locked');
        cursoResta.onclick = function () {
          window.location.href = "detalle.php?modulo=3";
        };
      } else {
        cursoResta.classList.add('locked');
        cursoResta.onclick = function (e) {
          e.preventDefault();
          alert('Debes completar "Suma hasta 10" antes de acceder a este módulo.');
        };
      }

      // Números del 11 al 20 (solo si módulo 3 terminado)
      const mod3Done = localStorage.getItem('modulo3_terminado') === 'true';
      const cursoVeinte = document.getElementById('cursoVeinte');
      if (mod3Done) {
        cursoVeinte.classList.remove('locked');
        cursoVeinte.onclick = function () {
          window.location.href = "detalle.php?modulo=4";
        };
      } else {
        cursoVeinte.classList.add('locked');
        cursoVeinte.onclick = function (e) {
          e.preventDefault();
          alert('Debes completar "Resta hasta 10" antes de acceder a este módulo.');
        };
      }

      // Figuras geométricas básicas (solo si módulo 4 terminado)
      const mod4Done = localStorage.getItem('modulo4_terminado') === 'true';
      const cursoFiguras = document.getElementById('cursoFiguras');
      if (mod4Done) {
        cursoFiguras.classList.remove('locked');
        cursoFiguras.onclick = function () {
          window.location.href = "detalle.php?modulo=5";
        };
      } else {
        cursoFiguras.classList.add('locked');
        cursoFiguras.onclick = function (e) {
          e.preventDefault();
          alert('Debes completar "Números del 11 al 20" antes de acceder a este módulo.');
        };
      }

      // Medición básica (solo si módulo 5 terminado)
      const mod5Done = localStorage.getItem('modulo5_terminado') === 'true';
      const cursoMedicion = document.getElementById('cursoMedicion');
      if (mod5Done) {
        cursoMedicion.classList.remove('locked');
        cursoMedicion.onclick = function () {
          window.location.href = "detalle.php?modulo=6";
        };
      } else {
        cursoMedicion.classList.add('locked');
        cursoMedicion.onclick = function (e) {
          e.preventDefault();
          alert('Debes completar "Figuras geométricas básicas" antes de acceder a este módulo.');
        };
      }

      // Orientación espacial (solo si módulo 6 terminado)
      const mod6Done = localStorage.getItem('modulo6_terminado') === 'true';
      const cursoOrientacion = document.getElementById('cursoOrientacion');
      if (mod6Done) {
        cursoOrientacion.classList.remove('locked');
        cursoOrientacion.onclick = function () {
          window.location.href = "detalle.php?modulo=7";
        };
      } else {
        cursoOrientacion.classList.add('locked');
        cursoOrientacion.onclick = function (e) {
          e.preventDefault();
          alert('Debes completar "Medición básica" antes de acceder a este módulo.');
        };
      }

      // Clasificación y patrones (solo si módulo 7 terminado)
      const mod7Done = localStorage.getItem('modulo7_terminado') === 'true';
      const cursoPatrones = document.getElementById('cursoPatrones');
      if (mod7Done) {
        cursoPatrones.classList.remove('locked');
        cursoPatrones.onclick = function () {
          window.location.href = "detalle.php?modulo=8";
        };
      } else {
        cursoPatrones.classList.add('locked');
        cursoPatrones.onclick = function (e) {
          e.preventDefault();
          alert('Debes completar "Orientación espacial" antes de acceder a este módulo.');
        };
      }
    });
  </script>
</body>
</html>