<?php
// Aquí puedes incluir lógica de autenticación, cargar contenido desde base de datos, etc.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle: Comunicación</title>
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
        <img src="assets/libro.png" alt="Comunicación" class="icon-detalle">
        <h2>Comunicación</h2>
        <p class="descripcion-detalle">Desarrolla tus habilidades para leer, escribir y comprender textos, desde letras del abecedario hasta tu primer cuento.</p>
        <div class="stats-detalle">
          <div class="stat">
            <img src="assets/icon-lecciones.png" alt="Lecciones">
            <span>34 lecciones</span>
          </div>
          <div class="stat">
            <img src="assets/icon-ejercicios.png" alt="Ejercicios">
            <span>52 ejercicios</span>
          </div>
        </div>
      </div>

      <!-- Panel derecho: solo módulos SCROLLEABLES -->
      <div class="detalle-info">
        <div class="modulos-scroll">
          <!-- MÓDULO I -->
          <div id="modulo1" class="module-tab modulo-box">
            <h2>MÓDULO I<br><small>Letras y sílabas</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval completed">
                    <span class="step-text">Reconozco letras del abecedario</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Formo sílabas</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Encuentra la sílaba que falta</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
          <!-- MÓDULO II -->
          <div id="modulo2" class="module-tab modulo-box">
            <h2>MÓDULO II<br><small>Palabras y frases</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval">
                    <span class="step-text">Palabras simples</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">¿Qué dice la frase?</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Completa la palabra</span>
                  </div>
                </div>
                <div class="path-step step-4">
                  <div class="step-oval">
                    <span class="step-text">Relaciona palabra con imagen</span>
                  </div>
                </div>
                <div class="path-line line-1"></div>
                <div class="path-line line-2"></div>
              </div>
            </div>
          </div>
          <!-- MÓDULO III -->
          <div id="modulo3" class="module-tab modulo-box">
            <h2>MÓDULO III<br><small>Comprensión y escritura</small></h2>
            <div class="path-section">
              <div class="path-container">
                <div class="path-step step-1">
                  <div class="step-oval">
                    <span class="step-text">¿Quién hace qué?</span>
                  </div>
                </div>
                <div class="path-step step-2">
                  <div class="step-oval">
                    <span class="step-text">Elige la imagen correcta</span>
                  </div>
                </div>
                <div class="path-step step-3">
                  <div class="step-oval">
                    <span class="step-text">Ordena la oración</span>
                  </div>
                </div>
                <div class="path-step step-4">
                  <div class="step-oval">
                    <span class="step-text">Leo mi primer cuento</span>
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
          <h3 id="ctaTitulo">Reconozco letras del abecedario</h3>
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

      // Lee el progreso SOLO del módulo actual para comunicación
      const currentTopic = localStorage.getItem('currentTopic_comunicacion_modulo' + moduloNum);
      const boton = document.getElementById('btnInicioCurso');
      const titulo = document.getElementById('ctaTitulo');

      // Rutas y textos por módulo y tema para Comunicación
      if (moduloNum === "1") {
        // MÓDULO I: Letras y sílabas
        if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo1/tema2_formo_silabas/leccion.php';
          titulo.textContent = 'Formo sílabas';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo1/tema3_silaba_falta/leccion.php';
          titulo.textContent = 'Encuentra la sílaba que falta';
        } else {
          // Primera vez o sin progreso: ir directo a la lección 1
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo1/tema1_letras/leccion.php';
          titulo.textContent = 'Reconozco letras del abecedario';
        }
      } else if (moduloNum === "2") {
        // MÓDULO II: Palabras y frases
        if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo2/tema2_frase/leccion.php';
          titulo.textContent = '¿Qué dice la frase?';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo2/tema3_completa_palabra/leccion.php';
          titulo.textContent = 'Completa la palabra';
        } else if (currentTopic === 'tema4') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo2/tema4_relaciona_palabra_imagen/leccion.php';
          titulo.textContent = 'Relaciona palabra con imagen';
        } else {
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo2/tema1_palabras_simples/leccion.php';
          titulo.textContent = 'Palabras simples';
        }
      } else if (moduloNum === "3") {
        // MÓDULO III: Comprensión y escritura
        if (currentTopic === 'tema2') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo3/tema2_elije_imagen/leccion.php';
          titulo.textContent = 'Elige la imagen correcta';
        } else if (currentTopic === 'tema3') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo3/tema3_ordena_oracion/leccion.php';
          titulo.textContent = 'Ordena la oración';
        } else if (currentTopic === 'tema4') {
          boton.textContent = 'Continuar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo3/tema4_cuento/leccion.php';
          titulo.textContent = 'Leo mi primer cuento';
        } else {
          boton.textContent = 'Empezar';
          boton.onclick = () => window.location.href = 'Comunicacion/modulo3/tema1_quien_hace_que/leccion.php';
          titulo.textContent = '¿Quién hace qué?';
        }
      }
    });
  </script>
</body>
</html>