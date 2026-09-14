(function () {
  "use strict";

  var menuToggle = document.querySelector(".menu-toggle");
  var mainNavigation = document.querySelector(".main-navigation");

  if (menuToggle && mainNavigation) {
    menuToggle.addEventListener("click", function () {
      var isOpen = mainNavigation.classList.toggle("is-open");
      menuToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });
  }

  var ctaLinks = document.querySelectorAll(".js-enroll-link");
  ctaLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      link.classList.add("is-clicked");
      window.setTimeout(function () {
        link.classList.remove("is-clicked");
      }, 180);
    });
  });
})();
