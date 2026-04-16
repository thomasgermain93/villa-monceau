/**
 * Villa Monceau — Scripts
 */

// Live Links — réécriture des URLs localhost côté client
// (le tunnel Local by Flywheel ne transmet pas le hostname live à PHP)
(function() {
  var LOCAL = 'http://localhost:10004';
  var origin = window.location.origin;
  if (origin.indexOf('localhost') !== -1) return; // accès local direct → rien à faire

  function rewrite(val) {
    return val ? val.split(LOCAL).join(origin) : val;
  }

  function fixEl(el) {
    if (el.src   && el.src.indexOf(LOCAL)    !== -1) el.src    = rewrite(el.src);
    if (el.srcset && el.srcset.indexOf(LOCAL) !== -1) el.srcset = rewrite(el.srcset);
    if (el.href  && el.href.indexOf(LOCAL)   !== -1) el.href   = rewrite(el.href);
    var s = el.getAttribute('style');
    if (s && s.indexOf(LOCAL) !== -1) el.setAttribute('style', rewrite(s));
  }

  function fixAll() {
    document.querySelectorAll('img, source').forEach(fixEl);
  }

  // Premier passage au DOMContentLoaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fixAll);
  } else {
    fixAll();
  }

  // Observer pour le contenu chargé dynamiquement (slider, etc.)
  var obs = new MutationObserver(function(mutations) {
    mutations.forEach(function(m) {
      m.addedNodes.forEach(function(node) {
        if (node.nodeType !== 1) return;
        fixEl(node);
        node.querySelectorAll && node.querySelectorAll('img, source').forEach(fixEl);
      });
    });
  });
  document.addEventListener('DOMContentLoaded', function() {
    obs.observe(document.body, { childList: true, subtree: true });
  });
})();

// Header scroll detection
(function() {
  const header = document.querySelector('.vm-site-header');
  if (!header) return;

  const onScroll = () => {
    if (window.scrollY > 60) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();

// Mobile hamburger + menu (injecté via JS pour garder le template Site Editor propre)
(function() {
  const headerInner = document.querySelector('.vm-header__inner');
  const vmHeader = document.querySelector('.vm-header');
  if (!headerInner || !vmHeader) return;

  const hamburger = document.createElement('button');
  hamburger.className = 'vm-hamburger';
  hamburger.setAttribute('aria-label', 'Ouvrir le menu');
  hamburger.innerHTML = '<span></span><span></span><span></span>';

  const mobileMenu = document.createElement('nav');
  mobileMenu.className = 'vm-mobile-menu';
  mobileMenu.setAttribute('aria-label', 'Navigation mobile');
  mobileMenu.innerHTML =
    '<a href="/chambres/">Chambres</a>' +
    '<a href="/#apropos">À propos</a>' +
    '<a href="/#situation">Situation</a>' +
    '<a href="https://cecila.be" target="_blank" rel="noopener">Restaurant Cécila</a>' +
    '<a href="/contact">Contact</a>' +
    '<a href="/contact" class="vm-mobile-menu__book">Réserver</a>';

  headerInner.prepend(hamburger);
  vmHeader.append(mobileMenu);

  hamburger.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
    hamburger.classList.toggle('is-active');
  });

  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!vmHeader.contains(e.target)) {
      mobileMenu.classList.remove('open');
      hamburger.classList.remove('is-active');
    }
  });
})();

// Gallery strip — injection des slides via JS (template FSE propre)
(function() {
  const strip = document.querySelector('.vm-gallery-strip__inner');
  if (!strip) return;

  const slides = [
    { src: '/wp-content/uploads/vm-real-grande-suite.webp', alt: 'La Grande Suite' },
    { src: '/wp-content/uploads/vm-real-suite-gustavienne.webp', alt: 'La Suite Gustavienne' },
    { src: '/wp-content/uploads/vm-real-chambre-rouge.webp', alt: 'La Chambre Rouge' },
    { src: '/wp-content/uploads/vm-real-chambre-vintage.webp', alt: 'La Chambre Vintage' },
    { src: '/wp-content/uploads/vm-real-chambre-bleue.webp', alt: 'La Chambre Bleue' },
  ];

  slides.forEach(({ src, alt }) => {
    const slide = document.createElement('div');
    slide.className = 'vm-gallery-strip__slide';
    const img = document.createElement('img');
    img.src = src;
    img.alt = alt;
    img.loading = 'lazy';
    slide.appendChild(img);
    strip.appendChild(slide);
  });
})();

// Gallery strip drag-to-scroll
(function() {
  const strip = document.querySelector('.vm-gallery-strip__inner');
  if (!strip) return;

  let isDown = false;
  let startX;
  let scrollLeft;

  strip.addEventListener('mousedown', (e) => {
    isDown = true;
    strip.style.cursor = 'grabbing';
    startX = e.pageX - strip.offsetLeft;
    scrollLeft = strip.scrollLeft;
  });

  strip.addEventListener('mouseleave', () => { isDown = false; strip.style.cursor = 'grab'; });
  strip.addEventListener('mouseup', () => { isDown = false; strip.style.cursor = 'grab'; });

  strip.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - strip.offsetLeft;
    const walk = (x - startX) * 2;
    strip.scrollLeft = scrollLeft - walk;
  });
})();

// Hero scroll indicator (injecté via JS pour garder le template Site Editor propre)
(function() {
  const hero = document.querySelector('.vm-hero .wp-block-cover__inner-container');
  if (!hero) return;
  const scrollEl = document.createElement('div');
  scrollEl.className = 'vm-hero__scroll';
  scrollEl.innerHTML =
    '<span>Découvrir</span>' +
    '<svg width="16" height="24" viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg">' +
    '<path d="M8 0v20M1 13l7 7 7-7" stroke="#CEA77C" stroke-width="1.2"/></svg>';
  hero.appendChild(scrollEl);
})();

// Google Maps (injecté via JS pour garder le template Site Editor propre)
(function() {
  const mapWrapper = document.querySelector('.vm-location__map-wrapper');
  if (!mapWrapper) return;
  mapWrapper.innerHTML =
    '<div class="vm-location__map">' +
    '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2532.5!2d4.591!3d50.618!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zVmlsbGEgTW9uY2Vhdw!5e0!3m2!1sfr!2sbe!4v1" ' +
    'width="100%" height="420" style="border:0;filter:grayscale(80%) contrast(1.1);" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" ' +
    'title="Villa Monceau sur Google Maps"></iframe>' +
    '</div>';
})();

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      const offset = 80;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  });
});

// Chambre slider — navigation par dots
document.querySelectorAll('.vm-chambre-slider').forEach(slider => {
  const track = slider.querySelector('.vm-chambre-slider__track');
  const dots  = slider.querySelectorAll('.vm-chambre-slider__dot');
  if (!track || !dots.length) return;

  track.addEventListener('scroll', () => {
    const index = Math.round(track.scrollLeft / track.clientWidth);
    dots.forEach((dot, i) => dot.classList.toggle('is-active', i === index));
  });

  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      track.scrollTo({ left: i * track.clientWidth, behavior: 'smooth' });
    });
  });
});
