/* ============================================================
   NexaBlog — Premium 3D Scroll Scene (Three.js + GSAP ScrollTrigger)
   Immersive digital grid landscape, galaxy dust, and floating core
   ============================================================ */

(function () {
  'use strict';

  const canvas = document.getElementById('hero-canvas');
  if (!canvas) return;

  // Register GSAP ScrollTrigger plugin if available
  if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);
  }

  // Scene setup
  const scene = new THREE.Scene();
  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.setClearColor(0x000000, 0);

  let W = window.innerWidth;
  let H = window.innerHeight;
  renderer.setSize(W, H);

  // Camera settings
  const camera = new THREE.PerspectiveCamera(60, W / H, 0.1, 1000);
  camera.position.set(0, 5, 25);
  const lookTarget = new THREE.Vector3(0, 0, 0);

  // ── Theme Configs ─────────────────────────────────────────

  function getThemeColors() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    return {
      gridPrimary: isDark ? new THREE.Color(0x818cf8) : new THREE.Color(0x4f46e5), // Indigo
      gridSecondary: isDark ? new THREE.Color(0xec4899) : new THREE.Color(0xdb2777), // Pink Accent
      dust: isDark ? new THREE.Color(0xa5b4fc) : new THREE.Color(0x6366f1),
      core: isDark ? new THREE.Color(0xf43f5e) : new THREE.Color(0xe11d48), // Rose
      coreWire: isDark ? 0x818cf8 : 0x4f46e5
    };
  }

  let colors = getThemeColors();

  // ── Objects Creation ──────────────────────────────────────

  // 1. Digital Topography Grid (Particle Wave Grid)
  const GRID_ROWS = 65;
  const GRID_COLS = 65;
  const GRID_PARTICLE_COUNT = GRID_ROWS * GRID_COLS;
  const gridPositions = new Float32Array(GRID_PARTICLE_COUNT * 3);
  const gridColors = new Float32Array(GRID_PARTICLE_COUNT * 3);

  const gridGeo = new THREE.BufferGeometry();
  const spaceX = 1.3;
  const spaceZ = 1.3;
  const startX = -((GRID_COLS - 1) * spaceX) / 2;
  const startZ = -((GRID_ROWS - 1) * spaceZ) / 2;

  let idx = 0;
  for (let r = 0; r < GRID_ROWS; r++) {
    for (let c = 0; c < GRID_COLS; c++) {
      // Position
      gridPositions[idx * 3] = startX + c * spaceX;
      gridPositions[idx * 3 + 1] = 0; // Y will be animated in loop
      gridPositions[idx * 3 + 2] = startZ + r * spaceZ;

      // Color (Gradient pattern)
      const ratio = c / GRID_COLS;
      const mixedColor = colors.gridPrimary.clone().lerp(colors.gridSecondary, ratio);
      gridColors[idx * 3] = mixedColor.r;
      gridColors[idx * 3 + 1] = mixedColor.g;
      gridColors[idx * 3 + 2] = mixedColor.b;

      idx++;
    }
  }

  gridGeo.setAttribute('position', new THREE.BufferAttribute(gridPositions, 3));
  gridGeo.setAttribute('color', new THREE.BufferAttribute(gridColors, 3));

  // Premium particle material with round texture simulated via CSS-like alpha fading
  const particleSize = W < 768 ? 0.15 : 0.22;
  const gridMat = new THREE.PointsMaterial({
    size: particleSize,
    vertexColors: true,
    transparent: true,
    opacity: 0.65,
    sizeAttenuation: true,
    blending: THREE.AdditiveBlending,
    depthWrite: false,
  });

  const gridPoints = new THREE.Points(gridGeo, gridMat);
  gridPoints.position.y = -8;
  scene.add(gridPoints);

  // 2. Cosmic Nebula Galaxy Dust (Drifting Space Particles)
  const DUST_COUNT = 1500;
  const dustPositions = new Float32Array(DUST_COUNT * 3);
  const dustSpeeds = new Float32Array(DUST_COUNT);
  const dustOffsets = new Float32Array(DUST_COUNT);

  for (let i = 0; i < DUST_COUNT; i++) {
    dustPositions[i * 3] = (Math.random() - 0.5) * 100;
    dustPositions[i * 3 + 1] = (Math.random() - 0.5) * 80;
    dustPositions[i * 3 + 2] = (Math.random() - 0.5) * 60;
    dustSpeeds[i] = 0.1 + Math.random() * 0.4;
    dustOffsets[i] = Math.random() * Math.PI * 2;
  }

  const dustGeo = new THREE.BufferGeometry();
  dustGeo.setAttribute('position', new THREE.BufferAttribute(dustPositions, 3));

  const dustMat = new THREE.PointsMaterial({
    color: colors.dust,
    size: 0.12,
    transparent: true,
    opacity: 0.45,
    sizeAttenuation: true,
    blending: THREE.AdditiveBlending,
    depthWrite: false
  });

  const dustPoints = new THREE.Points(dustGeo, dustMat);
  scene.add(dustPoints);

  // 3. Central Core of Ideation (Abstract Glass/Wireframe Dodecahedron)
  const coreGroup = new THREE.Group();
  coreGroup.position.set(0, 2, 0);
  scene.add(coreGroup);

  const coreGeometry = new THREE.DodecahedronGeometry(3.5, 1);
  const coreWireframeMat = new THREE.MeshBasicMaterial({
    color: colors.coreWire,
    wireframe: true,
    transparent: true,
    opacity: 0.25
  });
  const coreWireframe = new THREE.Mesh(coreGeometry, coreWireframeMat);
  coreGroup.add(coreWireframe);

  const coreInnerGeo = new THREE.IcosahedronGeometry(2.0, 0);
  const coreInnerMat = new THREE.MeshBasicMaterial({
    color: colors.core,
    transparent: true,
    opacity: 0.18,
    wireframe: false
  });
  const coreInner = new THREE.Mesh(coreInnerGeo, coreInnerMat);
  coreGroup.add(coreInner);

  // Floating peripheral nodes
  const nodes = [];
  const nodeCount = 5;
  for (let i = 0; i < nodeCount; i++) {
    const nodeGeo = new THREE.OctahedronGeometry(0.5, 0);
    const nodeMat = new THREE.MeshBasicMaterial({
      color: colors.gridSecondary,
      wireframe: true,
      transparent: true,
      opacity: 0.6
    });
    const node = new THREE.Mesh(nodeGeo, nodeMat);
    const angle = (i / nodeCount) * Math.PI * 2;
    node.position.set(Math.cos(angle) * 6, Math.sin(angle) * 2, Math.sin(angle) * 6);
    node._angle = angle;
    node._speed = 0.5 + Math.random() * 0.5;
    coreGroup.add(node);
    nodes.push(node);
  }

  // ── Scroll Animation Values (controlled by GSAP) ───────────

  const animState = {
    cameraX: 0,
    cameraY: 4,
    cameraZ: 24,
    lookX: 0,
    lookY: 1,
    lookZ: 0,
    waveAmplitude: 1.0,
    waveSpeed: 0.8,
    gridRotationY: 0,
    gridY: -8,
    coreScale: 1.0,
    coreY: 2,
    coreOpacity: 0.8,
    warpFactor: 0.05
  };

  // Setup GSAP Timeline linked to scroll
  if (typeof gsap !== 'undefined' && gsap.timeline) {
    const mainTimeline = gsap.timeline({
      scrollTrigger: {
        trigger: 'body',
        start: 'top top',
        end: 'bottom bottom',
        scrub: 1.2, // Smooth follow delay
      }
    });

    // 1. Transition to Featured Section (Scroll progress ~20%)
    mainTimeline.to(animState, {
      cameraX: 8, // Shift right to place 3D scene behind text
      cameraY: 0,
      cameraZ: 18,
      lookX: 4,   // Shift focal point to screen right
      lookY: -1,
      waveAmplitude: 1.4,
      gridY: -6,
      coreScale: 0.8,
      duration: 1
    });

    // 2. Transition to Features Section (Scroll progress ~40%)
    mainTimeline.to(animState, {
      cameraX: -8, // Shift left (Features text is on the right/grid)
      cameraY: 8,
      cameraZ: 20,
      lookX: -4,
      lookY: 1,
      waveAmplitude: 2.0,
      waveSpeed: 1.5,
      gridY: -9,
      coreScale: 1.4,
      coreY: 4,
      warpFactor: 0.15, // Faster drift
      duration: 1
    });

    // 3. Transition to Latest Posts Section (Scroll progress ~60%)
    mainTimeline.to(animState, {
      cameraX: 0,
      cameraY: -6, // Camera goes low, looking up
      cameraZ: 16,
      lookX: 0,
      lookY: 2,
      waveAmplitude: 0.8,
      waveSpeed: 0.6,
      gridY: -4,
      coreScale: 0.5,
      coreOpacity: 0.2, // Fade out core
      warpFactor: 0.03,
      duration: 1
    });

    // 4. Transition to Stats Section (Scroll progress ~80%)
    mainTimeline.to(animState, {
      cameraX: 0,
      cameraY: 22, // Pull up to bird's eye view
      cameraZ: 28,
      lookX: 0,
      lookY: -2,
      gridRotationY: Math.PI * 0.5, // Rotate grid
      waveAmplitude: 2.5, // High landscape mountains
      waveSpeed: 1.0,
      gridY: -12,
      coreScale: 1.2,
      coreOpacity: 0.9,
      warpFactor: 0.08,
      duration: 1
    });

    // 5. Transition to Categories & CTA (Scroll progress 100%)
    mainTimeline.to(animState, {
      cameraX: 0,
      cameraY: 4,
      cameraZ: 25,
      lookX: 0,
      lookY: 0,
      gridRotationY: Math.PI * 1.0,
      waveAmplitude: 1.2,
      waveSpeed: 0.8,
      gridY: -7,
      coreScale: 1.0,
      coreOpacity: 0.8,
      warpFactor: 0.05,
      duration: 1
    });
  }

  // ── Mouse Interaction (Parallax) ──────────────────────────

  let mouseX = 0, mouseY = 0;
  let targetMouseX = 0, targetMouseY = 0;

  document.addEventListener('mousemove', (e) => {
    targetMouseX = (e.clientX / window.innerWidth - 0.5) * 2;
    targetMouseY = (e.clientY / window.innerHeight - 0.5) * 2;
  }, { passive: true });

  // ── Scroll Velocity Tracking ──────────────────────────────

  let lastScrollY = window.scrollY;
  let scrollSpeed = 0;
  let targetScrollSpeed = 0;

  window.addEventListener('scroll', () => {
    const currentScrollY = window.scrollY;
    const delta = Math.abs(currentScrollY - lastScrollY);
    targetScrollSpeed = Math.min(delta * 0.12, 10.0); // Cap scroll speed
    lastScrollY = currentScrollY;
  }, { passive: true });


  // ── Theme Update Listeners ─────────────────────────────────

  let lastTheme = document.documentElement.getAttribute('data-theme');

  function checkThemeUpdate() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    if (currentTheme !== lastTheme) {
      colors = getThemeColors();

      // Smoothly transition colors using GSAP
      if (typeof gsap !== 'undefined') {
        // Grid colors transition
        const gridPosAttr = gridPoints.geometry.attributes.position;
        const colorAttr = gridPoints.geometry.attributes.color;

        for (let i = 0; i < GRID_PARTICLE_COUNT; i++) {
          const ratio = (i % GRID_COLS) / GRID_COLS;
          const targetColor = colors.gridPrimary.clone().lerp(colors.gridSecondary, ratio);
          
          gsap.to(colorAttr.array, {
            [i * 3]: targetColor.r,
            [i * 3 + 1]: targetColor.g,
            [i * 3 + 2]: targetColor.b,
            duration: 0.8,
            overwrite: 'auto'
          });
        }
        setTimeout(() => { colorAttr.needsUpdate = true; }, 850);

        // Core colors transition
        gsap.to(coreWireframe.material.color, { r: colors.gridPrimary.r, g: colors.gridPrimary.g, b: colors.gridPrimary.b, duration: 0.8 });
        gsap.to(coreInner.material.color, { r: colors.core.r, g: colors.core.g, b: colors.core.b, duration: 0.8 });
        gsap.to(dustPoints.material.color, { r: colors.dust.r, g: colors.dust.g, b: colors.dust.b, duration: 0.8 });
      } else {
        // Fallback immediate update
        const colorAttr = gridPoints.geometry.attributes.color;
        for (let i = 0; i < GRID_PARTICLE_COUNT; i++) {
          const ratio = (i % GRID_COLS) / GRID_COLS;
          const targetColor = colors.gridPrimary.clone().lerp(colors.gridSecondary, ratio);
          colorAttr.array[i * 3] = targetColor.r;
          colorAttr.array[i * 3 + 1] = targetColor.g;
          colorAttr.array[i * 3 + 2] = targetColor.b;
        }
        colorAttr.needsUpdate = true;
        coreWireframe.material.color.copy(colors.gridPrimary);
        coreInner.material.color.copy(colors.core);
        dustPoints.material.color.copy(colors.dust);
      }

      lastTheme = currentTheme;
    }
  }

  // ── Animation Loop ────────────────────────────────────────

  const clock = new THREE.Clock();

  function animate() {
    requestAnimationFrame(animate);
    const elapsed = clock.getElapsedTime();

    // Check if theme switched
    checkThemeUpdate();

    // Smooth mouse parallax lerp
    mouseX += (targetMouseX - mouseX) * 0.04;
    mouseY += (targetMouseY - mouseY) * 0.04;

    // Smooth scroll speed tracking
    scrollSpeed += (targetScrollSpeed - scrollSpeed) * 0.08;
    targetScrollSpeed *= 0.92; // decay

    // Apply camera position from GSAP + Mouse parallax
    camera.position.x = animState.cameraX + mouseX * 3.5;
    camera.position.y = animState.cameraY - mouseY * 2.5;
    camera.position.z = animState.cameraZ;

    // Apply look-at target from GSAP + Mouse parallax offset
    lookTarget.set(
      animState.lookX + mouseX * 1.5,
      animState.lookY - mouseY * 1.0,
      animState.lookZ
    );
    camera.lookAt(lookTarget);

    // Dynamic wave metrics
    const dynamicAmplitude = animState.waveAmplitude + (scrollSpeed * 0.35);
    const dynamicSpeed = elapsed * (animState.waveSpeed + scrollSpeed * 0.15);

    // 1. Animate Wave Grid heights (Y position) + Warp Speed Z-Stretch
    const positionAttr = gridPoints.geometry.attributes.position;
    idx = 0;

    for (let r = 0; r < GRID_ROWS; r++) {
      for (let c = 0; c < GRID_COLS; c++) {
        // Read from initial positions array to avoid accumulative stretch
        const origX = gridPositions[idx * 3];
        const origZ = gridPositions[idx * 3 + 2];

        // Undulating wave algorithm
        const y = Math.sin(origX * 0.12 + dynamicSpeed) * dynamicAmplitude * 0.8 +
                  Math.cos(origZ * 0.14 + dynamicSpeed * 0.8) * dynamicAmplitude * 0.6 +
                  Math.sin((origX + origZ) * 0.08 + dynamicSpeed * 1.2) * dynamicAmplitude * 0.3;

        positionAttr.setY(idx, y);

        // Warp stretch along Z axis based on scroll speed
        const zStretch = origZ + (origZ * scrollSpeed * 0.05);
        positionAttr.setZ(idx, zStretch);

        idx++;
      }
    }
    positionAttr.needsUpdate = true;

    // Dynamically scale particle sizes based on scroll speed
    const baseSize = W < 768 ? 0.15 : 0.22;
    gridMat.size = baseSize + (scrollSpeed * 0.035);

    // Apply grid position & rotation
    gridPoints.position.y = animState.gridY;
    gridPoints.rotation.y = elapsed * 0.02 + animState.gridRotationY;

    // 2. Animate cosmic nebula dust with scroll warp factor
    const dustPosAttr = dustPoints.geometry.attributes.position;
    const speedMultiplier = 1.0 + scrollSpeed * 2.5;
    for (let i = 0; i < DUST_COUNT; i++) {
      const initY = dustPosAttr.getY(i);
      dustPosAttr.setY(i, initY + Math.sin(elapsed * dustSpeeds[i] + dustOffsets[i]) * animState.warpFactor * speedMultiplier);
    }
    dustPosAttr.needsUpdate = true;
    dustPoints.rotation.y = elapsed * 0.008;
    dustPoints.rotation.x = elapsed * 0.003;

    // 3. Animate Core Group (morph spin speed based on scroll velocity)
    const coreRotationSpeed = 0.15 + scrollSpeed * 0.45;
    coreGroup.rotation.y = elapsed * coreRotationSpeed;
    coreGroup.rotation.x = elapsed * (0.08 + scrollSpeed * 0.2);
    coreGroup.position.y = animState.coreY + Math.sin(elapsed * 0.7) * 0.4; // Hover bounce
    
    // Scale core
    coreGroup.scale.setScalar(animState.coreScale);

    // Core opacity transition
    coreWireframe.material.opacity = 0.25 * animState.coreOpacity;
    coreInner.material.opacity = 0.18 * animState.coreOpacity;

    // Node orbit rotation (Nodes expand/shatter outwards during fast scroll!)
    nodes.forEach((node, i) => {
      node._angle += 0.008 * node._speed * (1.0 + scrollSpeed * 0.4);
      const dynamicOrbitRadius = 5.5 + Math.sin(elapsed * 0.5) * 0.5 + (scrollSpeed * 2.0);
      node.position.x = Math.cos(node._angle) * dynamicOrbitRadius;
      node.position.z = Math.sin(node._angle) * dynamicOrbitRadius;
      node.position.y = Math.sin(elapsed * 1.2 + i) * 1.0;
      node.rotation.x += 0.02 * (1.0 + scrollSpeed * 0.6);
      node.rotation.y += 0.01 * (1.0 + scrollSpeed * 0.6);
    });

    renderer.render(scene, camera);
  }

  animate();

  // ── Resize handler ────────────────────────────────────────


  function onResize() {
    W = window.innerWidth;
    H = window.innerHeight;
    camera.aspect = W / H;
    camera.updateProjectionMatrix();
    renderer.setSize(W, H);

    // Adjust size on mobile
    if (W < 768) {
      gridMat.size = 0.15;
    } else {
      gridMat.size = 0.22;
    }
  }

  window.addEventListener('resize', onResize, { passive: true });
  onResize();
})();
