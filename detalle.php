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
    .modulo-bloqueado {
      opacity: 0.5;
      pointer-events: none;
    }
    .modulo-desbloqueado {
      border: 2px solid #2196F3;
      background: #f0f8ff;
    }
    .step-oval.completed {
      background-color: #4caf50;
      color: white;
    }
    .step-oval.current {
      background-color: #2196F3;
      color: white;
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
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
                  <div class="step-oval" id="modulo1-tema1">
                    <span class="step-text">Reconocimiento de números y su escritura.</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval" id="modulo1-tema2">
                    <span class="step-text">Conteo con objetos reales</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval" id="modulo1-tema3">
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
                  <div class="step-oval" id="modulo2-tema1">
                    <span class="step-text">Introducción a la suma como juntar.</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval" id="modulo2-tema2">
                    <span class="step-text">Uso de objetos para sumar (fichas, frutas, palitos).</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval" id="modulo2-tema3">
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
                  <div class="step-oval" id="modulo3-tema1">
                    <span class="step-text">Introducción a la resta.</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval" id="modulo3-tema2">
                    <span class="step-text">Resta con objetos y dibujos.</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval" id="modulo3-tema3">
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

    function actualizarEstadoModulos() {
      // Verificar progreso del módulo 1
      const modulo1Terminado = localStorage.getItem('modulo1_terminado') === 'true';
      const modulo1Tema1 = localStorage.getItem('modulo1_tema1_terminado') === 'true';
      const modulo1Tema2 = localStorage.getItem('modulo1_tema2_terminado') === 'true';
      const modulo1Tema3 = localStorage.getItem('modulo1_tema3_terminado') === 'true';
      
      // Verificar si módulo 2 está desbloqueado
      const modulo2Desbloqueado = localStorage.getItem('modulo2_desbloqueado') === 'true';
      const modulo2Tema1 = localStorage.getItem('modulo2_tema1_terminado') === 'true';
      const modulo2Tema2 = localStorage.getItem('modulo2_tema2_terminado') === 'true';
      const modulo2Tema3 = localStorage.getItem('modulo2_tema3_terminado') === 'true';

      // Actualizar estado visual módulo 1
      if (modulo1Tema1) document.getElementById('modulo1-tema1').classList.add('completed');
      if (modulo1Tema2) document.getElementById('modulo1-tema2').classList.add('completed');
      if (modulo1Tema3) document.getElementById('modulo1-tema3').classList.add('completed');

      // Actualizar estado módulo 2
      const modulo2Element = document.getElementById('modulo2');
      if (modulo2Desbloqueado) {
        modulo2Element.classList.remove('modulo-bloqueado');
        modulo2Element.classList.add('modulo-desbloqueado');
        
        // Actualizar estado visual módulo 2
        if (modulo2Tema1) document.getElementById('modulo2-tema1').classList.add('completed');
        if (modulo2Tema2) document.getElementById('modulo2-tema2').classList.add('completed');
        if (modulo2Tema3) document.getElementById('modulo2-tema3').classList.add('completed');
      } else {
        modulo2Element.classList.add('modulo-bloqueado');
      }

      // Módulo 3 (bloqueado por defecto)
      document.getElementById('modulo3').classList.add('modulo-bloqueado');
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Actualizar estado visual de los módulos
      actualizarEstadoModulos();

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

      // Determinar el progreso y configurar el botón
      const boton = document.getElementById('btnInicioCurso');
      const titulo = document.getElementById('ctaTitulo');

      // Verificar estado de los módulos
      const modulo1Terminado = localStorage.getItem('modulo1_terminado') === 'true';
      const modulo2Desbloqueado = localStorage.getItem('modulo2_desbloqueado') === 'true';
      
      if (moduloNum === "1") {
        const currentTopic = localStorage.getItem('currentTopic_modulo1');
        
        if (modulo1Terminado) {
          boton.textContent = 'Completado ✓';
          boton.disabled = true;
          boton.style.opacity = '0.7';
          titulo.textContent = 'Módulo completado. ¡Felicitaciones!';
        } else if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = `modulo1/tema2_conteo/leccion.php`;
          titulo.textContent = 'Conteo con objetos reales';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = `modulo1/tema3_asociacion/leccion.php`;
          titulo.textContent = 'Asociación número-cantidad';
        } else {
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = `modulo1/tema1_reconocimiento/leccion.php`;
          titulo.textContent = 'Reconocimiento de números y su escritura';
        }
      } else if (moduloNum === "2") {
        if (!modulo2Desbloqueado) {
          boton.textContent = 'Bloqueado';
          boton.disabled = true;
          boton.style.opacity = '0.5';
          titulo.textContent = 'Completa el Módulo I para desbloquear';
          return;
        }

        const currentTopic = localStorage.getItem('currentTopic_modulo2');
        
        if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = `modulo2/tema2_objetos/leccion.php`;
          titulo.textContent = 'Uso de objetos para sumar (fichas, frutas, palitos)';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = `modulo2/tema3_sumas/leccion.php`;
          titulo.textContent = 'Sumas con apoyo visual y sin llevar';
        } else {
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = `modulo2/tema1_introduccion/leccion.php`;
          titulo.textContent = 'Introducción a la suma como juntar';
        }
      } else if (moduloNum === "3") {
        boton.textContent = 'Bloqueado';
        boton.disabled = true;
        boton.style.opacity = '0.5';
        titulo.textContent = 'Completa los módulos anteriores para desbloquear';
      }
    });
  </script>
</body>
</html>