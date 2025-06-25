<?php
// Aquí puedes incluir lógica de autenticación, cargar contenido desde base de datos, etc.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle: Reconocimiento de números</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .highlight-modulo {
      border: 3px solid #4caf50 !important;
      box-shadow: 0 0 10px #4caf50;
      background: #e7ffe7 !important;
      transition: all 0.5s;
    }
  </style>
</head>
<body>
  <!-- NAVBAR -->
  <div class="navbar">
    <img src="assets/municipalidad.png" alt="Logo" class="logo">
    <nav>
      <a href="index.php" class="nav-link">
        <img src="assets/icono-panel.png" alt="Panel" class="nav-icon"> PANEL
      </a>
      <a href="cursos.php" class="nav-link active">
        <img src="assets/icono-cursos.png" alt="Cursos" class="nav-icon"> CURSOS
      </a>
    </nav>
    <div class="dropdown">
      <span>1º PRIMARIA</span><span class="arrow">&#9660;</span>
    </div>
  </div>

  <!-- CONTENEDOR PRINCIPAL -->
  <div class="detalle-container">
    <div class="detalle-curso">
      <!-- Tarjeta izquierda -->
      <div class="detalle-card">
        <img src="assets/math.png" alt="Matemáticas" class="icon-detalle">
        <h2>Matemáticas</h2>
        <p class="descripcion-detalle">Descripción…</p>
        <div class="stats-detalle">
          <div class="stat">
            <img src="assets/icon-lecciones.png" alt="Lecciones">
            <span>55 lecciones</span>
          </div>
          <div class="stat">
            <img src="assets/icon-ejercicios.png" alt="Ejercicios">
            <span>75 ejercicios</span>
          </div>
        </div>
      </div>

      <!-- Panel derecho: solo módulos SCROLLEABLES -->
      <div class="detalle-info">
        <div class="modulos-scroll">
          <!-- MÓDULO I -->
          <div id="modulo1" class="module-tab modulo-box">
            <h2>MÓDULO I<br><small>Números del 1 al 10</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval completed">
                    <span class="step-text">Reconocimiento de números y su escritura.</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Conteo con objetos reales</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Asociación número-cantidad.</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
          <!-- MÓDULO II -->
          <div id="modulo2" class="module-tab modulo-box">
            <h2>MÓDULO II<br><small>Suma hasta 10</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval">
                    <span class="step-text">Introducción a la suma como juntar.</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Uso de objetos para sumar (fichas, frutas, palitos).</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Sumas con apoyo visual y sin llevar.</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
          <!-- MÓDULO III -->
          <div id="modulo3" class="module-tab modulo-box">
            <h2>MÓDULO III<br><small>Resta hasta 10</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval">
                    <span class="step-text">Introducción a la resta.</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Resta con objetos y dibujos.</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Restas sin llevar.</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
          <!-- ...Más módulos si lo necesitas... -->
        </div>
        <!-- SOLO el botón de continuar va fuera del scroll -->
        <div class="detalle-cta">
          <h3 id="ctaTitulo">Reconocimiento de números y su escritura.</h3>
          <button class="btn-empezar" id="btnInicioCurso">Empezar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script para scroll automático y highlight, y redirigir según el progreso -->
  <script>
    function getModuloParam() {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get('modulo');
    }
    document.addEventListener('DOMContentLoaded', function() {
      const moduloNum = getModuloParam() || "1";
      const moduloId = 'modulo' + moduloNum;
      const element = document.getElementById(moduloId);
      if (element) {
        element.scrollIntoView({behavior: 'smooth', block: 'center'});
        element.classList.add('highlight-modulo');
        setTimeout(() => {
          element.classList.remove('highlight-modulo');
        }, 4000);
      }

      // Lee el progreso SOLO del módulo actual
      const currentTopic = localStorage.getItem('currentTopic_modulo' + moduloNum);
      const boton = document.getElementById('btnInicioCurso');
      const titulo = document.getElementById('ctaTitulo');

      // Puedes personalizar los textos y rutas según tus temas reales
      if (currentTopic === 'tema2') {
        boton.textContent = 'Continuar';
        boton.onclick = () => window.location.href = `modulo${moduloNum}/tema2_conteo/leccion.php`;
        titulo.textContent = (moduloNum === "2")
          ? 'Uso de objetos para sumar (fichas, frutas, palitos).'
          : 'Conteo con objetos reales';
      } else if (currentTopic === 'tema3') {
        boton.textContent = 'Continuar';
        boton.onclick = () => window.location.href = `modulo${moduloNum}/tema3_asociacion/leccion.php`;
        titulo.textContent = (moduloNum === "2")
          ? 'Sumas con apoyo visual y sin llevar.'
          : 'Asociación número-cantidad';
      } else {
        boton.textContent = 'Empezar';
        boton.onclick = () => window.location.href = (
          moduloNum === "2"
            ? `modulo2/tema1_introduccion/leccion.php`
            : moduloNum === "3"
              ? `modulo3/tema1_introduccion_resta/leccion.php`
              : `modulo1/tema1_reconocimiento/leccion.php`
        );
        titulo.textContent = (
          moduloNum === "2"
            ? 'Introducción a la suma como juntar.'
            : moduloNum === "3"
              ? 'Introducción a la resta.'
              : 'Reconocimiento de números y su escritura.'
        );
      }
    });
  </script>
</body>
</html>