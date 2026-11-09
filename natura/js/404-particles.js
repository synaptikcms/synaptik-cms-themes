(function () {
  'use strict';

  /* ── Stars ────────────────────────────────────────────────── */
  const starsEl = document.getElementById('stars');
  const starData = [
    {x:8,y:6,r:1.5,dur:2.8,del:0},{x:15,y:12,r:1,dur:3.5,del:.5},
    {x:25,y:5,r:1.2,dur:2.2,del:1},{x:38,y:9,r:1.5,dur:3,del:.2},
    {x:50,y:4,r:1,dur:4,del:1.5},{x:62,y:11,r:1.3,dur:2.6,del:.8},
    {x:72,y:6,r:1,dur:3.2,del:0},{x:82,y:3,r:1.5,dur:2.9,del:.4},
    {x:88,y:10,r:1.2,dur:3.7,del:1.2},{x:94,y:5,r:1,dur:2.5,del:.6},
    {x:30,y:16,r:.8,dur:4.2,del:2},{x:55,y:8,r:.9,dur:3.4,del:1.8},
    {x:45,y:15,r:1.1,dur:2.7,del:.9},{x:78,y:14,r:.8,dur:3.9,del:.3},
    {x:20,y:20,r:1,dur:2.4,del:1.7},{x:68,y:18,r:.7,dur:4.1,del:2.1},
    {x:92,y:20,r:1.2,dur:3.1,del:.7},{x:5,y:22,r:.9,dur:2.8,del:1.1},
  ];
  starData.forEach(function(s) {
    var el = document.createElement('div');
    el.className = 'star';
    el.style.cssText = [
      'left:' + s.x + '%;',
      'top:' + s.y + '%;',
      'width:' + s.r * 2 + 'px;',
      'height:' + s.r * 2 + 'px;',
      '--dur:' + s.dur + 's;',
      '--delay:' + (-s.del) + 's;',
    ].join('');
    starsEl.appendChild(el);
  });

  /* ── Fireflies ────────────────────────────────────────────── */
  var fffContainer = document.getElementById('fireflies');
  var ffCount = 18;
  for (var i = 0; i < ffCount; i++) {
    var ff = document.createElement('div');
    ff.className = 'firefly';
    var dur   = 6 + Math.random() * 10;
    var delay = -(Math.random() * dur);
    var x1 = (Math.random() - .5) * 80, y1 = -20 - Math.random() * 60;
    var x2 = (Math.random() - .5) * 60, y2 = -40 - Math.random() * 80;
    var x3 = (Math.random() - .5) * 100,y3 = -10 - Math.random() * 50;
    ff.style.cssText = [
      'left:' + (15 + Math.random() * 70) + '%;',
      'top:'  + (30 + Math.random() * 55) + '%;',
      '--ff-dur:'   + dur + 's;',
      '--ff-delay:' + delay + 's;',
      '--fx1:' + x1 + 'px;--fy1:' + y1 + 'px;',
      '--fx2:' + x2 + 'px;--fy2:' + y2 + 'px;',
      '--fx3:' + x3 + 'px;--fy3:' + y3 + 'px;',
    ].join('');
    fffContainer.appendChild(ff);
  }

  /* ── Parallax on mouse move ───────────────────────────────── */
  var moon    = document.querySelector('.moon');
  var content = document.querySelector('.content-404');
  var page    = document.querySelector('.page-404');

  page.addEventListener('mousemove', function(e) {
    var cx = window.innerWidth / 2;
    var cy = window.innerHeight / 2;
    var dx = (e.clientX - cx) / cx;  // -1 … 1
    var dy = (e.clientY - cy) / cy;

    if (moon)    moon.style.transform    = 'translateX(calc(-50% + ' + (dx * 14) + 'px)) translateY(' + (dy * 8) + 'px)';
    if (content) content.style.transform = 'translateY(' + (dy * -6) + 'px)';
  });

})();
