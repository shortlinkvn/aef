(function () {
  var burger = document.querySelector('.burger');
  var nav = document.querySelector('.nav');
  var header = document.querySelector('.header');
  var mega = document.getElementById('aef-mega');
  var track = mega ? mega.querySelector('.mega-track') : null;
  var order = ['about', 'topics', 'programme', 'speakers', 'media', 'support'];
  var hideTimer;

  function isCompact() {
    return window.matchMedia('(max-width: 1180px)').matches;
  }

  function placeDrawer() {
    if (!nav || !header) return;
    var bottom = Math.round(header.getBoundingClientRect().bottom);
    nav.style.top = bottom + 'px';
    nav.style.maxHeight = Math.max(160, window.innerHeight - bottom) + 'px';
  }

  function setOpen(open) {
    if (!nav || !burger) return;
    nav.classList.toggle('open', open);
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.classList.toggle('nav-open', open);
    if (open) {
      hideMega();
      placeDrawer();
    }
  }

  if (burger && nav) {
    burger.addEventListener('click', function () {
      setOpen(!nav.classList.contains('open'));
    });
    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        if (isCompact()) setOpen(false);
      });
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      setOpen(false);
      hideMega();
    }
  });

  window.addEventListener('resize', function () {
    if (!isCompact()) setOpen(false);
    else if (nav && nav.classList.contains('open')) placeDrawer();
  });

  function showPanel(name) {
    if (!mega || !track || isCompact()) return;
    var idx = order.indexOf(name);
    if (idx < 0) {
      hideMega();
      return;
    }
    mega.hidden = false;
    mega.classList.add('is-open');
    if (header) header.classList.add('mega-open');
    track.style.transform = 'translateX(-' + (idx * (100 / 6)) + '%)';
    mega.querySelectorAll('.mega-panel').forEach(function (p) {
      p.classList.toggle('is-current', p.getAttribute('data-panel') === name);
    });
    document.querySelectorAll('.nav-item.has-mega').forEach(function (el) {
      el.classList.toggle('on', el.getAttribute('data-panel') === name);
    });
  }

  function hideMega() {
    if (!mega) return;
    mega.classList.remove('is-open');
    if (header) header.classList.remove('mega-open');
    mega.hidden = true;
    document.querySelectorAll('.nav-item.has-mega').forEach(function (el) {
      el.classList.remove('on');
    });
  }

  document.querySelectorAll('.nav-item.has-mega').forEach(function (item) {
    item.addEventListener('mouseenter', function () {
      if (isCompact()) return;
      clearTimeout(hideTimer);
      showPanel(item.getAttribute('data-panel'));
    });
    item.addEventListener('focusin', function () {
      if (isCompact()) return;
      clearTimeout(hideTimer);
      showPanel(item.getAttribute('data-panel'));
    });
  });
  document.querySelectorAll('.nav-item:not(.has-mega)').forEach(function (item) {
    item.addEventListener('mouseenter', function () {
      if (isCompact()) return;
      hideTimer = setTimeout(hideMega, 80);
    });
  });
  if (header) {
    header.addEventListener('mouseleave', function () {
      hideTimer = setTimeout(hideMega, 160);
    });
  }
  if (mega) {
    mega.addEventListener('mouseenter', function () { clearTimeout(hideTimer); });
  }

  window.addEventListener('scroll', function () {
    if (header) header.classList.toggle('small', window.scrollY > 90);
    if (nav && nav.classList.contains('open')) placeDrawer();
  }, { passive: true });

  var io = 'IntersectionObserver' in window ? new IntersectionObserver(function (es) {
    es.forEach(function (e) {
      if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
    });
  }, { rootMargin: '0px 0px -8% 0px' }) : null;
  if (io) document.querySelectorAll('.rv').forEach(function (el) { io.observe(el); });

  var df = document.querySelector('#dayfilter');
  function applyDayFilter(slug) {
    if (!df) return;
    var btn = df.querySelector('[data-f="' + slug + '"]') || df.querySelector('[data-f="all"]');
    if (!btn) return;
    df.querySelectorAll('.chip').forEach(function (c) { c.setAttribute('aria-pressed', c === btn ? 'true' : 'false'); });
    document.querySelectorAll('#prog .rail').forEach(function (r) {
      r.style.display = (slug === 'all' || r.getAttribute('data-day') === slug) ? '' : 'none';
    });
  }
  if (window.location.hash.indexOf('#day-') === 0) {
    applyDayFilter(window.location.hash.replace('#day-', ''));
  }
  if (df) df.addEventListener('click', function (e) {
    var b = e.target.closest('.chip');
    if (!b) return;
    df.querySelectorAll('.chip').forEach(function (c) { c.setAttribute('aria-pressed', c === b ? 'true' : 'false'); });
    document.querySelectorAll('#prog .rail').forEach(function (r) {
      r.style.display = (b.getAttribute('data-f') === 'all' || r.getAttribute('data-day') === b.getAttribute('data-f')) ? '' : 'none';
    });
  });

  var qEl = document.getElementById('programme-query');
  var dayEl = document.getElementById('day-filter');
  var roomEl = document.getElementById('room-filter');
  var topicEl = document.getElementById('topic-filter');
  var emptyEl = document.getElementById('agenda-empty');
  var countEl = document.getElementById('agenda-count');
  function filterAgenda() {
    var cards = document.querySelectorAll('.agenda-card');
    if (!cards.length) return;
    var q = qEl ? qEl.value.toLowerCase().trim() : '';
    var day = dayEl ? dayEl.value : 'all';
    var room = roomEl ? roomEl.value : 'all';
    var topic = topicEl ? topicEl.value : 'all';
    var shown = 0;
    cards.forEach(function (card) {
      var ok = true;
      if (day !== 'all' && card.getAttribute('data-day') !== day) ok = false;
      if (room !== 'all' && card.getAttribute('data-room') !== room) ok = false;
      if (topic !== 'all') {
        var tags = (card.getAttribute('data-tags') || '').split('|');
        if (tags.indexOf(topic) === -1) ok = false;
      }
      if (q && (card.getAttribute('data-q') || '').indexOf(q) === -1) ok = false;
      card.style.display = ok ? '' : 'none';
      if (ok) shown++;
    });
    document.querySelectorAll('#prog .rail').forEach(function (rail) {
      var any = rail.querySelector('.agenda-card:not([style*="display: none"])');
      rail.style.display = any ? '' : 'none';
    });
    if (emptyEl) emptyEl.hidden = shown !== 0;
    if (countEl) countEl.textContent = shown + ' / ' + cards.length;
  }
  [qEl, dayEl, roomEl, topicEl].forEach(function (el) {
    if (!el) return;
    el.addEventListener(el.tagName === 'INPUT' ? 'input' : 'change', filterAgenda);
  });
  if (qEl || dayEl) filterAgenda();

  var tabs = document.querySelectorAll('.home-programme [role="tab"]');
  if (tabs.length) {
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) { t.setAttribute('aria-selected', t === tab ? 'true' : 'false'); });
        document.querySelectorAll('.home-programme [role="tabpanel"]').forEach(function (panel) {
          panel.hidden = panel.id !== 'home-panel-' + tab.getAttribute('data-day');
        });
      });
    });
  }
})();
