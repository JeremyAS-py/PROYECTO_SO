<?php
// Aquí puedes incluir lógica de autenticación, cargar contenido desde base de datos, etc.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle: Programación</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .highlight-modulo {
      border: 3px solid #2196f3 !important;
      box-shadow: 0 0 10px #2196f3;
      background: #e7f3ff !important;
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
        <img src="assets/computadora.png" alt="Programación" class="icon-detalle">
        <h2>Programación</h2>
        <p class="descripcion-detalle">Aprende los conceptos básicos de la programación explorando el movimiento, las secuencias y la lógica de causa y efecto a través de divertidos desafíos interactivos.</p>
        <div class="stats-detalle">
          <div class="stat">
            <img src="assets/icon-lecciones.png" alt="Lecciones">
            <span>9 lecciones</span>
          </div>
          <div class="stat">
            <img src="assets/icon-ejercicios.png" alt="Ejercicios">
            <span>18 ejercicios</span>
          </div>
        </div>
      </div>

      <!-- Panel derecho: solo módulos SCROLLEABLES -->
      <div class="detalle-info">
        <div class="modulos-scroll">
          <!-- MÓDULO I -->
          <div id="modulo1" class="module-tab modulo-box">
            <h2>MÓDULO I<br><small>Movimiento básico</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval completed">
                    <span class="step-text">Avanza y gira</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Ruta al objetivo</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Esquiva obstáculos</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
          <!-- MÓDULO II -->
          <div id="modulo2" class="module-tab modulo-box">
            <h2>MÓDULO II<br><small>Secuencias</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval">
                    <span class="step-text">Repetición básica</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Ordena los pasos</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Recoge objetos</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
          <!-- MÓDULO III -->
          <div id="modulo3" class="module-tab modulo-box">
            <h2>MÓDULO III<br><small>Causa y efecto</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval">
                    <span class="step-text">Cambiar color</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Reacción al clic</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Mini historia</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- SOLO el botón de continuar va fuera del scroll -->
        <div class="detalle-cta">
          <h3 id="ctaTitulo">Avanza y gira</h3>
          <button class="btn-empezar" id="btnInicioCurso">Empezar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Script para scroll automático, highlight y redirigir correctamente -->
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

      // Lee el progreso SOLO del módulo actual para programación
      const currentTopic = localStorage.getItem('currentTopic_progra_modulo' + moduloNum);
      const boton = document.getElementById('btnInicioCurso');
      const titulo = document.getElementById('ctaTitulo');

      // Rutas y textos por módulo y tema para Programación
      if (moduloNum === "1") {
        // MÓDULO I: Movimiento básico
        if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Progra/modulo1/tema2_ruta_objetivo/leccion.php';
          titulo.textContent = 'Ruta al objetivo';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Progra/modulo1/tema3_esquiva_obstaculos/leccion.php';
          titulo.textContent = 'Esquiva obstáculos';
        } else {
          // Primera vez o sin progreso: ir directo a la lección 1
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = 'Programacion/modulo1/tema1_adelante_y_gira/leccion.php';
          titulo.textContent = 'Avanza y gira';
        }
      } else if (moduloNum === "2") {
        // MÓDULO II: Secuencias
        if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Progra/modulo2/tema2_ordena_pasos/leccion.php';
          titulo.textContent = 'Ordena los pasos';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Progra/modulo2/tema3_recoge_objetos/leccion.php';
          titulo.textContent = 'Recoge objetos';
        } else {
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = 'Progra/modulo2/tema1_repeticion_basica/leccion.php';
          titulo.textContent = 'Repetición básica';
        }
      } else if (moduloNum === "3") {
        // MÓDULO III: Causa y efecto
        if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Progra/modulo3/tema2_reaccion_clic/leccion.php';
          titulo.textContent = 'Reacción al clic';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Progra/modulo3/tema3_mini_historia/leccion.php';
          titulo.textContent = 'Mini historia';
        } else {
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = 'Progra/modulo3/tema1_cambiar_color/leccion.php';
          titulo.textContent = 'Cambiar color';
        }
      }
    });
  </script>
</body>
</html>