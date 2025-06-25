let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;
let timerInterval;
let timerValue = 10;
let timeTaken = 0;

// Ejemplo de preguntas de conteo, cámbialas según tu unidad
const questions = [
  { type: 'counting', title: '¿Cuántos patitos hay?', content: '🦆🦆🦆', options: ['2', '3', '4', '5'], correct: '3' },
  { type: 'counting', title: 'Cuenta los manzanas 🍎🍎🍎🍎', content: '', options: ['2', '3', '4', '5'], correct: '4' },
  { type: 'counting', title: '¿Cuántos autos ves? 🚗🚗', content: '', options: ['1', '2', '3', '4'], correct: '2' },
  { type: 'counting', title: 'Selecciona el número de estrellas ⭐⭐⭐⭐⭐', content: '', options: ['3', '4', '5', '6'], correct: '5' },
  { type: 'counting', title: '¿Cuántos globos hay? 🎈🎈🎈🎈🎈🎈', content: '', options: ['5', '6', '7', '8'], correct: '6' },
  { type: 'counting', title: '¿Cuántos peces? 🐟🐟🐟', content: '', options: ['2', '3', '4', '5'], correct: '3' },
  { type: 'counting', title: 'Cuenta los corazones ❤️❤️❤️❤️❤️', content: '', options: ['3', '4', '5', '6'], correct: '5' },
  { type: 'counting', title: '¿Cuántas flores? 🌸🌸🌸🌸', content: '', options: ['2', '3', '4', '5'], correct: '4' },
  { type: 'counting', title: 'Selecciona el número de gatos 🐱🐱', content: '', options: ['1', '2', '3', '4'], correct: '2' },
  { type: 'counting', title: '¿Cuántos soles? ☀️☀️☀️', content: '', options: ['2', '3', '4', '5'], correct: '3' },
  { type: 'counting', title: 'Cuenta los árboles 🌳🌳🌳🌳🌳', content: '', options: ['4', '5', '6', '7'], correct: '5' },
  { type: 'counting', title: '¿Cuántos lápices? ✏️✏️✏️✏️', content: '', options: ['3', '4', '5', '6'], correct: '4' }
];

function initLesson() {
  coins = parseInt(localStorage.getItem('coins')) || 0;
  updateCoins();
  updateHearts();
  showQuestion();
  updateProgress();
}

function showQuestion() {
  clearInterval(timerInterval);
  timerValue = 10;
  timeTaken = 0;
  updateTimerBar();

  const q = questions[currentQuestionIndex];
  document.getElementById('questionTitle').textContent = q.title;
  document.getElementById('btnContinue').disabled = true;
  selectedOption = null;

  const optionsContainer = document.getElementById('questionOptions');
  optionsContainer.innerHTML = '';
  q.options.forEach(opt => {
    const btn = document.createElement('button');
    btn.className = 'option-btn';
    btn.textContent = opt;
    btn.setAttribute('data-value', opt);
    btn.onclick = () => selectOption(btn, opt);
    optionsContainer.appendChild(btn);
  });

  const questionContent = document.getElementById('questionContent');
  questionContent.innerHTML = '';
  // Si hay content, lo muestra (por si se quieren poner dibujos o emojis grandes)
  if (q.content && q.content !== '?') {
    const numberDiv = document.createElement('div');
    numberDiv.className = 'number-display';
    numberDiv.textContent = q.content;
    questionContent.appendChild(numberDiv);
  }

  timerInterval = setInterval(() => {
    timerValue--;
    timeTaken++;
    updateTimerBar();
    if (timerValue <= 0) {
      clearInterval(timerInterval);
      document.getElementById('btnContinue').disabled = false;
    }
  }, 1000);
}

function selectOption(button, value) {
  document.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('selected'));
  button.classList.add('selected');
  selectedOption = value;
  document.getElementById('btnContinue').disabled = false;
}

