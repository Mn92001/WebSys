function activateMenu() {
    const navLinks = document.querySelectorAll('nav a');
    navLinks.forEach(link => {
        if (link.href === location.href) {
            link.classList.add('active');
        }
    })
}
