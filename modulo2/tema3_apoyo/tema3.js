let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;
let timerInterval;
let timerValue = 25;
let timeTaken = 0;

const questions = [
  {
    type: 'suma_dedos',
    title: '✋ Usa tus dedos para sumar: 2 + 3 = ¿?',
    content: 'Levanta 2 dedos de una mano y 3 de la otra. ¿Cuántos dedos tienes levantados en total?',
    visual: 'hands',
    firstNumber: 2,
    secondNumber: 3,
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_puntos',
    title: '⚫⚫⚫ + ⚫⚫ = ¿? Cuenta los puntos negros',
    content: 'Observa los grupos de puntos y súmalos',
    visual: 'dots',
    firstNumber: 3,
    secondNumber: 2,
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_barras',
    title: '📊 Mira las barras de colores: 4 + 1 = ¿?',
    content: 'La barra azul tiene 4 unidades, la barra roja tiene 1 unidad',
    visual: 'bars',
    firstNumber: 4,
    secondNumber: 1,
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_grupos_formas',
    title: '🔷🔷 + 🔷🔷🔷🔷 = ¿? Suma los diamantes azules',
    content: 'Primer grupo: 2 diamantes, Segundo grupo: 4 diamantes',
    visual: 'shapes',
    firstNumber: 2,
    secondNumber: 4,
    shape: '🔷',
    options: ['5', '6', '7'],
    correct: '6'
  },
  {
    type: 'suma_recta_numerica',
    title: '📏 Usa la recta numérica: 3 + 2 = ¿?',
    content: 'Empieza en el 3, da 2 saltos hacia adelante',
    visual: 'number_line',
    firstNumber: 3,
    secondNumber: 2,
    options: ['4', '5', '6'],
    correct: '5'
  },
  {
    type: 'suma_dados',
    title: '🎲🎲 Suma los puntos de los dados',
    content: 'Primer dado: 4 puntos, Segundo dado: 3 puntos',
    visual: 'dice',
    firstNumber: 4,
    secondNumber: 3,
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'suma_cajas',
    title: '📦 Cuenta las cajas: 1 + 5 = ¿?',
    content: 'Caja azul tiene 1 objeto, caja verde tiene 5 objetos',
    visual: 'boxes',
    firstNumber: 1,
    secondNumber: 5,
    options: ['5', '6', '7'],
    correct: '6'
  },
  {
    type: 'suma_arboles',
    title: '🌳 Cuenta los árboles en el bosque: 3 + 4 = ¿?',
    content: 'Bosque izquierdo: 3 árboles, Bosque derecho: 4 árboles',
    visual: 'trees',
    firstNumber: 3,
    secondNumber: 4,
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'suma_estrellas',
    title: '⭐ Cuenta las estrellas brillantes: 5 + 2 = ¿?',
    content: 'Constelación 1: 5 estrellas, Constelación 2: 2 estrellas',
    visual: 'stars',
    firstNumber: 5,
    secondNumber: 2,
    options: ['6', '7', '8'],
    correct: '7'
  },
  {
    type: 'suma_bloques',
    title: '🧱 Construye con bloques: 2 + 6 = ¿?',
    content: 'Torre azul: 2 bloques, Torre roja: 6 bloques',
    visual: 'blocks',
    firstNumber: 2,
    secondNumber: 6,
    options: ['7', '8', '9'],
    correct: '8'
  },
  {
    type: 'suma_flores',
    title: '🌸 Jardín de flores: 4 + 4 = ¿?',
    content: 'Maceta rosa: 4 flores, Maceta amarilla: 4 flores',
    visual: 'flowers',
    firstNumber: 4,
    secondNumber: 4,
    options: ['7', '8', '9'],
    correct: '8'
  },
  {
    type: 'suma_mariposas',
    title: '🦋 Mariposas volando: 1 + 8 = ¿?',
    content: 'Grupo pequeño: 1 mariposa, Grupo grande: 8 mariposas',
    visual: 'butterflies',
    firstNumber: 1,
    secondNumber: 8,
    options: ['8', '9', '10'],
    correct: '9'
  }
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
  timerValue = 25;
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
  
  const contentDiv = document.createElement('div');
  contentDiv.className = 'question-description';
  contentDiv.textContent = q.content;
  contentDiv.style.cssText = `
    font-size: 1rem;
    text-align: center;
    margin: 10px 0;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    color: #495057;
  `;
  questionContent.appendChild(contentDiv);
  
  showVisualRepresentation(currentQuestionIndex);

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
    const gained = 120 + timerValue * 6;
    coins += gained;
    updateCoins();
    document.getElementById('coinChangeTextCorrect').textContent = `+${gained} monedas`;
    setTimeout(() => showModal('correctModal'), 800);
  } else {
    hearts--;
    coins = Math.max(0, coins - 250);
    updateCoins();
    document.getElementById('correctAnswerText').textContent = `La respuesta correcta es: ${q.correct}`;
    document.getElementById('coinChangeTextIncorrect').textContent = `-250 monedas`;
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
    localStorage.setItem('tema3SumaCompleted', 'true');
    localStorage.setItem('coins', coins);
    showCompletionModal();
  } else {
    updateProgress();
    showQuestion();
  }
}