function nextQuestion() {
  clearInterval(timerInterval);
  if (!selectedOption) return;

  const q = questions[currentQuestionIndex];
  const correct = selectedOption === q.correct;
  showAnswerFeedback(correct);

  if (correct) {
    correctAnswers++;
    const gained = 100 + timerValue * 10;
    coins += gained;
    updateCoins();
    document.getElementById('coinChangeTextCorrect').textContent = `+${gained} monedas`;
    setTimeout(() => showModal('correctModal'), 800);
  } else {
    hearts--;
    coins = Math.max(0, coins - 200);
    updateCoins();
    document.getElementById('correctAnswerText').textContent = `La respuesta correcta es: ${q.correct}`;
    document.getElementById('coinChangeTextIncorrect').textContent = `-200 monedas`;
    setTimeout(() => showModal('incorrectModal'), 800);
  }
}

function showAnswerFeedback(correct) {
  const q = questions[currentQuestionIndex];
  document.querySelectorAll('.option-btn').forEach(btn => {
    const val = btn.getAttribute('data-value');
    if (val === q.correct) btn.classList.add('correct');
    else if (val === selectedOption && !correct) btn.classList.add('incorrect');
    btn.disabled = true;
  });
  document.getElementById('btnContinue').disabled = true;
}

function continueAfterModal() {
  currentQuestionIndex++;
  if (currentQuestionIndex >= questions.length || hearts <= 0) {
    localStorage.setItem('tema2Completed', 'true');
    localStorage.setItem('coins', coins);
    showCompletionModal();
  } else {
    updateProgress();
    showQuestion();
  }
}

function showModal(id) {
  document.getElementById(id).classList.add('show');
  // Feedback visual motivacional
  if (id === 'correctModal') {
    triggerConfetti();
    setMotivationalText('correctModal', '¡Muy bien! ¡Eres un genio!');
  } else if (id === 'incorrectModal') {
    setMotivationalText('incorrectModal', '¡No pasa nada, tú puedes!');
  }
}

function setMotivationalText(modalId, text) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  let txt = modal.querySelector('.motivational-text');
  if (!txt) {
    txt = document.createElement('div');
    txt.className = 'motivational-text';
    modal.querySelector('.modal-content').appendChild(txt);
  }
  txt.textContent = text;
}

function triggerConfetti() {
  if (window.confetti) {
    window.confetti({
      particleCount: 70,
      spread: 90,
      origin: { y: 0.7 }
    });
  } else {
    document.body.style.background = "#b5f5c2";
    setTimeout(() => document.body.style.background = "", 350);
  }
}

function closeModal() {
  document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
  setTimeout(() => continueAfterModal(), 300);
}

function showCompletionModal() {
  document.getElementById('finalCoins').textContent = coins;
  document.getElementById('finalAccuracy').textContent = `${Math.round((correctAnswers / questions.length) * 100)}%`;
  localStorage.setItem('currentTopic_modulo1', 'tema3');
  showModal('completedModal');
}

function restartLesson() {
  currentQuestionIndex = 0;
  coins = 0;
  hearts = 3;
  correctAnswers = 0;
  selectedOption = null;
  localStorage.setItem('coins', 0);
  closeModal();
  setTimeout(() => initLesson(), 300);
}

function goToNextLesson() {
  // Cambia la ruta al siguiente tema si aplica
  window.location.href = "../tema3_asociacion/leccion.php";
}

function updateProgress() {
  const percent = ((currentQuestionIndex + 1) / questions.length) * 100;
  document.getElementById('progressFill').style.width = `${percent}%`;
  document.getElementById('progressText').textContent = `${currentQuestionIndex + 1}/${questions.length}`;
}

function updateCoins() {
  document.getElementById('coinsCount').textContent = coins;
  localStorage.setItem('coins', coins);
}

function updateHearts() {
  for (let i = 1; i <= 3; i++) {
    const heart = document.getElementById(`heart${i}`);
    i > hearts ? heart.classList.add('lost') : heart.classList.remove('lost');
  }
}

function updateTimerBar() {
  const bar = document.getElementById('timerBar');
  const barText = document.getElementById('timerBarText');
  let percent = (timerValue / 10) * 100;
  bar.style.width = percent + "%";

  bar.classList.remove('low', 'critical');
  if (timerValue <= 3) {
    bar.classList.add('critical');
  } else if (timerValue <= 6) {
    bar.classList.add('low');
  }

  barText.textContent = timerValue > 0 ? timerValue : "¡Tiempo!";

  if (timerValue === 3 && window.navigator && window.navigator.vibrate) {
    window.navigator.vibrate(150);
  }
}

document.addEventListener('DOMContentLoaded', initLesson);