// modulo1.js (NUEVO ARCHIVO)
let currentQuestionIndex = 0;
let coins = 0;
let hearts = 3;
let correctAnswers = 0;
let selectedOption = null;

// Preguntas del Módulo 1: Números del 1 al 10
const questions = [
  // Reconocimiento de números y su escritura
  {
    type: 'number_recognition',
    title: '¿Cuál es este número?',
    content: '5',
    options: ['3', '5', '7', '2'],
    correct: '5'
  },
  {
    type: 'number_recognition',
    title: '¿Cuál es este número?',
    content: '8',
    options: ['6', '9', '8', '4'],
    correct: '8'
  },
  {
    type: 'number_recognition',
    title: '¿Cuál es este número?',
    content: '3',
    options: ['1', '3', '6', '8'],
    correct: '3'
  },
  
  // Conteo con objetos reales
  {
    type: 'object_counting',
    title: '¿Cuántos objetos hay?',
    content: 4, // número de objetos a mostrar
    options: ['3', '4', '5', '6'],
    correct: '4'
  },
  {
    type: 'object_counting',
    title: '¿Cuántos objetos hay?',
    content: 7,
    options: ['6', '7', '8', '5'],
    correct: '7'
  },
  {
    type: 'object_counting',
    title: '¿Cuántos objetos hay?',
    content: 2,
    options: ['1', '2', '3', '4'],
    correct: '2'
  },
  
  // Asociación número-cantidad
  {
    type: 'number_to_objects',
    title: '¿Cuál grupo tiene 6 objetos?',
    content: 6,
    options: [
      { text: 'Grupo A', objects: 5 },
      { text: 'Grupo B', objects: 6 },
      { text: 'Grupo C', objects: 7 },
      { text: 'Grupo D', objects: 4 }
    ],
    correct: 'Grupo B'
  },
  {
    type: 'objects_to_number',
    title: '¿Qué número representa esta cantidad?',
    content: 9, // mostrar 9 objetos
    options: ['8', '9', '10', '7'],
    correct: '9'
  },
  
  // Comparación: más, menos, igual
  {
    type: 'comparison',
    title: '¿Cuál número es MAYOR?',
    content: { num1: 4, num2: 7 },
    options: ['4', '7', 'Son iguales'],
    correct: '7'
  },
  {
    type: 'comparison',
    title: '¿Cuál número es MENOR?',
    content: { num1: 9, num2: 3 },
    options: ['9', '3', 'Son iguales'],
    correct: '3'
  }
];

// Inicializar la lección
function initLesson() {
  updateProgress();
  updateCoins();
  updateHearts();
  showQuestion();
}

// Mostrar pregunta actual
function showQuestion() {
  const question = questions[currentQuestionIndex];
  const questionTitle = document.getElementById('questionTitle');
  const questionContent = document.getElementById('questionContent');
  const questionOptions = document.getElementById('questionOptions');
  const btnContinue = document.getElementById('btnContinue');
  
  questionTitle.textContent = question.title;
  btnContinue.disabled = true;
  btnContinue.textContent = 'Continuar';
  selectedOption = null;
  
  // Limpiar contenido anterior
  questionContent.innerHTML = '';
  questionOptions.innerHTML = '';
  
  // Generar contenido según el tipo de pregunta
  switch(question.type) {
    case 'number_recognition':
      questionContent.innerHTML = `<div class="number-display">${question.content}</div>`;
      break;
      
    case 'object_counting':
    case 'objects_to_number':
      const objectsHtml = generateObjects(question.content);
      questionContent.innerHTML = `<div class="objects-container">${objectsHtml}</div>`;
      break;
      
    case 'number_to_objects':
      questionContent.innerHTML = `<div class="number-display">${question.content}</div>`;
      break;
      
    case 'comparison':
      questionContent.innerHTML = `
        <div style="display: flex; justify-content: center; gap: 2rem; align-items: center;">
          <div class="number-display" style="font-size: 4rem;">${question.content.num1}</div>
          <div style="font-size: 2rem; color: #666;">vs</div>
          <div class="number-display" style="font-size: 4rem;">${question.content.num2}</div>
        </div>
      `;
      break;
  }
  
  // Generar opciones
  question.options.forEach((option, index) => {
    const optionBtn = document.createElement('button');
    optionBtn.className = 'option-btn';
    optionBtn.onclick = () => selectOption(optionBtn, option);
    
    if (question.type === 'number_to_objects' && typeof option === 'object') {
      optionBtn.innerHTML = `
        <div>${option.text}</div>
        <div class="objects-container" style="margin-top: 0.5rem;">
          ${generateObjects(option.objects, 'small')}
        </div>
      `;
      optionBtn.setAttribute('data-value', option.text);
    } else {
      optionBtn.textContent = typeof option === 'object' ? option.text : option;
      optionBtn.setAttribute('data-value', typeof option === 'object' ? option.text : option);
    }
    
    questionOptions.appendChild(optionBtn);
  });
}

