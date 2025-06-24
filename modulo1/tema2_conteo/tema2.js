let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;

const questions = [
  { title: "¿Cuántas piedras ves aquí?", count: 3, emoji: '🪨', options: ['2', '3', '4', '5'], correct: '3' },
  { title: "¿Cuántas semillas hay en la imagen?", count: 5, emoji: '🌱', options: ['6', '5', '4', '7'], correct: '5' },
  { title: "¿Puedes contar los objetos?", count: 1, emoji: '🧸', options: ['0', '1', '2', '3'], correct: '1' },
  { title: "Cuenta cuántas hojas aparecen.", count: 4, emoji: '🍃', options: ['2', '4', '5', '6'], correct: '4' },
  { title: "¿Cuántas frutas hay?", count: 6, emoji: '🍎', options: ['5', '6', '7', '8'], correct: '6' },
  { title: "Observa y cuenta los objetos.", count: 2, emoji: '🎈', options: ['2', '3', '1', '4'], correct: '2' },
  { title: "¿Cuántas conchitas se ven?", count: 7, emoji: '🐚', options: ['6', '7', '8', '9'], correct: '7' },
  { title: "Cuenta con atención.", count: 9, emoji: '🧩', options: ['9', '8', '7', '10'], correct: '9' },
  { title: "¿Cuántas bolitas aparecen?", count: 5, emoji: '🔴', options: ['4', '5', '6', '3'], correct: '5' },
  { title: "Cuenta las estrellas.", count: 8, emoji: '⭐', options: ['7', '8', '6', '9'], correct: '8' },
  { title: "¿Cuántos cocos ves?", count: 10, emoji: '🥥', options: ['10', '9', '8', '11'], correct: '10' },
  { title: "¿Cuántos granos hay?", count: 3, emoji: '🌾', options: ['3', '2', '1', '4'], correct: '3' },
  { title: "¿Cuántas figuras están presentes?", count: 6, emoji: '🔷', options: ['5', '6', '7', '4'], correct: '6' },
  { title: "Observa bien: ¿cuántas cuentas hay?", count: 2, emoji: '🟢', options: ['1', '2', '3', '0'], correct: '2' }
];

function renderObjects(count, emoji) {
  return '<div class="objects-container">' +
         Array(count).fill(`<div class="object-item">${emoji}</div>`).join('') +
         '</div>';
}

function initLesson() {
  updateProgress();
  updateCoins();
  updateHearts();
  showQuestion();
}

function showQuestion() {
  const q = questions[currentQuestionIndex];
  document.getElementById('questionTitle').textContent = q.title;
  document.getElementById('btnContinue').disabled = true;
  selectedOption = null;
  document.getElementById('questionContent').innerHTML = renderObjects(q.count, q.emoji);

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
}

function selectOption(button, value) {
  document.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('selected'));
  button.classList.add('selected');
  selectedOption = value;
  document.getElementById('btnContinue').disabled = false;
}

function nextQuestion() {
  if (!selectedOption) return;
  const q = questions[currentQuestionIndex];
  const correct = selectedOption === q.correct;
  showAnswerFeedback(correct);

  if (correct) {
    correctAnswers++;
    coins += 100;
    updateCoins();
    setTimeout(() => showModal('correctModal'), 800);
  } else {
    hearts--;
    updateHearts();
    document.getElementById('correctAnswerText').textContent = `La respuesta correcta es: ${q.correct}`;
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
  closeModal();
  setTimeout(() => initLesson(), 300);
}

function updateProgress() {
  const percent = ((currentQuestionIndex + 1) / questions.length) * 100;
  document.getElementById('progressFill').style.width = `${percent}%`;
  document.getElementById('progressText').textContent = `${currentQuestionIndex + 1}/${questions.length}`;
}

function updateCoins() {
  document.getElementById('coinsCount').textContent = coins;
}

function updateHearts() {
  for (let i = 1; i <= 3; i++) {
    const heart = document.getElementById(`heart${i}`);
    i > hearts ? heart.classList.add('lost') : heart.classList.remove('lost');
  }
}

document.addEventListener('DOMContentLoaded', initLesson);
