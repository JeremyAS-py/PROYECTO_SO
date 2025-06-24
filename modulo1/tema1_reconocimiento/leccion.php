<?php
// Lección del tema 1: Reconocimiento de números
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lección: Reconocimiento de números</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>
  <!-- NAVBAR -->
  <div class="navbar-leccion">
    <div class="nav-left">
      <button class="btn-cerrar" onclick="window.location.href='../../detalle.php'">✕</button>
      <div class="progress-container">
        <div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>
        <span class="progress-text" id="progressText">1/12</span>
      </div>
    </div>
    <div class="nav-right">
      <div class="coins-display">
        <div class="coin-icon-small"><img src="../../assets/coin.png" alt="Moneda"></div>
        <span class="coins-count" id="coinsCount">0</span>
      </div>
      <div class="hearts-display">
        <span class="heart" id="heart1">❤️</span>
        <span class="heart" id="heart2">❤️</span>
        <span class="heart" id="heart3">❤️</span>
      </div>
    </div>
  </div>

  <!-- CONTENEDOR PRINCIPAL -->
  <div class="leccion-container">
    <div class="question-card">
      <div class="question-header">
        <h2 class="question-title" id="questionTitle">¿Pregunta?</h2>
      </div>

      <!-- Barra de tiempo visual -->
      <div class="timer-bar-container" style="margin-bottom: 1rem;">
        <div id="timerBar" style="width: 100%; height: 12px; background: #ffc107; border-radius: 10px;"></div>
      </div>

      <div class="question-content" id="questionContent"></div>
      <div class="question-options" id="questionOptions"></div>
    </div>

    <div class="continue-section">
      <button class="btn-continue" id="btnContinue" onclick="nextQuestion()" disabled>Continuar</button>
    </div>
  </div>

  <!-- MODALES -->
  <div class="modal-overlay" id="correctModal">
    <div class="modal-content correct">
      <div class="modal-icon">🎉</div>
      <h3>¡Correcto!</h3>
      <p id="coinChangeTextCorrect">+100 monedas</p>
      <button class="modal-btn" onclick="closeModal()">Continuar</button>
    </div>
  </div>

  <div class="modal-overlay" id="incorrectModal">
    <div class="modal-content incorrect">
      <div class="modal-icon">😔</div>
      <h3>¡Oops!</h3>
      <p class="correct-answer" id="correctAnswerText">La respuesta correcta es: 5</p>
      <p id="coinChangeTextIncorrect">-200 monedas</p>
      <button class="modal-btn" onclick="closeModal()">Continuar</button>
    </div>
  </div>

  <div class="modal-overlay" id="completedModal">
    <div class="modal-content completed">
      <div class="modal-icon">🏆</div>
      <h3>¡Lección Completada!</h3>
      <div class="completion-stats">
        <div class="stat-item">
          <span class="stat-number" id="finalCoins">1000</span>
          <span class="stat-label">Monedas ganadas</span>
        </div>
        <div class="stat-item">
          <span class="stat-number" id="finalAccuracy">90%</span>
          <span class="stat-label">Precisión</span>
        </div>
      </div>
      <div class="completion-buttons">
        <button class="modal-btn primary" onclick="goToNextLesson()">Siguiente tema</button>
        <button class="modal-btn secondary" onclick="restartLesson()">Repetir lección</button>
      </div>
    </div>
  </div>

  <script src="tema1.js"></script>
</body>
</html>
