(function () {
  'use strict';

  /**
   *	Handles toggling of sidebar navigation submenus.
   */

  function toggleSidebarNavigationSubMenu() {
    const subMenu = document.getElementById(this.getAttribute('aria-controls'));

    if (this.getAttribute('aria-expanded') === 'false') {
      this.setAttribute('aria-expanded', 'true');
      this.setAttribute('aria-label', 'Hide');
      subMenu.hidden = false;
    } else {
      this.setAttribute('aria-expanded', 'false');
      this.setAttribute('aria-label', 'Show');
      subMenu.hidden = true;
    }
  }

  /**
   *	Sets the specs for the sidebar navigation hover.
   *
   *	@param	{Element}	el	HTML element being hovered (either <a> or <button>)
   */
  function setSidebarNavigationHoverSpecs(el) {
    const navmenu = document.querySelector('.sidenav'),
      hoverWidth = el.parentElement.getBoundingClientRect().width,
      hoverHeight = el.getBoundingClientRect().height;

    if (hoverWidth === 0 && hoverHeight === 0) {
      // handles case where .sub-menu is collapsed/current-menu-item is hidden and hover flies off the page
      navmenu.classList.remove('hasbg');
    } else {
      navmenu.classList.add('hasbg');

      // only update properties when visible (so hover does not fly into the page)
      // phire originally used
      // el.parentElement.getBoundingClientRect().left + window.pageXOffset
      // el.parentElement.getBoundingClientRect().top + window.pageYOffset
      navmenu.style.setProperty(
        '--left',
        `${
          el.parentElement.offsetLeft
        }px`
      );
      navmenu.style.setProperty(
        '--top',
        `${
          el.parentElement.offsetTop
        }px`
      );
      navmenu.style.setProperty('--width', `${hoverWidth}px`);
      navmenu.style.setProperty('--height', `${hoverHeight}px`);
    }
  }

  /**
   *	Handles hovering of sidebar navigation.
   */
  function handleSidebarNavigationHover() {
    const navmenu = document.querySelector('.sidenav'),
      navmenuLis = document.querySelectorAll('.sidenav li');

    navmenu.classList.add('hasbg');

    // set active <li>
    navmenuLis.forEach(function (el) {
      el.classList.remove('hovered');
    });
    this.parentElement.classList.add('hovered');

    setSidebarNavigationHoverSpecs(this);
  }

  /**
   *	Sets or resets the unhovered state for the sidebar navigation hover.
   */
  function resetSidebarNavigationHover() {
    const navmenu = document.querySelector('.sidenav'),
      navmenuLis = navmenu.querySelectorAll('li'),
      currentMenuLink = navmenu.querySelector('.current-menu-item > a');

    // set active <li>
    navmenuLis.forEach(function (el) {
      if (el.classList.contains('current-menu-item')) {
        el.classList.add('hovered');
      } else {
        el.classList.remove('hovered');
      }
    });

    if (currentMenuLink) {
      setSidebarNavigationHoverSpecs(currentMenuLink);
    } else {
      navmenu.classList.remove('hasbg');
    }
  }

  /**
   *	Handles updates for the sidebar navigation hover on viewport resize.
   */
  function handleSidebarNavigationResize() {
    const activeLink = document.querySelector('.sidenav li.hovered > *');

    if (!activeLink) {
      return;
    }

    setSidebarNavigationHoverSpecs(activeLink);
  }

  /**
   *	Sets up handling for the sidebar navigation block.
   */
  function setupSidebarNavigationMenu() {
    if (!document.querySelector('.sidenav')) {
      return;
    }

    const navmenu = document.querySelector('.sidenav'),
      submenus = navmenu.querySelectorAll('.sub-menu'),
      currentMenuLi = navmenu.querySelector('.current-menu-item'),
      robserver = new ResizeObserver(function () {
        handleSidebarNavigationResize();
      });

    submenus.forEach(function (el, i) {
      const theParentLink = el.parentElement.querySelector('a'),
        submenuToggler = document.createElement('button');

      theParentLink.id = `submenulink${i}`;

      el.id = `submenu${i}`;
      el.hidden = true;

      submenuToggler.type = 'button';
      submenuToggler.id = `flyoutbtn${i}`;
      submenuToggler.classList.add('submenutoggler');
      submenuToggler.setAttribute('aria-controls', `submenu${i}`);
      submenuToggler.setAttribute('aria-expanded', 'false');
      submenuToggler.setAttribute('aria-label', 'Show');
      submenuToggler.setAttribute(
        'aria-labelledby',
        `flyoutbtn${i} submenulink${i}`
      );
      submenuToggler.innerHTML =
        '<svg width="9" height="5" aria-hidden="true"><path d="m8.266 1.64-2.977 3a.826.826 0 0 1-.539.21.742.742 0 0 1-.54-.21l-2.976-3a.726.726 0 0 1-.187-.82.768.768 0 0 1 .703-.47h5.977c.304 0 .562.188.68.47.116.28.07.609-.141.82Z" fill="currentColor"></svg>';
      submenuToggler.addEventListener('click', toggleSidebarNavigationSubMenu);

      el.parentElement.insertBefore(submenuToggler, el);
    });

    // set initial state for submenu togglers
    if (currentMenuLi) {
      // set initial "hovered" <li>
      currentMenuLi.classList.add('hovered');

      let parentMenuItem = currentMenuLi.closest('.menu-item-has-children');

      while (parentMenuItem) {
        parentMenuItem.querySelector('.submenutoggler').click();
        parentMenuItem = parentMenuItem.parentElement.closest(
          '.menu-item-has-children'
        );
      }
    }

    navmenu.querySelectorAll('a, button').forEach(function (el) {
      el.addEventListener('mouseenter', handleSidebarNavigationHover);
    });

    navmenu.addEventListener('mouseleave', resetSidebarNavigationHover);

    robserver.observe(document.body);

    resetSidebarNavigationHover();
  }

  /**
   *	Wraps the content of `.link-arrow` links in a span (for CSS animation).
   */
  function setupArrowLinks() {
    const arrowLinks = document.querySelectorAll('.link-arrow');

    if (!arrowLinks.length) {
      return;
    }

    arrowLinks.forEach(function (el) {
      // don't wrap if the first and only child is already a span
      if (el.firstChild === el.lastChild && el.firstChild.tagName === 'SPAN') {
        return;
      }

      el.innerHTML = `<span>${el.innerHTML}</span>`;
    });
  }

  /**
   *	Enhances the back to top button.
   */
  function setupBackToTop() {
    const btt = document.querySelector('.btt-wrapper .btn');

    if (!btt) {
      return;
    }

    btt.addEventListener('click', function (evt) {
      evt.preventDefault();
      document.querySelector('#content').focus();
      document.querySelector('#content').scrollIntoView();
    });
  }

  /**
   *	Sets up the section jumper block.
   */
  function setupSectionJumper() {
    const sj = document.querySelector('.sj');

    if (!sj) {
      return;
    }

    // add [id] to all <h2> within the main content area if they don't already have one
    document.querySelectorAll('.twocol-main h2').forEach(function (el) {
      let slug = '';

      if (el.id) {
        return;
      }

      slug = el.textContent
        .replace(/ /g, '-')
        .replace(/[^A-Za-z0-9-]/g, '')
        .toLowerCase();

      if (document.querySelector(`#${slug}`)) {
        return;
      }

      el.id = slug;
    });

    sj.addEventListener('submit', function (evt) {
      const sectionID = `#${sj.querySelector('#sj').value}`,
        target = document.querySelector(sectionID),
        pageURL = new URL(document.URL);

      evt.preventDefault();

      if (!target) {
        return;
      }

      // add tabindex if necessary
      if (!target.getAttribute('tabindex')) {
        target.setAttribute('tabindex', '-1');
      }

      // update the page URL (to preserve history (but this only applies to [id]s defined in the HTML)
      pageURL.hash = sectionID;
      document.location.href = pageURL;

      // jump to the element
      target.focus();
    });

    sj.hidden = false;
  }

  /**
   *	Ensures Category & Tag <details> elements are open on desktop.
   */
  function setupCatTags() {
    const cattags = document.querySelectorAll('.cattags details');

    if (!cattags.length) {
      return;
    }

    if (!window.matchMedia('(min-width: 48em)').matches) {
      return;
    }

    cattags.forEach(function (el) {
      el.setAttribute('open', '');
    });
  }

  /**
   *	Toggles additional accessibility features of regions wrapping tables when wider than the viewport.
   *
   *	@param	{Element}	table	Possibly overflowing table.
   */
  function checkTableOverflow(table) {
    const tableWrapper = table.parentElement;

    if (
      tableWrapper.scrollWidth > tableWrapper.parentElement.offsetWidth ||
      tableWrapper.scrollWidth > document.body.offsetWidth
    ) {
      tableWrapper.tabIndex = 0;
      tableWrapper.setAttribute('role', 'region');

      if (table.dataset.labelid) {
        tableWrapper.setAttribute('aria-labelledby', table.dataset.labelid);
      }
    } else {
      tableWrapper.removeAttribute('tabindex');
      tableWrapper.removeAttribute('role');
      tableWrapper.removeAttribute('aria-labelledby');
    }
  }

  /**
   *	Sets up table block tables (for mobile/accessibility handling).
   */
  function setupTables() {
    document.querySelectorAll('.btable').forEach(function (el) {
      // determine if the accessibility enhancements need to be activated on each window resize
      const observer = new ResizeObserver(function (entries) {
        checkTableOverflow(entries[0].target);
      });
      observer.observe(el);

      // determine if the accessibility enhancements need to be activated on initial page load
      checkTableOverflow(el);
    });
  }

  /* **** */
  /* INIT */
  /* **** */

  document.documentElement.className =
    document.documentElement.className.replace(/\bno-js\b/, 'js');

  if (window.matchMedia('(prefers-reduced-motion: no-preference)').matches) {
    document.documentElement.classList.add('can-sscroll');
  }

  setupSidebarNavigationMenu();
  setupArrowLinks();
  setupBackToTop();
  setupSectionJumper();
  setupCatTags();
  setupTables();
})();
