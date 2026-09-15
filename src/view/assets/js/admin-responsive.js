/* Dekanta Admin - mobile sidebar scroll persistence */
(function () {
  'use strict';

  function initAdminMobileMenu() {
    var menu = document.querySelector('.Sidebar_sideBar__CC4MK');
    if (!menu || window.innerWidth > 768) return;

    var storageKey = 'dekanta_admin_sidebar_scroll_left';

    // Restore the last horizontal position after the page is rendered.
    var saved = sessionStorage.getItem(storageKey);
    if (saved !== null) {
      var left = parseInt(saved, 10);
      if (!isNaN(left)) {
        requestAnimationFrame(function () {
          menu.scrollLeft = left;
          requestAnimationFrame(function () {
            menu.scrollLeft = left;
          });
        });
      }
    }

    // Save continuously while the user drags/swipes the menu.
    var saveTimer;
    menu.addEventListener('scroll', function () {
      clearTimeout(saveTimer);
      saveTimer = setTimeout(function () {
        sessionStorage.setItem(storageKey, String(Math.round(menu.scrollLeft)));
      }, 20);
    }, { passive: true });

    // Save immediately before navigating to another admin page.
    menu.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        sessionStorage.setItem(storageKey, String(Math.round(menu.scrollLeft)));
      });
    });

    // Prevent browser scroll anchoring from unexpectedly shifting the menu.
    if ('overflowAnchor' in menu.style) {
      menu.style.overflowAnchor = 'none';
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminMobileMenu);
  } else {
    initAdminMobileMenu();
  }
})();
