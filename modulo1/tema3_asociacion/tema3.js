let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;

const questions = [
  { type: 'match', title: "Selecciona el grupo con 2 objetos", count: 2, options: [1, 2, 3, 4], correct: 2 },
  { type: 'match', title: "¿Qué grupo tiene 5 semillas?", count: 5, options: [3, 4, 5, 6], correct: 5 },
  { type: 'match', title: "Elige el conjunto con 1 objeto", count: 1, options: [0, 1, 2, 3], correct: 1 },
  { type: 'match', title: "¿Cuál cantidad representa esta imagen?", count: 4, options: [2, 4, 5, 6], correct: 4 },
  { type: 'match', title: "¿Cuántos objetos hay?", count: 6, options: [6, 5, 7, 8], correct: 6 },
  { type: 'match', title: "Selecciona el número que representa lo que ves", count: 3, options: [2, 3, 4, 5], correct: 3 },
  { type: 'match', title: "¿Qué número corresponde al grupo mostrado?", count: 7, options: [6, 7, 8, 9], correct: 7 },
  { type: 'match', title: "Relaciona la cantidad con el número correcto", count: 8, options: [7, 8, 6, 9], correct: 8 },
  { type: 'match', title: "¿Qué número representa esta colección?", count: 9, options: [9, 10, 8, 7], correct: 9 },
  { type: 'match', title: "Escoge el número que representa los objetos", count: 5, options: [4, 5, 6, 7], correct: 5 },
  { type: 'match', title: "¿Qué cantidad se muestra?", count: 10, options: [8, 9, 10, 7], correct: 10 },
  { type: 'match', title: "¿Cuántos círculos ves?", count: 6, options: [6, 5, 7, 4], correct: 6 },
  { type: 'match', title: "Escoge el número correcto para esta cantidad", count: 2, options: [1, 2, 3, 4], correct: 2 }
];

function generateObjects(count) {
  const emojis = ['🍎', '🪨', '🌰', '🍓', '🌟', '🍇', '🌼'];
  let html = '<div class="objects-container">';
  for (let i = 0; i < count; i++) {
    const emoji = emojis[i % emojis.length];
    html += `<div class="object-item">${emoji}</div>`;
  }
  html += '</div>';
  return html;
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

  document.getElementById('questionContent').innerHTML = generateObjects(q.count);

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
  const correct = String(selectedOption) === String(q.correct);
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
    if (val === String(q.correct)) btn.classList.add('correct');
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
