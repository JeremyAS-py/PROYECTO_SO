<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programación Visual - Tema 1</title>
  <script src="https://unpkg.com/blockly/blockly.min.js"></script>
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      margin: 0;
      display: flex;
      flex-direction: row;
      height: 100vh;
      background: #f8f9fa;
    }
    #blocklyDiv {
      height: 100%;
      width: 65%;
      border-right: 2px solid #e0e0e0;
    }
    #output {
      width: 35%;
      padding: 1.5rem;
      background: #f0f2f5;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      box-shadow: inset 2px 0 4px rgba(0,0,0,0.1);
    }
    h3 {
      margin: 0 0 1rem 0;
      color: #333;
      font-size: 1.4rem;
      text-align: center;
    }
    #arena {
      width: 280px;
      height: 280px;
      background: #ffffff;
      border: 3px solid #333;
      border-radius: 8px;
      position: relative;
      margin: 1rem 0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      background-image: 
        linear-gradient(rgba(0,0,0,0.3) 2px, transparent 2px),
        linear-gradient(90deg, rgba(0,0,0,0.3) 2px, transparent 2px);
      background-size: 40px 40px;
    }
    #robot {
      width: 35px;
      height: 35px;
      background: linear-gradient(135deg, #ff9800, #f57c00);
      position: absolute;
      border-radius: 8px;
      transition: all 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 15px rgba(255, 152, 0, 0.6);
      border: 3px solid #fff;
      z-index: 10;
    }
    #robot::before {
      content: '🤖';
      font-size: 20px;
      transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      display: block;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }
    
    @keyframes robotMove {
      0% { transform: scale(1); }
      50% { transform: scale(1.1); }
      100% { transform: scale(1); }
    }
    
    .robot-moving {
      animation: robotMove 0.6s ease-in-out;
    }
    .button-container {
      display: flex;
      gap: 0.5rem;
      margin-top: 1rem;
    }
    button {
      padding: 0.7rem 1.2rem;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    #runBtn {
      background: linear-gradient(135deg, #4CAF50, #45a049);
      color: white;
    }
    #resetBtn {
      background: linear-gradient(135deg, #ff9800, #e68900);
      color: white;
    }
    #stopBtn {
      background: linear-gradient(135deg, #f44336, #d32f2f);
      color: white;
    }
    .status {
      margin-top: 1rem;
      padding: 0.5rem 1rem;
      border-radius: 4px;
      font-size: 0.9rem;
      font-weight: 500;
      text-align: center;
      min-height: 20px;
    }
    .status.ready { background: #e8f5e8; color: #2e7d32; border: 1px solid #c8e6c9; }
    .status.running { background: #fff3e0; color: #ef6c00; border: 1px solid #ffcc02; }
    .status.error { background: #ffebee; color: #c62828; border: 1px solid #ef5350; }
    
    .debug-info {
      margin-top: 1rem;
      padding: 0.5rem;
      background: #f5f5f5;
      border-radius: 4px;
      font-size: 0.8rem;
      font-family: monospace;
      text-align: center;
      color: #666;
    }
  </style>
</head>
<body>
  <div id="blocklyDiv"></div>
  <div id="output">
    <h3>🤖 Mi Robot Naranja</h3>
    <div id="arena">
      <div id="robot"></div>
    </div>
    <div class="button-container">
      <button id="runBtn" onclick="runCode()">▶ Ejecutar</button>
      <button id="resetBtn" onclick="resetRobot()">🔄 Reiniciar</button>
      <button id="stopBtn" onclick="stopExecution()" disabled>⏹ Detener</button>
    </div>
    <div id="status" class="status ready">Listo para programar</div>
    <div id="debug" class="debug-info">Pos: (3,3) | Dir: Norte</div>
  </div>

  <script>
    // === DEFINICIÓN DE BLOQUES ===
    Blockly.defineBlocksWithJsonArray([
      {
        type: "move_forward",
        message0: "avanzar",
        previousStatement: null,
        nextStatement: null,
        colour: 120,
        tooltip: "Mueve el robot hacia adelante"
      },
      {
        type: "turn_left",
        message0: "gira a la izquierda",
        previousStatement: null,
        nextStatement: null,
        colour: 100,
        tooltip: "Gira el robot 90° a la izquierda"
      },
      {
        type: "turn_right",
        message0: "gira a la derecha",
        previousStatement: null,
        nextStatement: null,
        colour: 20,
        tooltip: "Gira el robot 90° a la derecha"
      }
    ]);

    // === GENERADORES DE CÓDIGO JAVASCRIPT ===
    const javascriptGenerator = new Blockly.Generator('JavaScript');

    // Configurar orden de precedencia
    javascriptGenerator.ORDER_NONE = 0;

    javascriptGenerator.forBlock['move_forward'] = function(block, generator) {
      return 'moveForward();\n';
    };

    javascriptGenerator.forBlock['turn_left'] = function(block, generator) {
      return 'turnLeft();\n';
    };

    javascriptGenerator.forBlock['turn_right'] = function(block, generator) {
      return 'turnRight();\n';
    };

    // Sobrescribir el método para generar código de bloques conectados
    javascriptGenerator.scrub_ = function(block, code, thisOnly) {
      const nextBlock = block.nextConnection && block.nextConnection.targetBlock();
      if (nextBlock && !thisOnly) {
        return code + javascriptGenerator.blockToCode(nextBlock);
      }
      return code;
    };

    // === CONFIGURACIÓN DEL TOOLBOX ===
    const toolbox = {
      kind: 'categoryToolbox',
      contents: [
        {
          kind: 'category',
          name: '🚀 Movimiento',
          colour: '120',
          contents: [
            { kind: 'block', type: 'move_forward' },
            { kind: 'block', type: 'turn_left' },
            { kind: 'block', type: 'turn_right' }
          ]
        }
      ]
    };

    // === INYECTAR WORKSPACE ===
    const workspace = Blockly.inject('blocklyDiv', {
      toolbox: toolbox,
      scrollbars: true,
      trashcan: true,
      grid: {
        spacing: 20,
        length: 3,
        colour: '#ccc',
        snap: true
      },
      zoom: {
        controls: true,
        wheel: true,
        startScale: 1.0,
        maxScale: 3,
        minScale: 0.3,
        scaleSpeed: 1.2
      }
    });

    // === VARIABLES DEL ROBOT ===
    let x = 3, y = 3, direction = 0, isExecuting = false;
    const robot = document.getElementById('robot');
    const statusElement = document.getElementById('status');
    const debugElement = document.getElementById('debug');
    const runBtn = document.getElementById('runBtn');
    const stopBtn = document.getElementById('stopBtn');

    // Nombres de direcciones para debug
    const directionNames = ['Norte', 'Este', 'Sur', 'Oeste'];

    // === FUNCIONES DEL ROBOT ===
    function updateRobotPosition() {
      // CORRECCIÓN: Calcular posición correctamente
      // El arena es 280px con grid de 40px, tenemos 7x7 celdas (0-6)
      // Centrar el robot en cada celda: posición de celda * 40 + (40-35)/2 para centrar el robot de 35px
      const visualX = x * 40 + 2.5; // 2.5px para centrar robot de 35px en celda de 40px
      const visualY = y * 40 + 2.5;
      
      console.log(`📍 ACTUALIZANDO POSICIÓN:`);
      console.log(`   Lógica: (${x}, ${y}) → Visual: (${visualX}px, ${visualY}px)`);
      
      // Aplicar animación
      robot.classList.add('robot-moving');
      setTimeout(() => robot.classList.remove('robot-moving'), 600);
      
      // Actualizar posición visual
      robot.style.left = `${visualX}px`;
      robot.style.top = `${visualY}px`;
      
      // Rotación visual según dirección
      const rotationDegrees = direction * 90;
      robot.style.transform = `rotate(${rotationDegrees}deg)`;
      
      // Actualizar debug info
      debugElement.textContent = `Pos: (${x},${y}) | Dir: ${directionNames[direction]} (${rotationDegrees}°)`;
    }

    function moveForward() {
      console.log(`🚀 MOVIMIENTO:`);
      console.log(`   Desde: (${x}, ${y}), Dirección: ${directionNames[direction]} (${direction})`);
      
      const oldX = x, oldY = y;
      let moved = false;
      
      // Movimiento según dirección (0=Norte, 1=Este, 2=Sur, 3=Oeste)
      // Arena 7x7: coordenadas válidas 0-6
      switch(direction) {
        case 0: // Norte - y decrece
          if (y > 0) {
            y--;
            moved = true;
          }
          break;
        case 1: // Este - x aumenta  
          if (x < 6) {
            x++;
            moved = true;
          }
          break;
        case 2: // Sur - y aumenta
          if (y < 6) {
            y++;
            moved = true;
          }
          break;
        case 3: // Oeste - x decrece
          if (x > 0) {
            x--;  
            moved = true;
          }
          break;
      }
      
      if (moved) {
        console.log(`✅ Movió de (${oldX},${oldY}) → (${x},${y})`);
        updateRobotPosition();
      } else {
        console.log(`❌ Bloqueado en límite del arena`);
        statusElement.textContent = "¡No se puede avanzar más!";
        statusElement.className = "status error";
        setTimeout(() => {
          if (!isExecuting) {
            statusElement.textContent = "Listo para programar";
            statusElement.className = "status ready";
          }
        }, 1500);
      }
    }

    function turnLeft() {
      const oldDir = direction;
      direction = (direction + 3) % 4; // -90° = +270°
      console.log(`🔄 GIRO IZQUIERDA: ${directionNames[oldDir]} → ${directionNames[direction]}`);
      updateRobotPosition();
    }

    function turnRight() {
      const oldDir = direction;
      direction = (direction + 1) % 4; // +90°
      console.log(`🔄 GIRO DERECHA: ${directionNames[oldDir]} → ${directionNames[direction]}`);
      updateRobotPosition();
    }

    // === FUNCIONES DE CONTROL ===
    function runCode() {
      if (isExecuting) return;
      
      // Generar código de TODOS los bloques en el workspace
      let code = '';
      const topBlocks = workspace.getTopBlocks(true);
      
      for (let i = 0; i < topBlocks.length; i++) {
        const blockCode = javascriptGenerator.blockToCode(topBlocks[i]);
        if (blockCode) {
          code += blockCode;
        }
      }
      
      console.log(`🎬 CÓDIGO GENERADO COMPLETO:\n${code}`);
      
      if (!code.trim()) {
        statusElement.textContent = "No hay bloques para ejecutar";
        statusElement.className = "status error";
        return;
      }

      isExecuting = true;
      runBtn.disabled = true;
      stopBtn.disabled = false;
      statusElement.textContent = "Ejecutando...";
      statusElement.className = "status running";

      const commands = code.trim().split('\n').filter(line => line.trim());
      let commandIndex = 0;
      
      console.log(`📋 COMANDOS A EJECUTAR (${commands.length}):`);
      commands.forEach((cmd, i) => console.log(`   ${i+1}. ${cmd.trim()}`));
      
      function executeNextCommand() {
        if (!isExecuting || commandIndex >= commands.length) {
          // Ejecución completada
          isExecuting = false;
          runBtn.disabled = false;
          stopBtn.disabled = true;
          statusElement.textContent = "Ejecución completada";
          statusElement.className = "status ready";
          console.log(`🏁 EJECUCIÓN COMPLETADA - Posición final: (${x}, ${y})`);
          return;
        }
        
        try {
          const command = commands[commandIndex].trim();
          console.log(`\n🔸 EJECUTANDO PASO ${commandIndex + 1}/${commands.length}: ${command}`);
          eval(command);
          commandIndex++;
          setTimeout(executeNextCommand, 1500); // Pausa entre comandos
        } catch (error) {
          console.error('❌ ERROR:', error);
          isExecuting = false;
          runBtn.disabled = false;
          stopBtn.disabled = true;
          statusElement.textContent = "Error en ejecución";
          statusElement.className = "status error";
        }
      }
      
      executeNextCommand();
    }

    function resetRobot() {
      console.log(`🔄 REINICIO COMPLETO`);
      isExecuting = false;
      x = 3;
      y = 3; 
      direction = 0;
      updateRobotPosition();
      statusElement.textContent = "Listo para programar";
      statusElement.className = "status ready";
      runBtn.disabled = false;
      stopBtn.disabled = true;
      console.log(`✅ Robot reiniciado: (${x}, ${y}), ${directionNames[direction]}`);
    }

    function stopExecution() {
      console.log(`⏹ EJECUCIÓN DETENIDA`);
      isExecuting = false;
      runBtn.disabled = false;
      stopBtn.disabled = true;
      statusElement.textContent = "Ejecución detenida";
      statusElement.className = "status ready";
    }

    // === INICIALIZACIÓN ===
    window.addEventListener('load', () => {
      console.log(`🚀 INICIALIZACIÓN`);
      resetRobot();
      
      // Cargar bloques de ejemplo
      const xmlText = `<xml xmlns="https://developers.google.com/blockly/xml">
        <block type="move_forward" x="50" y="50">
          <next>
            <block type="move_forward">
              <next>
                <block type="turn_left">
                  <next>
                    <block type="move_forward"></block>
                  </next>
                </block>
              </next>
            </block>
          </next>
        </block>
      </xml>`;
      
      try {
        const xmlDom = Blockly.utils.xml.textToDom(xmlText);
        Blockly.Xml.domToWorkspace(xmlDom, workspace);
        console.log(`✅ Bloques de ejemplo cargados: avanzar → avanzar → girar izquierda → avanzar`);
      } catch (error) {
        console.error('❌ Error cargando bloques:', error);
      }
    });
  </script>
</body>
</html>