let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;
let timerInterval;
let timerValue = 10;
let timeTaken = 0;

const questions = [
  { type: 'number_recognition', title: '¿Qué número es este?', content: '7', options: ['5', '6', '7', '9'], correct: '7' },
  { type: 'number_recognition', title: '¿Cuál es el número mostrado?', content: '2', options: ['1', '3', '2', '5'], correct: '2' },
  { type: 'number_recognition', title: '¿Qué número ves aquí?', content: '9', options: ['6', '8', '9', '0'], correct: '9' },
  { type: 'number_recognition', title: 'Selecciona el número 4', content: '?', options: ['2', '4', '7', '3'], correct: '4' },
  { type: 'number_recognition', title: 'Elige el número cinco (5)', content: '5', options: ['3', '5', '8', '6'], correct: '5' },
  { type: 'number_recognition', title: '¿Qué número está en pantalla?', content: '0', options: ['0', '1', '2', '3'], correct: '0' },
  { type: 'number_recognition', title: 'Selecciona el número que está entre 2 y 4', content: '?', options: ['1', '3', '5', '0'], correct: '3' },
  { type: 'number_recognition', title: '¿Qué número viene después del 6?', content: '?', options: ['5', '7', '6', '4'], correct: '7' },
  { type: 'number_recognition', title: 'Elige el número que ves: ocho (8)', content: '8', options: ['6', '7', '8', '9'], correct: '8' },
  { type: 'number_recognition', title: 'Señala el número uno (1)', content: '1', options: ['0', '1', '2', '3'], correct: '1' },
  { type: 'number_recognition', title: '¿Cuál es el número menor?', content: '?', options: ['4', '2', '1', '3'], correct: '1' },
  { type: 'number_recognition', title: 'Selecciona el número seis (6)', content: '6', options: ['6', '7', '8', '5'], correct: '6' }
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
  document.getElementById('questionContent').textContent = q.content;
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
    const gained = 100 + timerValue * 10; // 🟢 Ganancia proporcional al tiempo restante
    coins += gained;
    updateCoins();
    document.getElementById('coinChangeTextCorrect').textContent = `+${gained} monedas`;
    setTimeout(() => showModal('correctModal'), 800);
  } else {
    hearts--;
    coins = Math.max(0, coins - 200); // 🔴 Resta por error
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
    localStorage.setItem('tema1Completed', 'true');
    localStorage.setItem('coins', coins);
    showCompletionModal();
  } else {
    updateProgress();
    showQuestion();
  }
}

function showModal(id) {
  document.getElementById(id).classList.add('show');
}

function closeModal() {
  document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
  setTimeout(() => continueAfterModal(), 300);
}

function showCompletionModal() {
  document.getElementById('finalCoins').textContent = coins;
  document.getElementById('finalAccuracy').textContent = `${Math.round((correctAnswers / questions.length) * 100)}%`;
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
  window.location.href = "../tema2_conteo/leccion.php";
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
  bar.style.height = '12px';
  bar.style.background = '#ffc107';
  bar.style.width = `${(timerValue / 10) * 100}%`;
}

document.addEventListener('DOMContentLoaded', initLesson);
