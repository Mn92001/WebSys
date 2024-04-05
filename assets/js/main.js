function activateMenu() {
    const navLinks = document.querySelectorAll('nav a');
    navLinks.forEach(link => {
        if (link.href === location.href) {
            link.classList.add('active');
        }
    })
}


var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-100px";
  }
  prevScrollpos = currentScrollPos;
}

document.addEventListener('DOMContentLoaded', function() {
  var navbarToggler = document.querySelector('.navbar-toggler');
  var navbarMenu = document.querySelector('.collapse.navbar-collapse');

  navbarToggler.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default anchor click behavior
    var bsCollapse = new bootstrap.Collapse(navbarMenu, {
      toggle: false
    });
    // Toggle the "show" class manually
    if (navbarMenu.classList.contains('show')) {
      bsCollapse.hide();
    } else {
      bsCollapse.show();
    }
  });
});