function showModal(id) {
  document.getElementById(id).classList.add('show');
  if (id === 'correctModal') {
    triggerConfetti();
    setMotivationalText('correctModal', '¡Fantástico! ¡Dominas las sumas visuales!');
  } else if (id === 'incorrectModal') {
    setMotivationalText('incorrectModal', '¡Sigue practicando, cada intento te hace mejor!');
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
      particleCount: 100,
      spread: 120,
      origin: { y: 0.6 }
    });
  } else {
    document.body.style.background = "#d4edda";
    setTimeout(() => document.body.style.background = "", 400);
  }
}

function closeModal() {
  document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
  setTimeout(() => continueAfterModal(), 300);
}

function showCompletionModal() {
  document.getElementById('finalCoins').textContent = coins;
  document.getElementById('finalAccuracy').textContent = `${Math.round((correctAnswers / questions.length) * 100)}%`;
  localStorage.setItem('modulo2_tema3_terminado', 'true');
  localStorage.setItem('currentTopic_modulo2', 'tema4');
  localStorage.setItem('coins', coins);  
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
  window.location.href = "../tema4_suma_mental/leccion.php";
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
  let percent = (timerValue / 25) * 100;
  bar.style.width = percent + "%";

  bar.classList.remove('low', 'critical');
  if (timerValue <= 5) {
    bar.classList.add('critical');
  } else if (timerValue <= 12) {
    bar.classList.add('low');
  }

  barText.textContent = timerValue > 0 ? timerValue : "¡Tiempo!";

  if (timerValue === 5 && window.navigator && window.navigator.vibrate) {
    window.navigator.vibrate(150);
  }
}

function showVisualRepresentation(questionIndex) {
  const q = questions[questionIndex];
  const questionContent = document.getElementById('questionContent');
  
  const visualDiv = document.createElement('div');
  visualDiv.className = 'visual-representation';
  visualDiv.style.cssText = `
    font-size: 1.2rem;
    text-align: center;
    margin: 15px 0;
    padding: 20px;
    background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
    border-radius: 15px;
    border: 3px solid #2196f3;
    max-width: 95%;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  `;
  
  let visualContent = '';
  
  switch(q.visual) {
    case 'hands':
      visualContent = createHandsVisual(q.firstNumber, q.secondNumber);
      break;
    case 'dots':
      visualContent = createDotsVisual(q.firstNumber, q.secondNumber);
      break;
    case 'bars':
      visualContent = createBarsVisual(q.firstNumber, q.secondNumber);
      break;
    case 'shapes':
      visualContent = createShapesVisual(q.firstNumber, q.secondNumber, q.shape);
      break;
    case 'number_line':
      visualContent = createNumberLineVisual(q.firstNumber, q.secondNumber);
      break;
    case 'dice':
      visualContent = createDiceVisual(q.firstNumber, q.secondNumber);
      break;
    case 'boxes':
      visualContent = createBoxesVisual(q.firstNumber, q.secondNumber);
      break;
    case 'trees':
      visualContent = createTreesVisual(q.firstNumber, q.secondNumber);
      break;
    case 'stars':
      visualContent = createStarsVisual(q.firstNumber, q.secondNumber);
      break;
    case 'blocks':
      visualContent = createBlocksVisual(q.firstNumber, q.secondNumber);
      break;
    case 'flowers':
      visualContent = createFlowersVisual(q.firstNumber, q.secondNumber);
      break;
    case 'butterflies':
      visualContent = createButterfliesVisual(q.firstNumber, q.secondNumber);
      break;
  }
  
  visualDiv.innerHTML = visualContent;
  questionContent.appendChild(visualDiv);
}

