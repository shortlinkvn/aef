(function () {
  var count = document.querySelector("[data-cx-count]");
  if (count) {
    var end = Date.parse(count.getAttribute("data-target") || "");
    function pad(n) {
      return n < 10 ? "0" + n : String(n);
    }
    function tick() {
      var left = Math.max(0, (end || 0) - Date.now());
      var s = Math.floor(left / 1000);
      var d = Math.floor(s / 86400);
      s -= d * 86400;
      var h = Math.floor(s / 3600);
      s -= h * 3600;
      var m = Math.floor(s / 60);
      s -= m * 60;
      var map = { d: String(d), h: pad(h), m: pad(m), s: pad(s) };
      count.querySelectorAll("[data-u]").forEach(function (el) {
        var k = el.getAttribute("data-u");
        if (k && map[k] != null) el.textContent = map[k];
      });
    }
    if (end) {
      tick();
      setInterval(tick, 1000);
    }
  }

  var burger = document.querySelector("[data-cx-burger]");
  var nav = document.querySelector("[data-cx-nav]");
  if (burger && nav) {
    burger.addEventListener("click", function () {
      var open = !nav.classList.contains("is-open");
      nav.classList.toggle("is-open", open);
      burger.setAttribute("aria-expanded", open ? "true" : "false");
      document.body.classList.toggle("cx-nav-open", open);
    });
    nav.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () {
        nav.classList.remove("is-open");
        burger.setAttribute("aria-expanded", "false");
        document.body.classList.remove("cx-nav-open");
      });
    });
  }

  var float = document.querySelector("[data-cx-float]");
  if (float) {
    var onScroll = function () {
      float.classList.toggle("is-in", window.scrollY > 420);
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  var spec = document.querySelector("[data-cx-spec]");
  var specBtn = document.querySelector("[data-cx-spec-toggle]");
  if (spec && specBtn) {
    var openSpec = function (on) {
      spec.classList.toggle("is-open", on);
      specBtn.setAttribute("aria-expanded", on ? "true" : "false");
    };
    specBtn.addEventListener("click", function () {
      openSpec(!spec.classList.contains("is-open"));
    });
    if (window.location.hash === "#cx-spec") openSpec(true);
  }
})();
