(function () {
  "use strict";

  var ctaLinks = document.querySelectorAll('a[href="https://forms.gle/gV1wny8C8a"]');
  ctaLinks.forEach(function (link) {
    link.addEventListener("click", function () {
      link.classList.add("is-clicked");
      window.setTimeout(function () {
        link.classList.remove("is-clicked");
      }, 180);
    });
  });
})();
