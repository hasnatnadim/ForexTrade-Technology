/* Forex Trade Technology — V5 light interactions
 * No dependencies. Content is visible immediately; only a small scroll reveal is progressive enhancement.
 * Heading text is never typed, hidden, rotated or rewritten.
 */
(function () {
  'use strict';
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduceMotion) return;

  var root = document.documentElement;
  root.classList.add('ftt-motion-ready');

  function init() {
    var targets = document.querySelectorAll(
      '.ftt-main:not(.ftt-main--home-slideshow) .ftt-service-card, ' +
      '.ftt-main:not(.ftt-main--home-slideshow) .ftt-step-card, ' +
      '.ftt-main:not(.ftt-main--home-slideshow) .ftt-page-hero-media, ' +
      '.ftt-main:not(.ftt-main--home-slideshow) .ftt-content-photo, ' +
      '.ftt-main:not(.ftt-main--home-slideshow) .ftt-final-cta'
    );
    targets.forEach(function (el) { el.classList.add('ftt-reveal'); });

    if (!('IntersectionObserver' in window)) {
      targets.forEach(function (el) { el.classList.add('is-visible'); });
      return;
    }

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { root: null, rootMargin: '0px 0px -5% 0px', threshold: 0.03 });
    targets.forEach(function (el) { observer.observe(el); });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
  else init();
})();
