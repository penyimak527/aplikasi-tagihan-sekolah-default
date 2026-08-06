(function () {
    var html = document.documentElement;
    var stored = null;

    try {
        stored = JSON.parse(sessionStorage.getItem('__ADMINTO_CONFIG__') || 'null');
    } catch (error) {
        stored = null;
    }

    var theme = stored && stored.theme ? stored.theme : (html.getAttribute('data-bs-theme') || 'light');
    var sidenavSize = window.innerWidth <= 1140 ? 'full' : 'default';

    window.config = {
        theme: theme,
        layout: {mode: 'fluid'},
        topbar: {color: 'light'},
        menu: {color: 'light'},
        sidenav: {size: sidenavSize}
    };
    window.defaultConfig = JSON.parse(JSON.stringify(window.config));

    html.setAttribute('data-bs-theme', theme);
    html.setAttribute('data-layout-mode', 'fluid');
    html.setAttribute('data-topbar-color', 'light');
    html.setAttribute('data-menu-color', 'light');
    html.setAttribute('data-sidenav-size', sidenavSize);
})();
