/* ============================================================
   NexaBlog — app.js
   Dark mode, Toast system, User dropdown, Mobile menu
   ============================================================ */

// ── Dark Mode ─────────────────────────────────────────────

const ThemeManager = {
  STORAGE_KEY: 'nexablog-theme',

  init() {
    const saved = localStorage.getItem(this.STORAGE_KEY);
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = saved || (prefersDark ? 'dark' : 'light');
    this.apply(theme);

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      if (!localStorage.getItem(this.STORAGE_KEY)) {
        this.apply(e.matches ? 'dark' : 'light');
      }
    });
  },

  apply(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    const icon = document.getElementById('theme-icon');
    if (icon) {
      icon.textContent = theme === 'dark' ? '☀️' : '🌙';
    }
  },

  toggle() {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    localStorage.setItem(this.STORAGE_KEY, next);
    this.apply(next);
  }
};

ThemeManager.init();

// ── Toast System ──────────────────────────────────────────

const Toast = {
  container: null,

  init() {
    this.container = document.getElementById('toast-container');
    if (!this.container) {
      this.container = document.createElement('div');
      this.container.id = 'toast-container';
      this.container.className = 'toast-container';
      document.body.appendChild(this.container);
    }
    // Auto-render server-side flash toasts
    this.renderFlashToasts();
  },

  renderFlashToasts() {
    // Server injects window.__toasts from Blade
    if (window.__toasts && window.__toasts.length > 0) {
      window.__toasts.forEach(t => this.show(t.message, t.type, t.title));
    }
  },

  show(message, type = 'info', title = null) {
    const icons = {
      success: '✓',
      error:   '✕',
      warning: '⚠',
      info:    'ℹ',
    };

    const titles = {
      success: title || 'Berhasil!',
      error:   title || 'Gagal!',
      warning: title || 'Perhatian!',
      info:    title || 'Info',
    };

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
      <div class="toast-icon">${icons[type] || icons.info}</div>
      <div class="toast-body">
        <div class="toast-title">${titles[type]}</div>
        <div class="toast-msg">${message}</div>
      </div>
      <button class="toast-close" onclick="Toast.remove(this.closest('.toast'))">✕</button>
      <div class="toast-progress"></div>
    `;

    this.container.appendChild(toast);

    // Auto-dismiss after 5 seconds
    const timer = setTimeout(() => this.remove(toast), 5000);
    toast._timer = timer;

    return toast;
  },

  remove(toast) {
    if (!toast || toast._removing) return;
    toast._removing = true;
    clearTimeout(toast._timer);
    toast.classList.add('toast-removing');
    setTimeout(() => toast.remove(), 300);
  },

  success(message, title) { return this.show(message, 'success', title); },
  error(message, title)   { return this.show(message, 'error',   title); },
  warning(message, title) { return this.show(message, 'warning', title); },
  info(message, title)    { return this.show(message, 'info',    title); },
};

// ── User Dropdown ─────────────────────────────────────────

const UserMenu = {
  trigger: null,
  dropdown: null,

  init() {
    this.trigger  = document.getElementById('user-menu-trigger');
    this.dropdown = document.getElementById('user-dropdown');

    if (!this.trigger || !this.dropdown) return;

    this.trigger.addEventListener('click', (e) => {
      e.stopPropagation();
      this.toggle();
    });

    document.addEventListener('click', () => this.close());
    this.dropdown.addEventListener('click', (e) => e.stopPropagation());

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') this.close();
    });
  },

  toggle() {
    this.dropdown.classList.toggle('open');
  },

  close() {
    this.dropdown.classList.remove('open');
  }
};

// ── Mobile Menu ───────────────────────────────────────────

const MobileMenu = {
  toggle: null,
  nav: null,
  sidebar: null,

  init() {
    this.toggle  = document.getElementById('mobile-menu-toggle');
    this.nav     = document.getElementById('navbar-nav');
    this.sidebar = document.getElementById('sidebar');

    if (this.toggle) {
      this.toggle.addEventListener('click', () => {
        if (this.nav) this.nav.classList.toggle('open');
      });
    }

    const sidebarToggle = document.getElementById('sidebar-toggle');
    if (sidebarToggle && this.sidebar) {
      sidebarToggle.addEventListener('click', () => {
        this.sidebar.classList.toggle('open');
      });
    }

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (this.nav && !e.target.closest('.navbar-nav') && !e.target.closest('#mobile-menu-toggle')) {
        this.nav.classList.remove('open');
      }
    });
  }
};

// ── Scroll to Top ─────────────────────────────────────────

const ScrollTop = {
  btn: null,
  init() {
    this.btn = document.getElementById('scroll-top');
    if (!this.btn) return;

    window.addEventListener('scroll', () => {
      this.btn.style.opacity = window.scrollY > 400 ? '1' : '0';
      this.btn.style.pointerEvents = window.scrollY > 400 ? 'all' : 'none';
    }, { passive: true });

    this.btn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
};

// ── Active nav highlight ──────────────────────────────────

function setActiveNav() {
  const path = window.location.pathname;
  document.querySelectorAll('.navbar-nav a').forEach(link => {
    const href = link.getAttribute('href');
    if (href && path.startsWith(href) && href !== '/') {
      link.classList.add('active');
    } else if (href === '/' && path === '/') {
      link.classList.add('active');
    }
  });
}

// ── Confirm dialogs ───────────────────────────────────────

function confirmDelete(formId, name = 'item ini') {
  if (confirm(`Apakah Anda yakin ingin menghapus ${name}? Tindakan ini tidak dapat dibatalkan.`)) {
    document.getElementById(formId).submit();
  }
}

// ── Custom Cursor Trail ────────────────────────────────────

const Cursor = {
  dot: null,
  trail: null,
  mouse: { x: 0, y: 0 },
  pos: { x: 0, y: 0 },
  speed: 0.16,

  init() {
    this.dot = document.getElementById('custom-cursor');
    this.trail = document.getElementById('custom-cursor-trail');
    if (!this.dot || !this.trail) return;

    if (window.matchMedia('(pointer: coarse)').matches) {
      this.dot.style.display = 'none';
      this.trail.style.display = 'none';
      return;
    }

    document.addEventListener('mousemove', (e) => {
      this.mouse.x = e.clientX;
      this.mouse.y = e.clientY;
      this.dot.style.transform = `translate3d(${this.mouse.x}px, ${this.mouse.y}px, 0)`;
    });

    const hoverSelector = 'a, button, .btn, .post-card, .feature-card, .user-menu-trigger, .dropdown-item, [onclick]';
    
    document.addEventListener('mouseover', (e) => {
      if (e.target.closest(hoverSelector)) {
        this.trail.classList.add('hover');
        this.dot.classList.add('hover');
      }
    });

    document.addEventListener('mouseout', (e) => {
      if (e.target.closest(hoverSelector)) {
        this.trail.classList.remove('hover');
        this.dot.classList.remove('hover');
      }
    });

    const render = () => {
      this.pos.x += (this.mouse.x - this.pos.x) * this.speed;
      this.pos.y += (this.mouse.y - this.pos.y) * this.speed;
      this.trail.style.transform = `translate3d(${this.pos.x}px, ${this.pos.y}px, 0)`;
      requestAnimationFrame(render);
    };
    render();
  }
};

// ── Copy Code Block Init ──────────────────────────────────
function initCopyCode() {
  document.querySelectorAll('pre').forEach(pre => {
    if (pre.querySelector('.copy-code-btn')) return;

    const code = pre.querySelector('code');
    if (!code) return;

    const btn = document.createElement('button');
    btn.className = 'copy-code-btn';
    btn.type = 'button';
    btn.innerHTML = '📋 Salin';
    pre.appendChild(btn);

    btn.addEventListener('click', () => {
      navigator.clipboard.writeText(code.textContent.trim()).then(() => {
        btn.innerHTML = '✓ Tersalin!';
        btn.classList.add('copied');
        setTimeout(() => {
          btn.innerHTML = '📋 Salin';
          btn.classList.remove('copied');
        }, 2000);
      }).catch(err => {
        console.error('Failed to copy: ', err);
        if (typeof Toast !== 'undefined') {
          Toast.error('Gagal menyalin kode.');
        }
      });
    });
  });
}

// ── Initialize all on DOM ready ───────────────────────────

document.addEventListener('DOMContentLoaded', () => {
  Toast.init();
  UserMenu.init();
  MobileMenu.init();
  ScrollTop.init();
  setActiveNav();
  Cursor.init();
  initCopyCode();

  // Theme toggle button
  const themeToggle = document.getElementById('theme-toggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', () => ThemeManager.toggle());
  }

  // Scroll-indicator click
  const scrollIndicator = document.querySelector('.scroll-indicator');
  if (scrollIndicator) {
    scrollIndicator.addEventListener('click', () => {
      const next = document.querySelector('.section');
      if (next) next.scrollIntoView({ behavior: 'smooth' });
    });
  }
});

