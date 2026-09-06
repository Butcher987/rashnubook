/**
 * main.js - rashnubook.ir
 * Lightweight, Vanilla JavaScript without jQuery dependency
 * Built for ultra-fast performance inspired by Bento & Tento themes
 */

document.addEventListener('DOMContentLoaded', () => {
  initMobileDrawer();
  initMiniCart();
  initQuantityButtons();
  initAccordions();
  initHeaderScroll();
  initHeroSlider();
  initProductCarousels();
  initAjaxSearch();
  initNewsletter();
  initCategoryDropdown();
});

/**
 * Mobile Navigation Drawer
 */
function initMobileDrawer() {
  const toggleBtns = document.querySelectorAll('[data-drawer-toggle="mobile-menu"]');
  const drawer = document.getElementById('mobile-menu-drawer');
  const overlay = document.getElementById('site-overlay');
  const closeBtns = document.querySelectorAll('[data-drawer-close="mobile-menu"]');

  if (!drawer || !overlay) return;

  function openMenu() {
    drawer.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    drawer.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  toggleBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openMenu();
    });
  });

  closeBtns.forEach((btn) => {
    btn.addEventListener('click', closeMenu);
  });

  overlay.addEventListener('click', closeMenu);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('active')) {
      closeMenu();
    }
  });
}

/**
 * Mini Cart Drawer
 */
function initMiniCart() {
  const cartTriggers = document.querySelectorAll('[data-drawer-toggle="mini-cart"]');
  const drawer = document.getElementById('mini-cart-drawer');
  const overlay = document.getElementById('site-overlay');
  const closeBtn = document.querySelector('[data-drawer-close="mini-cart"]');

  if (!drawer || !overlay) return;

  function openCart() {
    drawer.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeCart() {
    drawer.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  cartTriggers.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openCart();
    });
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', closeCart);
  }

  overlay.addEventListener('click', closeCart);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && drawer.classList.contains('active')) {
      closeCart();
    }
  });

  // Listen to WooCommerce AJAX add to cart event
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', () => {
      openCart();
    });
  }
}

/**
 * Quantity Plus/Minus buttons for single-product and cart
 */
function initQuantityButtons() {
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.qty-btn');
    if (!btn) return;

    e.preventDefault();
    const action = btn.dataset.action;
    const wrap = btn.closest('.quantity-wrap');
    if (!wrap) return;

    const input = wrap.querySelector('input.qty');
    if (!input) return;

    let currentVal = parseInt(input.value, 10) || 1;
    const min = parseInt(input.min, 10) || 1;
    const max = parseInt(input.max, 10) || 999;
    const step = parseInt(input.step, 10) || 1;

    if (action === 'plus') {
      if (currentVal + step <= max) {
        input.value = currentVal + step;
      }
    } else if (action === 'minus') {
      if (currentVal - step >= min) {
        input.value = currentVal - step;
      }
    }

    input.dispatchEvent(new Event('change', { bubbles: true }));
  });
}

/**
 * Landing Page / FAQ Accordion
 */
function initAccordions() {
  const accordionItems = document.querySelectorAll('.faq-item');
  accordionItems.forEach((item) => {
    const question = item.querySelector('.faq-question');
    if (!question) return;

    question.addEventListener('click', () => {
      const isActive = item.classList.contains('active');
      accordionItems.forEach((el) => el.classList.remove('active'));
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });
}

/**
 * Sticky Header Scroll State
 */
function initHeaderScroll() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  }, { passive: true });
}

/**
 * Persian Number Formatter (fa-IR)
 */
function toPersianDigits(num) {
  const persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
  return String(num).replace(/[0-9]/g, (w) => persianDigits[+w]);
}

/**
 * Bento / Tento Style Hero Interactive Slider
 */
