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
  var navbarMenu = document.querySelector('.collapse.navbar-collapse');

  navbarMenu.addEventListener('click', function(event) {
    // Check if the clicked element is the navbar toggler button
    if (event.target.classList.contains('navbar-toggler')) {
      event.preventDefault(); // Prevent the default anchor click behavior
      navbarMenu.classList.toggle('show'); // Toggle the 'show' class to expand or collapse the menu
    }
  });

  // Add an event listener to the document to collapse the navbar when clicking outside
  document.addEventListener('click', function(event) {
    if (!navbarMenu.contains(event.target) && !event.target.classList.contains('navbar-toggler')) {
      navbarMenu.classList.remove('show'); // Collapse the navbar menu if clicking outside
    }
  });
});

