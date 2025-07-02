<?php
// Lección del tema 2: Uso de objetos para sumar (fichas, frutas, palitos)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Uso de objetos para sumar - Suma hasta 10</title>
    <link rel="stylesheet" href="../../../style.css">
</head>
<body>
    <!-- NAVBAR -->
    <div class="navbar-leccion">
        <div class="nav-left">
            <button class="btn-cerrar" onclick="window.location.href='../../detalle.php?modulo=2'">✕</button>
            <div class="progress-container">
                <div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>
                <span class="progress-text" id="progressText">1/12</span>
            </div>
        </div>
        <div class="nav-right">
            <div class="coins-display">
                <div class="coin-icon-small"><img src="../../../assets/coin.png" alt="Moneda"></div>
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
                <h2 class="question-title" id="questionTitle"></h2>
            </div>
            <!-- Barra de tiempo visual -->
            <div class="timer-bar-container">
                <div id="timerBar" class="timer-bar-fill"></div>
                <div id="timerBarText" class="timer-bar-text"></div>
            </div>
            <div class="question-content" id="questionContent"></div>
            <div class="question-options" id="questionOptions"></div>
        </div>
        <div class="continue-section">
            <button class="btn-continue" id="btnContinue" onclick="nextQuestion()" disabled>Siguiente</button>
        </div>
    </div>

    <!-- MODALES -->
    <div class="modal-overlay" id="correctModal">
        <div class="modal-content correct">
            <div class="modal-icon">🎉</div>
            <h3>¡Correcto!</h3>
            <p id="coinChangeTextCorrect">+100 monedas</p>
            <button class="modal-btn" onclick="closeModal()">Continuar</button>
            <div class="motivational-text"></div>
        </div>
    </div>
    <div class="modal-overlay" id="incorrectModal">
        <div class="modal-content incorrect">
            <div class="modal-icon">😔</div>
            <h3>¡Oops!</h3>
            <p class="correct-answer" id="correctAnswerText"></p>
            <p id="coinChangeTextIncorrect">-200 monedas</p>
            <button class="modal-btn" onclick="closeModal()">Continuar</button>
            <div class="motivational-text"></div>
        </div>
    </div>
    <div class="modal-overlay" id="completedModal">
        <div class="modal-content completed">
            <div class="modal-icon">🏆</div>
            <h3>¡Lección Completada!</h3>
            <div class="completion-stats">
                <div class="stat-item">
                    <span class="stat-number" id="finalCoins">0</span>
                    <span class="stat-label">Monedas ganadas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" id="finalAccuracy">0%</span>
                    <span class="stat-label">Precisión</span>
                </div>
            </div>
            <div class="completion-buttons">
                <button class="modal-btn primary" onclick="goToNextLesson()">Siguiente tema</button>
                <button class="modal-btn secondary" onclick="restartLesson()">Repetir lección</button>
            </div>
        </div>
    </div>

    <!-- Confetti y JS principal -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
    <script src="tema2.js"></script>
</body>
</html>