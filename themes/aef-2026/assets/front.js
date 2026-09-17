(function () {
  var burger = document.querySelector('.burger');
  var nav = document.querySelector('.nav');
  var header = document.querySelector('.header');
  var scrim = document.getElementById('aef-nav-scrim');
  var mega = document.getElementById('aef-mega');
  var track = mega ? mega.querySelector('.mega-track') : null;
  var order = ['about', 'topics', 'programme', 'speakers', 'media', 'support'];
  var hideTimer;

  function isCompact() {
    var vi = document.documentElement.getAttribute('lang') === 'vi';
    return window.matchMedia(vi ? '(max-width: 1240px)' : '(max-width: 1180px)').matches;
  }

  function placeDrawer() {
    if (!header) return;
    var bottom = Math.round(header.getBoundingClientRect().bottom);
    document.documentElement.style.setProperty('--aef-header-bottom', bottom + 'px');
    if (!nav) return;
    if (isCompact()) {
      nav.style.top = '0';
      nav.style.maxHeight = 'none';
      if (scrim) scrim.style.top = '0';
    } else {
      nav.style.top = '';
      nav.style.maxHeight = '';
      nav.style.transform = '';
      if (scrim) scrim.style.top = '';
    }
  }

  function setBurgerLabel(open) {
    if (!burger) return;
    var txt = burger.querySelector('.burger-txt');
    var label = open ? burger.getAttribute('data-close') : burger.getAttribute('data-open');
    if (txt && label) txt.textContent = label;
    burger.setAttribute('aria-label', open
      ? (document.documentElement.getAttribute('lang') === 'vi' ? 'Đóng menu' : 'Close menu')
      : (document.documentElement.getAttribute('lang') === 'vi' ? 'Mở menu' : 'Open menu'));
  }

  function setOpen(open) {
    if (!nav || !burger) return;
    nav.classList.toggle('open', open);
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.classList.toggle('nav-open', open);
    if (scrim) {
      scrim.hidden = !open;
      scrim.classList.toggle('is-on', open);
    }
    setBurgerLabel(open);
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

  if (scrim) {
    scrim.addEventListener('click', function () { setOpen(false); });
  }

  window.addEventListener('resize', function () {
    placeDrawer();
    if (!isCompact()) setOpen(false);
    else if (nav && nav.classList.contains('open')) placeDrawer();
  });
  placeDrawer();

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
    var slug = b.getAttribute('data-f') || 'all';
    document.querySelectorAll('#prog .rail').forEach(function (r) {
      r.style.display = (slug === 'all' || r.getAttribute('data-day') === slug) ? '' : 'none';
    });
    if (dayEl) {
      dayEl.value = slug;
      if (typeof filterAgenda === 'function') filterAgenda();
    }
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
    if (df && dayEl) {
      df.querySelectorAll('.chip').forEach(function (c) {
        c.setAttribute('aria-pressed', c.getAttribute('data-f') === dayEl.value ? 'true' : 'false');
      });
    }
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

  var partnerRoot = document.querySelector('[data-partner-carousel]');
  if (partnerRoot) {
    var partnerTrack = partnerRoot.querySelector('.partner-track');
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    function partnerStep() {
      var card = partnerTrack && partnerTrack.querySelector('.partner-slide');
      if (!card) return 240;
      var gap = parseFloat(window.getComputedStyle(partnerTrack).gap) || 20;
      return card.getBoundingClientRect().width + gap;
    }
    function partnerShift(dir) {
      if (!partnerTrack) return;
      partnerTrack.style.animation = 'none';
      var cur = partnerTrack.style.transform;
      var m = /translateX\((-?\d+(?:\.\d+)?)px\)/.exec(cur);
      var x = m ? parseFloat(m[1]) : 0;
      x -= dir * partnerStep();
      var half = partnerTrack.scrollWidth / 2;
      if (x <= -half) x += half;
      if (x > 0) x -= half;
      partnerTrack.style.transform = 'translateX(' + x + 'px)';
    }
    var prevBtn = partnerRoot.querySelector('[data-partner-prev]');
    var nextBtn = partnerRoot.querySelector('[data-partner-next]');
    if (prevBtn) prevBtn.addEventListener('click', function () { partnerShift(-1); });
    if (nextBtn) nextBtn.addEventListener('click', function () { partnerShift(1); });
    if (reduceMotion && partnerTrack) partnerTrack.style.animation = 'none';
  }

  // Trang Diễn giả: tìm theo tên/chức danh/tổ chức + lọc theo quốc gia — chỉ
  // chạy khi trang có ô lọc (archive-aef_speaker.php), quy mô nhỏ (vài trăm
  // thẻ) nên lọc thẳng trên trình duyệt, không cần gọi lại server.
  var spkFilterRoot = document.querySelector('[data-spk-filter]');
  if (spkFilterRoot) {
    var spkList = document.querySelector('[data-spk-list]');
    var spkCards = spkList ? Array.prototype.slice.call(spkList.querySelectorAll('[data-spk-search]')) : [];
    var spkInput = spkFilterRoot.querySelector('[data-spk-search-input]');
    var spkCountrySel = spkFilterRoot.querySelector('[data-spk-country-select]');
    var spkCount = spkFilterRoot.querySelector('[data-spk-count]');
    var spkEmpty = document.querySelector('[data-spk-empty]');
    var spkTotal = spkCards.length;
    function spkApply() {
      var q = spkInput ? spkInput.value.trim().toLowerCase() : '';
      var c = spkCountrySel ? spkCountrySel.value : '';
      var shown = 0;
      for (var i = 0; i < spkCards.length; i++) {
        var card = spkCards[i];
        var hitQ = !q || (card.getAttribute('data-spk-search') || '').indexOf(q) !== -1;
        var hitC = !c || card.getAttribute('data-spk-country') === c;
        var visible = hitQ && hitC;
        card.style.display = visible ? '' : 'none';
        if (visible) shown++;
      }
      if (spkCount) {
        var tpl = (document.documentElement.getAttribute('lang') === 'vi') ? 'Hiển thị {shown} trên {total}' : 'Showing {shown} of {total}';
        spkCount.textContent = tpl.replace('{shown}', String(shown)).replace('{total}', String(spkTotal));
      }
      if (spkEmpty) spkEmpty.hidden = shown !== 0;
    }
    if (spkInput) spkInput.addEventListener('input', spkApply);
    if (spkCountrySel) spkCountrySel.addEventListener('change', spkApply);
    spkApply();
  }

})();
