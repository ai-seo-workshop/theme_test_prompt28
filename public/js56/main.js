/* main.js - Mobile offcanvas nav, FAQ accordion, search toggle */

(function() {
    'use strict';

    /* =========================================================
       DOM READY
    ========================================================= */
    document.addEventListener('DOMContentLoaded', function() {
        initOffcanvasNav();
        initSearchToggle();
        initFaqAccordion();
        initNavCurrentPage();
    });

    /* =========================================================
       OFFCANVAS MOBILE NAV
    ========================================================= */
    function initOffcanvasNav() {
        const toggleBtns = document.querySelectorAll('[data-offcanvas-toggle]');
        const panel = document.getElementById('offcanvas-panel');
        const overlay = document.getElementById('offcanvas-overlay');
        const closeBtns = document.querySelectorAll('[data-offcanvas-close]');

        if (!panel) return;

        function openNav() {
            panel.classList.add('is-open');
            overlay.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            toggleBtns.forEach(function(btn) {
                btn.setAttribute('aria-expanded', 'true');
                btn.classList.add('is-active');
            });
        }

        function closeNav() {
            panel.classList.remove('is-open');
            overlay.classList.remove('is-open');
            document.body.style.overflow = '';
            toggleBtns.forEach(function(btn) {
                btn.setAttribute('aria-expanded', 'false');
                btn.classList.remove('is-active');
            });
        }

        toggleBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (panel.classList.contains('is-open')) {
                    closeNav();
                } else {
                    openNav();
                }
            });
        });

        closeBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                closeNav();
            });
        });

        if (overlay) {
            overlay.addEventListener('click', function() {
                closeNav();
            });
        }

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && panel.classList.contains('is-open')) {
                closeNav();
            }
        });
    }

    /* =========================================================
       SEARCH TOGGLE
    ========================================================= */
    function initSearchToggle() {
        const searchBtns = document.querySelectorAll('[data-search-toggle]');
        const searchWrapper = document.querySelector('.search-wrapper-toggle');

        if (!searchWrapper) return;

        searchBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = searchWrapper.classList.toggle('is-open');
                btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                if (isOpen) {
                    const input = searchWrapper.querySelector('input[type="text"]');
                    if (input) input.focus();
                }
            });
        });

        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchWrapper.contains(e.target) && !Array.from(searchBtns).some(btn => btn.contains(e.target))) {
                searchWrapper.classList.remove('is-open');
                searchBtns.forEach(function(btn) {
                    btn.setAttribute('aria-expanded', 'false');
                });
            }
        });
    }

    /* =========================================================
       FAQ ACCORDION
    ========================================================= */
    function initFaqAccordion() {
        const faqItems = document.querySelectorAll('.faq56-item');

        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq56-question');
            const answer = item.querySelector('.faq56-answer');

            if (!question || !answer) return;

            question.addEventListener('click', function() {
                const isOpen = item.classList.toggle('is-open');
                question.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        });
    }

    /* =========================================================
       MARK CURRENT NAV ITEM
    ========================================================= */
    function initNavCurrentPage() {
        const path = window.location.pathname;
        const navLinks = document.querySelectorAll('.mainnav56 a, .offcanvasnav56 a');

        navLinks.forEach(function(link) {
            const href = link.getAttribute('href');
            if (!href) return;
            try {
                const linkPath = new URL(href, window.location.origin).pathname;
                if (linkPath === path || (path !== '/' && path.startsWith(linkPath) && linkPath !== '/')) {
                    link.closest('li') && link.closest('li').classList.add('current');
                }
            } catch(e) {
                // ignore
            }
        });
    }

})();
