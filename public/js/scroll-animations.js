/* ============================================================
   NexaBlog — Scroll Animations (GSAP + IntersectionObserver)
   ============================================================ */

(function () {
  'use strict';

  // ── IntersectionObserver for animate-on-scroll ────────────

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target); // Only animate once
      }
    });
  }, {
    threshold: 0.12,
    rootMargin: '0px 0px -50px 0px',
  });

  function initScrollAnimations() {
    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
  }

  // ── Counter animation ─────────────────────────────────────

  function animateCounter(el, target, duration = 2000) {
    let start = 0;
    const startTime = performance.now();

    function step(now) {
      const elapsed  = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      // Ease out cubic
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = Math.floor(eased * target);
      el.textContent = current.toLocaleString('id-ID') + (el.dataset.suffix || '');
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

  function initCounters() {
    const counterObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target._counted) {
          entry.target._counted = true;
          const target  = parseInt(entry.target.dataset.count || 0);
          animateCounter(entry.target, target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });

    document.querySelectorAll('[data-count]').forEach(el => counterObserver.observe(el));
  }

  // ── Parallax on scroll ────────────────────────────────────

  function initParallax() {
    const els = document.querySelectorAll('[data-parallax]');
    if (!els.length) return;

    window.addEventListener('scroll', () => {
      const scrollY = window.scrollY;
      els.forEach(el => {
        const speed = parseFloat(el.dataset.parallax) || 0.3;
        const rect  = el.getBoundingClientRect();
        const offset = (rect.top + scrollY) * speed;
        el.style.transform = `translateY(${-scrollY * speed * 0.2}px)`;
      });
    }, { passive: true });
  }

  // ── Stagger children ─────────────────────────────────────

  function initStagger() {
    document.querySelectorAll('[data-stagger]').forEach(container => {
      const delay = parseFloat(container.dataset.stagger) || 0.1;
      Array.from(container.children).forEach((child, i) => {
        child.classList.add('animate-on-scroll');
        child.style.transitionDelay = `${i * delay}s`;
        observer.observe(child);
      });
    });
  }

  // ── Smooth scroll for anchor links ────────────────────────

  function initSmoothLinks() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
      link.addEventListener('click', (e) => {
        const id = link.getAttribute('href').slice(1);
        const target = document.getElementById(id);
        if (target) {
          e.preventDefault();
          const offset = 80; // navbar height
          const top = target.getBoundingClientRect().top + window.scrollY - offset;
          window.scrollTo({ top, behavior: 'smooth' });
        }
      });
    });
  }

  // ── Scroll Progress Bar ───────────────────────────────────

  function initScrollProgressBar() {
    const bar = document.getElementById('scroll-progress-bar');
    if (!bar) return;

    window.addEventListener('scroll', () => {
      const scrollTop = window.scrollY;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
      bar.style.width = `${progress}%`;
    }, { passive: true });
  }

  // ── Init ──────────────────────────────────────────────────

  document.addEventListener('DOMContentLoaded', () => {
    initScrollAnimations();
    initCounters();
    initParallax();
    initStagger();
    initSmoothLinks();
    initScrollProgressBar();
  });

})();