function initHeroSlider() {
  document.querySelectorAll('[data-hero-slider], .tento-hero-slider').forEach((slider) => {
    const slides = [...slider.querySelectorAll('[data-hero-slide], .tento-hero-slide')];
    const dots = [...slider.querySelectorAll('[data-hero-dot], .tento-hero-dot')];
    if (slides.length < 2) return;
    let active = 0;
    let timer = null;
    const interval = parseInt(slider.dataset.interval, 10) || 4000;

    const show = (index) => {
      active = (index + slides.length) % slides.length;
      slides.forEach((slide, slideIndex) => {
        const selected = slideIndex === active;
        slide.classList.toggle('is-active', selected);
        slide.setAttribute('aria-hidden', String(!selected));
      });
      dots.forEach((dot, dotIndex) => {
        dot.classList.toggle('is-active', dotIndex === active);
      });
    };

    const stop = () => {
      if (timer) window.clearInterval(timer);
      timer = null;
    };

    const start = () => {
      stop();
      if (slider.dataset.autoplay !== 'false') {
        timer = window.setInterval(() => show(active + 1), interval);
      }
    };

    slider.querySelector('[data-hero-prev]')?.addEventListener('click', (e) => {
      e.preventDefault();
      show(active - 1);
      start();
    });

    slider.querySelector('[data-hero-next]')?.addEventListener('click', (e) => {
      e.preventDefault();
      show(active + 1);
      start();
    });

    dots.forEach((dot) => {
      dot.addEventListener('click', (e) => {
        e.preventDefault();
        show(Number(dot.dataset.heroDot));
        start();
      });
    });

    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);

    // Touch swipe support
    let touchStartX = 0;
    slider.addEventListener('touchstart', (e) => {
      stop();
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    slider.addEventListener('touchend', (e) => {
      const diffX = e.changedTouches[0].screenX - touchStartX;
      if (Math.abs(diffX) > 40) {
        if (diffX < 0) {
          show(active + 1);
        } else {
          show(active - 1);
        }
      }
      start();
    }, { passive: true });

    start();
  });
}

/**
 * Bento / Tento Style Category Product Rails ([data-product-rail])
 * Changes every 3 seconds with infinite loop
 */
function initProductCarousels() {
  document.querySelectorAll('[data-product-rail], .lg-category-rail').forEach((rail) => {
    const viewport = rail.querySelector('[data-rail-track], .lg-category-rail__track');
    if (!viewport) return;

    let timer = null;
    const interval = 3000; // 3 seconds per user request

    const move = (direction = 1) => {
      const card = viewport.querySelector('li.product');
      const distance = card ? (card.getBoundingClientRect().width + 20) : 280;
      const maxScroll = viewport.scrollWidth - viewport.clientWidth;
      const currentScroll = Math.abs(viewport.scrollLeft);

      if (direction > 0 && currentScroll >= maxScroll - 15) {
        viewport.scrollTo({ left: 0, behavior: 'smooth' });
      } else {
        viewport.scrollBy({ left: -distance * direction, behavior: 'smooth' });
      }
    };

    const stop = () => {
      if (timer) window.clearInterval(timer);
      timer = null;
    };

    const start = () => {
      stop();
      if (viewport.scrollWidth > viewport.clientWidth) {
        timer = window.setInterval(() => move(1), interval);
      }
    };

    rail.querySelector('[data-rail-prev]')?.addEventListener('click', (e) => {
      e.preventDefault();
      move(-1);
      start();
    });

    rail.querySelector('[data-rail-next]')?.addEventListener('click', (e) => {
      e.preventDefault();
      move(1);
      start();
    });

    rail.addEventListener('mouseenter', stop);
    rail.addEventListener('mouseleave', start);
    rail.addEventListener('touchstart', stop, { passive: true });
    rail.addEventListener('touchend', start, { passive: true });

    start();
  });
}

/**
 * Live Ajax Search for Books and Literary Articles
 */
function initAjaxSearch() {
  const searchInputs = document.querySelectorAll('[data-ajax-search], .search-input');
  searchInputs.forEach((input) => {
    const container = input.closest('.header-search') || input.parentElement;
    let dropdown = container.querySelector('[data-search-dropdown], .search-results-dropdown');
    if (!dropdown) {
      dropdown = document.createElement('div');
      dropdown.className = 'search-results-dropdown';
      dropdown.style.display = 'none';
      container.appendChild(dropdown);
    }

    let debounceTimer = null;

    input.addEventListener('input', () => {
      const term = input.value.trim();
      if (debounceTimer) clearTimeout(debounceTimer);

      if (term.length < 2) {
        dropdown.innerHTML = '';
        dropdown.style.display = 'none';
        return;
      }

      dropdown.innerHTML = '<div class="search-results-loading">در حال جستجوی کتاب‌ها...</div>';
      dropdown.style.display = 'block';

      debounceTimer = setTimeout(() => {
        const ajaxUrl = (typeof rashnubook_ajax !== 'undefined' && rashnubook_ajax.ajax_url)
          ? rashnubook_ajax.ajax_url
          : '/rashnubook/wp-admin/admin-ajax.php';

        fetch(`${ajaxUrl}?action=rashnubook_ajax_search&term=${encodeURIComponent(term)}`)
          .then((res) => res.json())
          .then((res) => {
            if (!res.success || !res.data || !res.data.results || res.data.results.length === 0) {
              dropdown.innerHTML = '<div class="search-results-empty">کتاب یا مقاله‌ای با این عنوان یافت نشد.</div>';
              dropdown.style.display = 'block';
              return;
            }

            let html = '';
            res.data.results.forEach((item) => {
              html += `
                <a href="${item.url}" class="search-result-item">
                  <img src="${item.thumbnail}" alt="${item.title}" class="search-result-thumb" loading="lazy">
                  <div class="search-result-info">
                    <span class="search-result-badge">${item.type}</span>
                    <strong class="search-result-title">${item.title}</strong>
                    <span class="search-result-author">${item.author ? item.author : ''}</span>
                  </div>
                  ${item.price ? `<div class="search-result-price">${item.price}</div>` : ''}
                </a>
              `;
            });
            dropdown.innerHTML = html;
            dropdown.style.display = 'block';
          })
          .catch(() => {
            dropdown.innerHTML = '<div class="search-results-empty">خطا در بارگذاری نتایج.</div>';
          });
      }, 250);
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (!container.contains(e.target)) {
        dropdown.style.display = 'none';
      }
    });

    // Reopen on focus if has term
    input.addEventListener('focus', () => {
      if (input.value.trim().length >= 2 && dropdown.children.length > 0) {
        dropdown.style.display = 'block';
      }
    });
  });
}





/**
 * Newsletter AJAX Signup
 */
function initNewsletter() {
  const form = document.getElementById('rashnu-newsletter-form');
  const emailInput = document.getElementById('rashnu-newsletter-email');
  const submitBtn = document.getElementById('rashnu-newsletter-submit');
  const msgBox = document.getElementById('rashnu-newsletter-msg');

  if (!form || !emailInput || !submitBtn || !msgBox) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = emailInput.value.trim();
    if (!email) return;

    submitBtn.disabled = true;
    const originalText = submitBtn.textContent;
    submitBtn.textContent = '...';
    msgBox.style.display = 'none';

    const ajaxUrl = (typeof rashnubook_ajax !== 'undefined' && rashnubook_ajax.ajax_url)
      ? rashnubook_ajax.ajax_url
      : '/rashnubook/wp-admin/admin-ajax.php';
    const nonce = (typeof rashnubook_ajax !== 'undefined' && rashnubook_ajax.nonce)
      ? rashnubook_ajax.nonce
      : '';

    const formData = new FormData();
    formData.append('action', 'rashnubook_newsletter_signup');
    formData.append('email', email);
    formData.append('nonce', nonce);

    fetch(ajaxUrl, {
      method: 'POST',
      body: formData,
    })
      .then((res) => res.json())
      .then((res) => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        msgBox.style.display = 'block';

        if (res.success) {
          msgBox.style.background = 'rgba(74, 222, 128, 0.15)';
          msgBox.style.color = '#86efac';
          msgBox.style.border = '1px solid rgba(74, 222, 128, 0.3)';
          msgBox.textContent = res.data && res.data.message ? res.data.message : 'عضویت شما با موفقیت ثبت شد.';
          emailInput.value = '';
        } else {
          msgBox.style.background = 'rgba(239, 68, 68, 0.15)';
          msgBox.style.color = '#fca5a5';
          msgBox.style.border = '1px solid rgba(239, 68, 68, 0.3)';
          msgBox.textContent = res.data && res.data.message ? res.data.message : 'خطایی رخ داد. لطفاً مجدداً تلاش کنید.';
        }
      })
      .catch(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        msgBox.style.display = 'block';
        msgBox.style.background = 'rgba(239, 68, 68, 0.15)';
        msgBox.style.color = '#fca5a5';
        msgBox.style.border = '1px solid rgba(239, 68, 68, 0.3)';
        msgBox.textContent = 'خطا در برقراری ارتباط با سرور.';
      });
  });
}

/**
 * Header Category Mega Dropdown (Accessibility & Click Outside)
 */
function initCategoryDropdown() {
  const dropdown = document.getElementById('nav-cat-dropdown');
  const btn = document.getElementById('nav-cat-btn');
  const menu = document.getElementById('nav-cat-menu');

  if (!dropdown || !btn || !menu) return;

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = dropdown.classList.toggle('is-open');
    btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target)) {
      dropdown.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && dropdown.classList.contains('is-open')) {
      dropdown.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
      btn.focus();
    }
  });
}
