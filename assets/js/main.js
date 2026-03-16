/* ============================================================
   main.js  —  SR Portfolio Public Frontend
   ============================================================ */

// ── Navbar scroll effect ──────────────────────────────────
const nav = document.getElementById('mainNav');
if (nav) {
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
  }, { passive: true });
}

// ── Skill bar animation on scroll ────────────────────────
function animateSkillBars() {
  const bars = document.querySelectorAll('.skill-fill');
  bars.forEach(bar => {
    const width = bar.style.width;
    bar.style.width = '0%';
    setTimeout(() => { bar.style.width = width; }, 200);
  });
}

// ── Intersection Observer for skill bars ─────────────────
const skillSection = document.querySelector('#about');
if (skillSection) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateSkillBars();
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.3 });
  observer.observe(skillSection);
}

// ── About Tabs (Experience / Education) ──────────────────
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const target = btn.dataset.tab;
    document.querySelectorAll('.tab-content-custom').forEach(tc => tc.classList.add('d-none'));
    const panel = document.getElementById('tab-' + target);
    if (panel) panel.classList.remove('d-none');
  });
});

// ── Project Filter ────────────────────────────────────────
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const filter = btn.dataset.filter;
    document.querySelectorAll('.project-card-wrap').forEach(card => {
      if (filter === 'all' || card.dataset.category === filter) {
        card.style.display = '';
        card.style.animation = 'fadeInUp .4s ease forwards';
      } else {
        card.style.display = 'none';
      }
    });
  });
});

// ── Navbar active link on scroll ─────────────────────────
const sections = document.querySelectorAll('section[id]');
const navLinks  = document.querySelectorAll('.nav-link[href^="#"]');

window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(section => {
    if (window.scrollY >= section.offsetTop - 100) {
      current = section.getAttribute('id');
    }
  });
  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === '#' + current) {
      link.classList.add('active');
    }
  });
}, { passive: true });

// ── Smooth scroll for all anchor links ───────────────────
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      const top = target.offsetTop - 70;
      window.scrollTo({ top, behavior: 'smooth' });
      // Close mobile nav
      const navCollapse = document.getElementById('navLinks');
      if (navCollapse && navCollapse.classList.contains('show')) {
        navCollapse.classList.remove('show');
      }
    }
  });
});

// ── Fade-in animation on scroll ───────────────────────────
const fadeEls = document.querySelectorAll('[data-aos]');
if (fadeEls.length) {
  const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('aos-animate');
        fadeObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
  fadeEls.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(24px)';
    el.style.transition = 'opacity .6s ease, transform .6s ease';
    fadeObserver.observe(el);
  });
}

// Trigger AOS animate
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.aos-animate').forEach(el => {
    el.style.opacity = '1';
    el.style.transform = 'none';
  });
});

// Override intersection callback to apply styles
const origFadeObs = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'none';
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
document.querySelectorAll('[data-aos]').forEach(el => origFadeObs.observe(el));

// ── Contact form validation ───────────────────────────────
const contactForm = document.getElementById('contactForm');
if (contactForm) {
  contactForm.addEventListener('submit', function(e) {
    const name    = this.querySelector('[name="name"]');
    const message = this.querySelector('[name="message"]');
    if (!name.value.trim() || !message.value.trim()) {
      e.preventDefault();
      alert('Nama dan pesan wajib diisi!');
    }
  });
}