// Generar objetos visuales
function generateObjects(count, size = 'normal') {
  const objects = ['🔴', '🟢', '🔵', '🟡', '🟣', '🟠'];
  let html = '';
  
  for (let i = 0; i < count; i++) {
    const emoji = objects[i % objects.length];
    const sizeClass = size === 'small' ? 'width: 30px; height: 30px; font-size: 1rem;' : '';
    html += `<div class="object-item" style="${sizeClass}">${emoji}</div>`;
  }
  
  return html;
}

// Seleccionar opción
function selectOption(button, value) {
  // Remover selección anterior
  document.querySelectorAll('.option-btn').forEach(btn => {
    btn.classList.remove('selected');
  });
  
  // Seleccionar nueva opción
  button.classList.add('selected');
  selectedOption = typeof value === 'object' ? value.text : value;
  
  // Habilitar botón continuar
  document.getElementById('btnContinue').disabled = false;
}

// Siguiente pregunta
function nextQuestion() {
  if (selectedOption === null) return;
  
  const question = questions[currentQuestionIndex];
  const isCorrect = selectedOption === question.correct;
  
  // Mostrar retroalimentación visual
  showAnswerFeedback(isCorrect);
  
  if (isCorrect) {
    correctAnswers++;
    coins += 100;
    updateCoins();
    setTimeout(() => {
      showModal('correctModal');
    }, 1000);
  } else {
    hearts--;
    updateHearts();
    document.getElementById('correctAnswerText').textContent = `La respuesta correcta es: ${question.correct}`;
    setTimeout(() => {
      showModal('incorrectModal');
    }, 1000);
  }
}

// Mostrar retroalimentación visual en las opciones
function showAnswerFeedback(isCorrect) {
  const question = questions[currentQuestionIndex];
  
  document.querySelectorAll('.option-btn').forEach(btn => {
    const btnValue = btn.getAttribute('data-value');
    
    if (btnValue === question.correct) {
      btn.classList.add('correct');
    } else if (btnValue === selectedOption && !isCorrect) {
      btn.classList.add('incorrect');
    }
    
    btn.disabled = true;
  });
  
  document.getElementById('btnContinue').disabled = true;
}

// Continuar después del modal
function continueAfterModal() {
  currentQuestionIndex++;
  
  if (currentQuestionIndex >= questions.length) {
    // Lección completada
    showCompletionModal();
  } else if (hearts <= 0) {
    // Game over
    showGameOverModal();
  } else {
    // Siguiente pregunta
    updateProgress();
    showQuestion();
  }
}

// Mostrar modal
function showModal(modalId) {
  document.getElementById(modalId).classList.add('show');
}

// Cerrar modal
function closeModal() {
  document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.classList.remove('show');
  });
  
  setTimeout(() => {
    continueAfterModal();
  }, 300);
}

// Mostrar modal de lección completada
function showCompletionModal() {
  const accuracy = Math.round((correctAnswers / questions.length) * 100);
  document.getElementById('finalCoins').textContent = coins;
  document.getElementById('finalAccuracy').textContent = accuracy + '%';
  showModal('completedModal');
}

// Reiniciar lección
function restartLesson() {
  currentQuestionIndex = 0;
  coins = 0;
  hearts = 3;
  correctAnswers = 0;
  selectedOption = null;
  
  closeModal();
  setTimeout(() => {
    initLesson();
  }, 300);
}

// Actualizar progreso
function updateProgress() {
  const progress = ((currentQuestionIndex + 1) / questions.length) * 100;
  document.getElementById('progressFill').style.width = progress + '%';
  document.getElementById('progressText').textContent = `${currentQuestionIndex + 1}/${questions.length}`;
}

// Actualizar monedas
function updateCoins() {
  document.getElementById('coinsCount').textContent = coins;
}

// Actualizar corazones
function updateHearts() {
  for (let i = 1; i <= 3; i++) {
    const heart = document.getElementById(`heart${i}`);
    if (i > hearts) {
      heart.classList.add('lost');
    } else {
      heart.classList.remove('lost');
    }
  }
}

// Efectos de sonido (opcional)
function playSound(type) {
  // Aquí puedes agregar efectos de sonido
  // const audio = new Audio(`sounds/${type}.mp3`);
  // audio.play();
}

// Animaciones de monedas
function animateCoins() {
  const coinsDisplay = document.querySelector('.coins-count');
  coinsDisplay.style.transform = 'scale(1.2)';
  coinsDisplay.style.color = '#28a745';
  
  setTimeout(() => {
    coinsDisplay.style.transform = 'scale(1)';
    coinsDisplay.style.color = '#fff';
  }, 500);
}

// Inicializar cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
  initLesson();
});

// Prevenir cierre accidental
window.addEventListener('beforeunload', function(e) {
  if (currentQuestionIndex > 0 && currentQuestionIndex < questions.length) {
    e.preventDefault();
    e.returnValue = '¿Estás seguro de que quieres salir? Perderás tu progreso.';
  }
});