function createHandsVisual(first, second) {
  const leftFingers = '👆'.repeat(Math.min(first, 5));
  const rightFingers = '👆'.repeat(Math.min(second, 5));
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      🤚 Cuenta con tus dedos 🤚
    </div>
    <div style="display: flex; justify-content: center; align-items: center; gap: 30px; margin: 20px 0;">
      <div style="text-align: center;">
        <div style="font-size: 2rem; margin-bottom: 8px;">${leftFingers}</div>
        <div style="font-size: 1rem; color: #666; font-weight: 600;">${first} dedo${first !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 2rem; color: #e91e63; font-weight: bold;">+</div>
      <div style="text-align: center;">
        <div style="font-size: 2rem; margin-bottom: 8px;">${rightFingers}</div>
        <div style="font-size: 1rem; color: #666; font-weight: 600;">${second} dedo${second !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 2rem; color: #e91e63; font-weight: bold;">=</div>
      <div style="font-size: 2rem; color: #4caf50; font-weight: bold;">?</div>
    </div>
  `;
}

function createDotsVisual(first, second) {
  const firstDots = '⚫'.repeat(first);
  const secondDots = '⚫'.repeat(second);
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      ⚫ Cuenta los puntos ⚫
    </div>
    <div style="display: flex; justify-content: center; align-items: center; gap: 20px; margin: 20px 0;">
      <div style="text-align: center; padding: 10px; background: #fff3e0; border-radius: 10px;">
        <div style="font-size: 1.5rem; margin-bottom: 5px;">${firstDots}</div>
        <div style="font-size: 0.9rem; color: #666;">${first} punto${first !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 1.8rem; color: #ff5722; font-weight: bold;">+</div>
      <div style="text-align: center; padding: 10px; background: #e8f5e8; border-radius: 10px;">
        <div style="font-size: 1.5rem; margin-bottom: 5px;">${secondDots}</div>
        <div style="font-size: 0.9rem; color: #666;">${second} punto${second !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 1.8rem; color: #ff5722; font-weight: bold;">=</div>
      <div style="font-size: 1.8rem; color: #4caf50; font-weight: bold;">?</div>
    </div>
  `;
}

function createBarsVisual(first, second) {
  const firstBar = '🟦'.repeat(first);
  const secondBar = '🟥'.repeat(second);
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      📊 Suma las barras de colores 📊
    </div>
    <div style="display: flex; flex-direction: column; gap: 15px; margin: 20px 0;">
      <div style="text-align: center;">
        <div style="font-size: 1.5rem; margin-bottom: 5px;">${firstBar}</div>
        <div style="font-size: 0.9rem; color: #1976d2; font-weight: 600;">Barra azul: ${first} unidad${first !== 1 ? 'es' : ''}</div>
      </div>
      <div style="text-align: center; font-size: 1.5rem; color: #e91e63; font-weight: bold;">+</div>
      <div style="text-align: center;">
        <div style="font-size: 1.5rem; margin-bottom: 5px;">${secondBar}</div>
        <div style="font-size: 0.9rem; color: #d32f2f; font-weight: 600;">Barra roja: ${second} unidad${second !== 1 ? 'es' : ''}</div>
      </div>
    </div>
  `;
}

function createShapesVisual(first, second, shape) {
  const firstShapes = shape.repeat(first);
  const secondShapes = shape.repeat(second);
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      ✨ Cuenta las formas ✨
    </div>
    <div style="display: flex; justify-content: center; align-items: center; gap: 25px; margin: 20px 0;">
      <div style="text-align: center; padding: 15px; background: #e1f5fe; border-radius: 12px; border: 2px dashed #0277bd;">
        <div style="font-size: 1.4rem; margin-bottom: 8px;">${firstShapes}</div>
        <div style="font-size: 0.9rem; color: #0277bd; font-weight: 600;">Grupo 1: ${first}</div>
      </div>
      <div style="font-size: 1.8rem; color: #e91e63; font-weight: bold;">+</div>
      <div style="text-align: center; padding: 15px; background: #f3e5f5; border-radius: 12px; border: 2px dashed #7b1fa2;">
        <div style="font-size: 1.4rem; margin-bottom: 8px;">${secondShapes}</div>
        <div style="font-size: 0.9rem; color: #7b1fa2; font-weight: 600;">Grupo 2: ${second}</div>
      </div>
      <div style="font-size: 1.8rem; color: #e91e63; font-weight: bold;">=</div>
      <div style="font-size: 1.8rem; color: #4caf50; font-weight: bold;">?</div>
    </div>
  `;
}

function createNumberLineVisual(first, second) {
  let line = '';
  for (let i = 0; i <= 10; i++) {
    if (i === first) {
      line += `<span style="background: #2196f3; color: white; padding: 5px 8px; border-radius: 50%; font-weight: bold;">${i}</span>`;
    } else if (i === first + second) {
      line += `<span style="background: #4caf50; color: white; padding: 5px 8px; border-radius: 50%; font-weight: bold;">${i}</span>`;
    } else {
      line += `<span style="padding: 5px 8px; border: 1px solid #ccc; border-radius: 50%;">${i}</span>`;
    }
    if (i < 10) line += ' ';
  }
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      📏 Usa la recta numérica 📏
    </div>
    <div style="display: flex; justify-content: center; margin: 20px 0;">
      <div style="font-size: 1rem;">${line}</div>
    </div>
    <div style="font-size: 0.9rem; color: #666; margin-top: 10px;">
      🔵 Empiezas en ${first} → Da ${second} salto${second !== 1 ? 's' : ''} → 🟢 Llegas a la respuesta
    </div>
  `;
}

function createDiceVisual(first, second) {
  const diceEmojis = ['', '⚀', '⚁', '⚂', '⚃', '⚄', '⚅'];
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      🎲 Suma los puntos de los dados 🎲
    </div>
    <div style="display: flex; justify-content: center; align-items: center; gap: 30px; margin: 20px 0;">
      <div style="text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 8px;">${diceEmojis[first] || '🎲'}</div>
        <div style="font-size: 1rem; color: #666; font-weight: 600;">${first} punto${first !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 2rem; color: #e91e63; font-weight: bold;">+</div>
      <div style="text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 8px;">${diceEmojis[second] || '🎲'}</div>
        <div style="font-size: 1rem; color: #666; font-weight: 600;">${second} punto${second !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 2rem; color: #e91e63; font-weight: bold;">=</div>
      <div style="font-size: 2rem; color: #4caf50; font-weight: bold;">?</div>
    </div>
  `;
}

function createBoxesVisual(first, second) {
  const firstBoxes = '📦'.repeat(first);
  const secondBoxes = '📦'.repeat(second);
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      📦 Cuenta las cajas 📦
    </div>
    <div style="display: flex; justify-content: center; align-items: center; gap: 25px; margin: 20px 0;">
      <div style="text-align: center; padding: 15px; background: #e3f2fd; border-radius: 12px;">
        <div style="color: #1976d2; font-weight: bold; margin-bottom: 5px;">Almacén Azul</div>
        <div style="font-size: 1.8rem; margin-bottom: 8px;">${firstBoxes}</div>
        <div style="font-size: 0.9rem; color: #1976d2; font-weight: 600;">${first} caja${first !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 1.8rem; color: #e91e63; font-weight: bold;">+</div>
      <div style="text-align: center; padding: 15px; background: #e8f5e8; border-radius: 12px;">
        <div style="color: #388e3c; font-weight: bold; margin-bottom: 5px;">Almacén Verde</div>
        <div style="font-size: 1.8rem; margin-bottom: 8px;">${secondBoxes}</div>
        <div style="font-size: 0.9rem; color: #388e3c; font-weight: 600;">${second} caja${second !== 1 ? 's' : ''}</div>
      </div>
      <div style="font-size: 1.8rem; color: #e91e63; font-weight: bold;">=</div>
      <div style="font-size: 1.8rem; color: #4caf50; font-weight: bold;">?</div>
    </div>
  `;
}

function createTreesVisual(first, second) {
  const firstTrees = '🌳'.repeat(first);
  const secondTrees = '🌳'.repeat(second);
  
  return `
    <div style="margin-bottom: 15px; font-weight: bold; color: #1976d2;">
      🌳 Bosque de árboles 🌳
    </div>
    <div style="display: flex; justify-content: center; align-items: center; gap: 25px; margin: 20px 0;">
      <div style="text-align: center; padding: 15px; background: #f1f8e9; border-radius: 12px; border: 2px solid #689f38;">
        <div style="color: #689f38; font-weight: bold; margin-bottom: 5px;">Bosque Izquierdo</div>
        <div style="font-size: 1.6rem; margin-bottom: 8px;">${firstTrees}</div>
        <div style="font-size: 0.9rem; color: #689f38; font-weight: 600;">${first} árbol${first !== 1 ? 'es' : ''}</div>
      </div>
      <div style="font-size: 1.8rem; color: #e91e63; font-weight: bold;">+</div>
      <div style="text-align: center; padding: 15px; background: #f1f8e9; border-radius: 12px; border: 2px solid #689f38;">
        <div style="color: #689f38; font-weight: bold; margin-bottom: 5px;">Bosque Derecho</div>
        <div style="font-size: 1.6rem; margin-bottom: 8px;">${secondTrees}</div>
        <div style="font-size: 0.9rem; color: #689f38; font-weight: 600;">${second} árbol${second !== 1 ? 'es' : ''}</div>
      </div>
      <div style="font-size: 1.8rem; color: #e91e63; font-weight: bold;">=</div>
      <div style="font-size: 1.8rem; color: #4caf50; font-weight: bold;">?</div>
    </div>
  `;
}