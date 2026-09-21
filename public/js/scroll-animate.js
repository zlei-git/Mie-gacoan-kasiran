/**
 * Webcare-Inspired Scroll & Entrance Animation Engine
 * Inspired by https://webcareidn.com/services/ (AOS / Elementor Motion Effects)
 */
(function() {
    'use strict';

    function initScrollAnimations() {
        // Elements to observe
        const animElements = document.querySelectorAll('[data-animate], .reveal-on-scroll');

        if (!('IntersectionObserver' in window)) {
            // Fallback for older browsers: show everything immediately
            animElements.forEach(el => el.classList.add('is-revealed'));
            return;
        }

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -8% 0px',
            threshold: 0.08
        };

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const delay = el.getAttribute('data-delay') || 0;

                    if (delay > 0) {
                        setTimeout(() => {
                            el.classList.add('is-revealed');
                        }, parseInt(delay, 10));
                    } else {
                        el.classList.add('is-revealed');
                    }

                    // Check for animated counter numbers
                    if (el.hasAttribute('data-count')) {
                        animateCounter(el);
                    }

                    // Unobserve once animated for performance
                    obs.unobserve(el);
                }
            });
        }, observerOptions);

        animElements.forEach(el => {
            // If element is already in viewport on page load, reveal smoothly
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight * 0.9) {
                const delay = el.getAttribute('data-delay') || 0;
                setTimeout(() => {
                    el.classList.add('is-revealed');
                }, Math.min(parseInt(delay, 10), 400));
            } else {
                observer.observe(el);
            }
        });

        // Stagger grid items automatically if parent has .stagger-grid
        document.querySelectorAll('.stagger-grid').forEach(grid => {
            Array.from(grid.children).forEach((child, index) => {
                if (!child.hasAttribute('data-delay')) {
                    child.setAttribute('data-delay', (index * 120).toString());
                }
                if (!child.hasAttribute('data-animate') && !child.classList.contains('reveal-on-scroll')) {
                    child.classList.add('reveal-on-scroll');
                    child.setAttribute('data-animate', 'fadeInUp');
                    observer.observe(child);
                }
            });
        });

        // Sticky Navbar scroll visual enhancement (like Webcare)
        const header = document.querySelector('header');
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    header.classList.add('shadow-sm', 'bg-white/95');
                    header.classList.remove('bg-white');
                } else {
                    header.classList.remove('shadow-sm');
                }
            }, { passive: true });
        }
    }

    // Number counter animation helper
    function animateCounter(el) {
        const target = parseInt(el.getAttribute('data-count'), 10) || 0;
        const prefix = el.getAttribute('data-prefix') || '';
        const suffix = el.getAttribute('data-suffix') || '';
        const duration = 1200;
        const start = 0;
        const startTime = performance.now();

        function update(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            const ease = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(start + (target - start) * ease);

            el.textContent = prefix + current.toLocaleString('id-ID') + suffix;

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = prefix + target.toLocaleString('id-ID') + suffix;
            }
        }
        requestAnimationFrame(update);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollAnimations);
    } else {
        initScrollAnimations();
    }
})();
