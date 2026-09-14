(function () {
  var root = document.querySelector('.cs-count');
  if (root) {
    var raw = (root.getAttribute('data-target') || '').replace(/\s/g, '');
    var end = Date.parse(raw);
    if (isNaN(end)) {
      var p = raw.match(/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})([+-]\d{2}):?(\d{2})$/);
      if (p) {
        var sign = p[7].charAt(0) === '-' ? -1 : 1;
        end = Date.UTC(+p[1], +p[2] - 1, +p[3], +p[4] - parseInt(p[7], 10), +p[5] - sign * parseInt(p[8], 10), +p[6]);
      }
    }
    if (end && !isNaN(end)) {
      var dEl = root.querySelector('[data-u="d"]');
      var hEl = root.querySelector('[data-u="h"]');
      var mEl = root.querySelector('[data-u="m"]');
      var sEl = root.querySelector('[data-u="s"]');
      function pad(n) { return n < 10 ? '0' + n : String(n); }
      function tick() {
        var left = Math.max(0, end - Date.now());
        var s = Math.floor(left / 1000);
        var d = Math.floor(s / 86400); s -= d * 86400;
        var h = Math.floor(s / 3600); s -= h * 3600;
        var m = Math.floor(s / 60); s -= m * 60;
        if (dEl) dEl.textContent = String(d);
        if (hEl) hEl.textContent = pad(h);
        if (mEl) mEl.textContent = pad(m);
        if (sEl) sEl.textContent = pad(s);
      }
      tick();
      setInterval(tick, 1000);
    }
  }

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var a = document.querySelector('.cs-photo-a');
  var b = document.querySelector('.cs-photo-b');
  if (reduce || !a || !window.matchMedia('(pointer:fine)').matches) return;
  var x = 0, y = 0, tx = 0, ty = 0;
  document.addEventListener('mousemove', function (e) {
    tx = (e.clientX / window.innerWidth - 0.5) * 16;
    ty = (e.clientY / window.innerHeight - 0.5) * 10;
  });
  function loop() {
    x += (tx - x) * 0.06;
    y += (ty - y) * 0.06;
    a.style.translate = x + 'px ' + y + 'px';
    if (b) b.style.translate = (-x * 0.6) + 'px ' + (-y * 0.6) + 'px';
    requestAnimationFrame(loop);
  }
  requestAnimationFrame(loop);
})();
