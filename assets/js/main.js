/* ===================================================================
   CẤU HÌNH — chỉnh tại đây
   =================================================================== */
const CONFIG = Object.assign({
    hotline: '0901234567',
    zalo: '0901234567',
    webhookUrl: '',
    ajaxUrl: '',
    nonce: '',
    gifts: [
        { label: 'Giảm 20%',        color: '#ffb5c8', weight: 2 },
        { label: 'Khăn tắm xinh',   color: '#fff6d6', weight: 3 },
        { label: 'Freeship',        color: '#b8f0d8', weight: 3 },
        { label: 'Giảm 30%',        color: '#d9cbff', weight: 1 },
        { label: 'Vịt tắm cute',    color: '#e3f7fa', weight: 3 },
        { label: 'Mua 2 tặng 1',    color: '#ffe08a', weight: 1 }
    ]
}, window.BONBON_CONFIG || {});

function bootBonBon() {
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, Draggable);
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = window.matchMedia('(pointer: fine)').matches;
const $ = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];
const store = {
    get(k) { try { return localStorage.getItem(k); } catch (e) { return null; } },
    set(k, v) { try { localStorage.setItem(k, v); } catch (e) {} }
};

/* ===== CONTACT LINKS ===== */
$$('[data-tel]').forEach(a => { a.href = 'tel:' + CONFIG.hotline; });
$$('[data-tel-text]').forEach(a => { a.textContent = CONFIG.hotline.replace(/(\d{4})(\d{3})(\d+)/, '$1.$2.$3'); });
$$('[data-zalo]').forEach(a => { a.href = 'https://zalo.me/' + CONFIG.zalo; });
$('#year').textContent = new Date().getFullYear();

/* ===== BOTTLE SVG ===== */
let bottleUid = 0;
function bottleSVG(withFill) {
    const id = 'b' + (++bottleUid);
    return `
    <svg viewBox="0 0 200 320" xmlns="http://www.w3.org/2000/svg" aria-label="Lọ sữa tắm gội Bon Bon">
        <defs>
            <linearGradient id="${id}g" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#7fdbe8"/><stop offset=".5" stop-color="#4cc0d3"/><stop offset="1" stop-color="#2a9fb3"/>
            </linearGradient>
            <clipPath id="${id}c"><rect x="30" y="66" width="140" height="240" rx="50"/></clipPath>
        </defs>
        <g class="pump">
            <rect x="100" y="12" width="52" height="13" rx="6.5" fill="#fff" stroke="#cfeff4" stroke-width="2"/>
            <rect x="88" y="10" width="24" height="42" rx="7" fill="#fff" stroke="#cfeff4" stroke-width="2"/>
        </g>
        <rect x="76" y="48" width="48" height="24" rx="9" fill="#ffb5c8"/>
        <rect x="30" y="66" width="140" height="240" rx="50" fill="url(#${id}g)"/>
        ${withFill ? `<g clip-path="url(#${id}c)"><rect class="liquid" x="20" y="306" width="160" height="260" fill="#ffffff" opacity=".35"/></g>` : ''}
        <rect x="46" y="92" width="14" height="110" rx="7" fill="#fff" opacity=".35"/>
        <g class="face">
            <g class="eyes">
                <ellipse cx="80" cy="116" rx="7" ry="8.5" fill="#2b3a4a"/><circle cx="82.5" cy="113" r="2.4" fill="#fff"/>
                <ellipse cx="120" cy="116" rx="7" ry="8.5" fill="#2b3a4a"/><circle cx="122.5" cy="113" r="2.4" fill="#fff"/>
            </g>
            <ellipse cx="64" cy="132" rx="9" ry="5.5" fill="#ffb5c8" opacity=".9"/>
            <ellipse cx="136" cy="132" rx="9" ry="5.5" fill="#ffb5c8" opacity=".9"/>
            <path class="mouth" d="M90 128 Q100 141 110 128" fill="none" stroke="#2b3a4a" stroke-width="4" stroke-linecap="round"/>
        </g>
        <rect x="50" y="152" width="100" height="112" rx="26" fill="#fff"/>
        <text x="100" y="196" text-anchor="middle" font-family="Baloo 2, sans-serif" font-weight="800" font-size="30" fill="#2a9fb3" textLength="86" lengthAdjust="spacingAndGlyphs">Bon Bon</text>
        <text x="100" y="220" text-anchor="middle" font-family="Nunito, sans-serif" font-weight="800" font-size="14" fill="#34495e">Sữa tắm gội</text>
        <text x="100" y="242" text-anchor="middle" font-family="Nunito, sans-serif" font-weight="700" font-size="12" fill="#ff8fab">2in1 • cho bé</text>
        <circle cx="152" cy="282" r="6" fill="#fff" opacity=".5"/><circle cx="140" cy="292" r="3.5" fill="#fff" opacity=".5"/>
    </svg>`;
}
$$('[data-bottle]').forEach(el => { el.innerHTML = bottleSVG(el.dataset.bottle === 'lab'); });

// Blink all bottles
if (!reduceMotion) {
    $$('[data-bottle] .eyes').forEach(eyes => {
        gsap.set(eyes, { transformOrigin: '50% 50%', transformBox: 'fill-box' });
        gsap.timeline({ repeat: -1, repeatDelay: 2.6, delay: Math.random() * 2 })
            .to(eyes, { scaleY: .1, duration: .09 }).to(eyes, { scaleY: 1, duration: .12 });
    });
}

/* ===== TOAST ===== */
gsap.set('#toast', { xPercent: -50, y: -30 });
function toast(html, ms = 3200) {
    const t = $('#toast');
    t.innerHTML = html;
    gsap.killTweensOf(t);
    gsap.timeline()
        .to(t, { opacity: 1, y: 0, duration: .45, ease: 'back.out(2)' })
        .to(t, { opacity: 0, y: -30, duration: .35, delay: ms / 1000 });
}

/* ===== SMOOTH ANCHOR SCROLL ===== */
$$('.js-scroll').forEach(a => a.addEventListener('click', e => {
    const href = a.getAttribute('href');
    if (!href || !href.startsWith('#')) return;
    const target = $(href);
    if (!target) return;
    e.preventDefault();
    gsap.to(window, { scrollTo: { y: target, offsetY: href === '#top' ? 0 : 70 }, duration: 1.1, ease: 'power3.inOut' });
}));

/* ===== HEADER & PROGRESS ===== */
const header = $('#header');
let lastY = 0;
ScrollTrigger.create({
    start: 0, end: 'max',
    onUpdate(self) {
        const y = self.scroll();
        header.classList.toggle('scrolled', y > 40);
        header.classList.toggle('hide', y > 500 && y > lastY);
        lastY = y;
        gsap.set('#progressBar', { scaleX: self.progress });
        gsap.set('#progressDuck', { left: (self.progress * 100) + '%' });
        $('#stickyBar').classList.toggle('show', y > window.innerHeight * .6);
    }
});

/* ===== HERO INTRO ===== */
const heroTl = gsap.timeline({ defaults: { ease: 'power4.out' } });
heroTl
    .from('.hero-title .line > span', { yPercent: 110, rotate: 4, duration: 1, stagger: .12 })
    .from('[data-hero]', { y: 30, opacity: 0, duration: .8, stagger: .08 }, '-=.6')
    .from('.hero-blob', { scale: .4, opacity: 0, duration: 1.2, ease: 'elastic.out(1, .6)' }, 0.1)
    .from('#heroBottle', { y: 200, rotate: -20, opacity: 0, duration: 1.3, ease: 'elastic.out(1, .55)' }, .3)
    .from('.hero-badge', { scale: 0, opacity: 0, duration: .7, stagger: .15, ease: 'back.out(2.2)' }, .9)
    .from('#heroDuck', { x: 120, rotate: 40, opacity: 0, duration: 1, ease: 'back.out(2)' }, 1.1)
    .from('.hero-star', { scale: 0, duration: .6, stagger: .1, ease: 'back.out(3)' }, 1.2);

if (!reduceMotion) {
    gsap.to('.hero-badge', { y: '+=14', duration: 2.4, ease: 'sine.inOut', yoyo: true, repeat: -1, stagger: { each: .6 } });
    gsap.to('.hero-star', { rotate: 20, scale: 1.2, duration: 1.6, ease: 'sine.inOut', yoyo: true, repeat: -1, stagger: .4 });
    gsap.to('#heroDuck', { rotate: 8, y: -8, duration: 1.3, ease: 'sine.inOut', yoyo: true, repeat: -1 });
}

// Hero bottle: draggable, springs back + floating idle + parallax tilt
const heroBottle = $('#heroBottle');
const bottleIdle = reduceMotion ? null : gsap.to(heroBottle.querySelector('svg'), { y: -16, rotate: 2, duration: 2.2, ease: 'sine.inOut', yoyo: true, repeat: -1 });
Draggable.create(heroBottle, {
    type: 'x,y',
    onPress() { bottleIdle && bottleIdle.pause(); gsap.to(heroBottle.querySelector('.mouth'), { attr: { d: 'M88 126 Q100 146 112 126' }, duration: .2 }); },
    onDrag() { gsap.to(heroBottle, { rotate: gsap.utils.clamp(-25, 25, this.deltaX * 2), duration: .3 }); },
    onRelease() {
        gsap.to(heroBottle, { x: 0, y: 0, rotate: 0, duration: 1.2, ease: 'elastic.out(1, .4)' });
        gsap.to(heroBottle.querySelector('.mouth'), { attr: { d: 'M90 128 Q100 141 110 128' }, duration: .3 });
        bottleIdle && bottleIdle.resume();
        squirtBubbles(heroBottle);
    }
});
function squirtBubbles(el) {
    const r = el.getBoundingClientRect();
    for (let i = 0; i < 8; i++) {
        spawnCursorBubble(r.left + r.width * .75, r.top + r.height * .06, true);
    }
}
if (finePointer && !reduceMotion) {
    const hv = $('.hero-visual');
    hv.addEventListener('mousemove', e => {
        const r = hv.getBoundingClientRect();
        const px = (e.clientX - r.left) / r.width - .5, py = (e.clientY - r.top) / r.height - .5;
        gsap.to('.hero-blob', { x: px * -30, y: py * -30, duration: 1 });
        gsap.to('.hero-badge', { x: px * 24, duration: 1 });
        gsap.to(heroBottle.querySelector('.eyes'), { x: px * 8, y: py * 6, duration: .4 });
    });
}

// Duck squeak
$('#heroDuck').addEventListener('click', () => {
    gsap.fromTo('#heroDuck', { scaleX: 1.3, scaleY: .7 }, { scaleX: 1, scaleY: 1, duration: .8, ease: 'elastic.out(1.2, .3)' });
    toast('🐤 Quạc quạc! Giờ tắm vui quá mẹ ơi!', 1800);
});

/* ===== HERO BUBBLES (click to pop) ===== */
const bubbleBox = $('#heroBubbles');
let pops = 0;
function makeBubble(initial) {
    const b = document.createElement('div');
    b.className = 'bubble';
    const size = gsap.utils.random(26, 86);
    const W = bubbleBox.clientWidth, H = bubbleBox.clientHeight;
    gsap.set(b, { width: size, height: size, left: gsap.utils.random(0, W - size), top: initial ? gsap.utils.random(H * .2, H) : H + 20 });
    bubbleBox.appendChild(b);
    const dur = gsap.utils.random(9, 18);
    const rise = gsap.to(b, { y: -(H + 160), duration: initial ? dur * .7 : dur, ease: 'none', onComplete: () => { b.remove(); makeBubble(false); } });
    gsap.to(b, { x: '+=' + gsap.utils.random(-40, 40), duration: gsap.utils.random(2, 4), ease: 'sine.inOut', yoyo: true, repeat: -1 });
    b.addEventListener('pointerdown', e => {
        e.stopPropagation();
        rise.kill(); gsap.killTweensOf(b);
        const r = b.getBoundingClientRect(), br = bubbleBox.getBoundingClientRect();
        popBurst(r.left - br.left + r.width / 2, r.top - br.top + r.height / 2);
        gsap.to(b, { scale: 1.5, opacity: 0, duration: .22, ease: 'power2.out', onComplete: () => { b.remove(); makeBubble(false); } });
        pops++;
        const pc = $('#popCount');
        pc.textContent = pops;
        gsap.fromTo(pc, { scale: 1.8 }, { scale: 1, duration: .5, ease: 'back.out(3)' });
        if (pops === 5) toast('<i class="bb"></i> Mẹ bóp bong bóng giỏi quá! Thử <a href="#quiz" class="js-scroll-inline">quiz da bé</a> nhé', 3500);
        if (pops === 12) toast('🎁 Phần thưởng cho mẹ chăm chỉ: <a href="#vong-quay" class="js-scroll-inline">quay quà ngay</a>', 4000);
    });
}
const bubbleCount = reduceMotion ? 0 : (window.innerWidth < 768 ? 6 : 14);
for (let i = 0; i < bubbleCount; i++) makeBubble(true);
function popBurst(x, y) {
    const colors = ['#4cc0d3', '#ffb5c8', '#ffe08a', '#b8f0d8'];
    for (let i = 0; i < 10; i++) {
        const p = document.createElement('span');
        p.className = 'pop-particle';
        p.style.background = colors[i % 4];
        p.style.left = x + 'px'; p.style.top = y + 'px';
        bubbleBox.appendChild(p);
        const a = (Math.PI * 2 / 10) * i, d = gsap.utils.random(30, 70);
        gsap.to(p, { x: Math.cos(a) * d, y: Math.sin(a) * d, scale: 0, duration: .6, ease: 'power3.out', onComplete: () => p.remove() });
    }
}
document.addEventListener('click', e => {
    const a = e.target.closest('.js-scroll-inline');
    if (!a) return;
    e.preventDefault();
    gsap.to(window, { scrollTo: { y: a.getAttribute('href'), offsetY: 70 }, duration: 1.1, ease: 'power3.inOut' });
});

/* ===== CURSOR BUBBLE TRAIL ===== */
function spawnCursorBubble(x, y, burst) {
    const s = document.createElement('span');
    s.className = 'cursor-bubble';
    const size = gsap.utils.random(6, burst ? 22 : 14);
    gsap.set(s, { width: size, height: size, left: x - size / 2, top: y - size / 2 });
    document.body.appendChild(s);
    gsap.to(s, {
        x: gsap.utils.random(burst ? 10 : -20, burst ? 90 : 20), y: gsap.utils.random(burst ? -80 : -50, burst ? 20 : -20),
        opacity: 0, scale: burst ? 1.4 : .4, duration: gsap.utils.random(.7, 1.3), ease: 'power2.out', onComplete: () => s.remove()
    });
}
if (finePointer && !reduceMotion) {
    let lastT = 0;
    window.addEventListener('mousemove', e => {
        const now = performance.now();
        if (now - lastT < 70) return;
        lastT = now;
        spawnCursorBubble(e.clientX, e.clientY, false);
    }, { passive: true });

    // Magnetic buttons
    $$('.magnetic').forEach(btn => {
        btn.addEventListener('mousemove', e => {
            const r = btn.getBoundingClientRect();
            gsap.to(btn, { x: (e.clientX - r.left - r.width / 2) * .25, y: (e.clientY - r.top - r.height / 2) * .35, duration: .4 });
        });
        btn.addEventListener('mouseleave', () => gsap.to(btn, { x: 0, y: 0, duration: .7, ease: 'elastic.out(1, .4)' }));
    });
}

/* ===== MARQUEE ===== */
const mq = $('#marqueeTrack');
mq.innerHTML += mq.innerHTML;
const mqTween = gsap.to(mq, { xPercent: -50, duration: 26, ease: 'none', repeat: -1 });
ScrollTrigger.create({
    onUpdate(self) { gsap.to(mqTween, { timeScale: self.direction * (1 + Math.min(Math.abs(self.getVelocity()) / 600, 3)), duration: .3, overwrite: true }); }
});

/* ===== GENERIC REVEAL ===== */
ScrollTrigger.batch('[data-reveal]', {
    start: 'top 88%',
    onEnter: batch => gsap.fromTo(batch, { opacity: 0, y: 50, scale: .96 }, { opacity: 1, y: 0, scale: 1, duration: .9, stagger: .12, ease: 'power3.out', overwrite: true }),
    once: true
});
$$('.section-title').forEach(t => {
    const hl = t.querySelector('.hl');
    if (!hl) return;
    gsap.from(hl, { scrollTrigger: { trigger: t, start: 'top 85%' }, color: '#34495e', duration: .8, delay: .3 });
});

/* ===== PAIN FLIP CARDS ===== */
$$('.flip-card').forEach(card => {
    const flip = () => {
        card.classList.toggle('flipped');
        if (card.classList.contains('flipped')) gsap.fromTo(card, { scale: .95 }, { scale: 1, duration: .6, ease: 'back.out(3)' });
    };
    card.addEventListener('click', flip);
    card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); flip(); } });
    if (!reduceMotion) gsap.to(card.querySelector('.flip-front .emo'), { rotate: 10, y: -6, duration: 1.2, yoyo: true, repeat: -1, ease: 'sine.inOut', delay: Math.random() });
});

/* ===== COMPARE SLIDER ===== */
(function () {
    const box = $('#compare'), handle = $('#cmpHandle'), top = $('#cmpTop');
    const setPos = x => {
        const w = box.clientWidth;
        x = gsap.utils.clamp(0, w, x);
        gsap.set(handle, { x });
        top.style.clipPath = `inset(0 0 0 ${x}px)`;
    };
    const drag = Draggable.create(handle, {
        type: 'x', bounds: box, trigger: handle.querySelector('.cmp-knob'),
        onDrag() { setPos(this.x); }
    })[0];
    const center = () => { setPos(box.clientWidth / 2); drag.update(); };
    center();
    window.addEventListener('resize', center);
    box.addEventListener('click', e => {
        if (e.target.closest('.cmp-knob')) return;
        const x = e.clientX - box.getBoundingClientRect().left;
        const o = { v: gsap.getProperty(handle, 'x') };
        gsap.to(o, { v: x, duration: .6, ease: 'power3.out', onUpdate: () => { setPos(o.v); drag.update(); } });
    });
    // Auto-demo when visible
    ScrollTrigger.create({
        trigger: box, start: 'top 70%', once: true,
        onEnter() {
            const w = box.clientWidth, o = { v: w / 2 };
            gsap.timeline({ onUpdate: () => { setPos(o.v); drag.update(); } })
                .to(o, { v: w * .2, duration: .8, ease: 'power2.inOut' })
                .to(o, { v: w * .8, duration: 1, ease: 'power2.inOut' })
                .to(o, { v: w * .5, duration: .8, ease: 'power2.inOut' });
        }
    });
})();

/* ===== INGREDIENTS GAME ===== */
(function () {
    const ING = [
        { ico: '🌰', name: 'Dầu Hạnh Nhân (Prunus Amygdalus Dulcis Oil)', text: 'Giàu Vitamin E và axit béo tự nhiên, nuôi dưỡng sâu, giảm khô rát, bong tróc và củng cố hàng rào bảo vệ da bé.' },
        { ico: '💊', name: 'Vitamin E (Tocopherol)', text: 'Chống oxy hóa, hỗ trợ bảo vệ da trước tác nhân môi trường và giúp da bé mịn màng.' },
        { ico: '💧', name: 'Aqua & Sodium Laureth Sulfate dịu nhẹ', text: 'Lấy đi bụi bẩn và mồ hôi hằng ngày một cách nhẹ nhàng mà không làm bít tắc lỗ chân lông.' }
    ];
    const BAD = { ico: '🙅', name: 'Không chứa Paraben!', text: 'Bon Bon nói "không" với Paraben để làn da non nớt của bé luôn được nâng niu dịu nhẹ nhất.' };
    const zone = $('#dropZone'), bottle = $('#labBottle'), info = $('#labInfo');
    const liquid = bottle.querySelector('.liquid');
    let done = 0;

    function showInfo(i) {
        const d = ING[i];
        info.innerHTML = `<span class="ico">${d.ico}</span><div><h4>${d.name}</h4><p>${d.text}</p></div>`;
        gsap.fromTo(info, { y: 20, opacity: 0, scale: .95 }, { y: 0, opacity: 1, scale: 1, duration: .5, ease: 'back.out(2)' });
    }
    function reject(chip, dragInst) {
        dragInst && dragInst.disable();
        chip.classList.add('rejected');
        gsap.timeline().to(bottle, { rotate: -8, duration: .08, yoyo: true, repeat: 5, ease: 'none' }).set(bottle, { rotate: 0 });
        gsap.to(bottle.querySelector('.mouth'), { attr: { d: 'M90 136 Q100 126 110 136' }, duration: .2, yoyo: true, repeat: 1, repeatDelay: 1 });
        gsap.to(chip, { x: 0, y: 0, duration: .8, ease: 'elastic.out(1, .5)' });
        info.innerHTML = `<span class="ico">${BAD.ico}</span><div><h4>${BAD.name}</h4><p>${BAD.text}</p></div>`;
        gsap.fromTo(info, { x: -12 }, { x: 0, duration: .5, ease: 'elastic.out(1.2, .3)' });
        toast('🙅 Bon Bon không chứa Paraben đâu mẹ ơi!');
    }
    function accept(chip, dragInst) {
        if (chip.classList.contains('used')) return;
        if (chip.classList.contains('bad')) return reject(chip, dragInst);
        const i = +chip.dataset.ing;
        const ico = chip.querySelector('.ico');
        const ir = ico.getBoundingClientRect(), br = bottle.getBoundingClientRect();
        const ghost = ico.cloneNode(true);
        gsap.set(ghost, { position: 'fixed', left: ir.left, top: ir.top, width: ir.width, height: ir.height, zIndex: 50, margin: 0 });
        document.body.appendChild(ghost);
        gsap.to(ghost, {
            x: br.left + br.width / 2 - (ir.left + ir.width / 2), y: br.top + br.height * .35 - (ir.top + ir.height / 2),
            scale: .3, rotate: 360, duration: .7, ease: 'power3.in', onComplete: () => ghost.remove()
        });
        chip.classList.add('used');
        dragInst && dragInst.disable();
        gsap.to(chip, { x: 0, y: 0, duration: .5 });
        done++;
        setTimeout(() => {
            gsap.fromTo(bottle, { scaleX: 1.12, scaleY: .9 }, { scaleX: 1, scaleY: 1, duration: .9, ease: 'elastic.out(1.2, .35)' });
            gsap.to(liquid, { attr: { y: 306 - (240 * done / ING.length) }, duration: .8, ease: 'power2.out' });
            gsap.to('#labBar', { width: (done / ING.length * 100) + '%', duration: .6, ease: 'back.out(2)' });
            $('#labCount').textContent = done;
            squirtBubbles(bottle);
            showInfo(i);
            if (done === ING.length) {
                $('#labDone').classList.add('show');
                gsap.from('#labDone .btn', { scale: 0, duration: .8, ease: 'elastic.out(1, .4)' });
                confetti(40);
                toast('🎉 Công thức Bon Bon hoàn chỉnh!');
            }
        }, 650);
    }
    $$('.chip').forEach(chip => {
        Draggable.create(chip, {
            type: 'x,y', zIndexBoost: true,
            onDrag() { zone.classList.toggle('over', this.hitTest(bottle, '20%')); },
            onRelease() {
                zone.classList.remove('over');
                if (this.hitTest(bottle, '20%')) accept(chip, this);
                else gsap.to(chip, { x: 0, y: 0, duration: .8, ease: 'elastic.out(1, .5)' });
            },
            onClick() { accept(chip, this); }
        });
    });
    gsap.fromTo('.chips-left .chip', { x: -80, autoAlpha: 0 }, { scrollTrigger: { trigger: '#lab', start: 'top 80%' }, x: 0, autoAlpha: 1, duration: .8, stagger: .12, ease: 'back.out(2)', clearProps: 'opacity,visibility' });
    gsap.fromTo('.chips-right .chip', { x: 80, autoAlpha: 0 }, { scrollTrigger: { trigger: '#lab', start: 'top 80%' }, x: 0, autoAlpha: 1, duration: .8, stagger: .12, ease: 'back.out(2)', clearProps: 'opacity,visibility' });
    gsap.from(bottle, { scrollTrigger: { trigger: '#lab', start: 'top 80%' }, y: 80, scale: .6, opacity: 0, duration: 1.1, ease: 'elastic.out(1, .5)' });
    // Nudge first chip to hint dragging
    if (!reduceMotion) {
        ScrollTrigger.create({
            trigger: '#lab', start: 'top 60%', once: true,
            onEnter() { gsap.to('.chip[data-ing="0"]', { x: 26, duration: .35, yoyo: true, repeat: 3, ease: 'sine.inOut', delay: 1.2 }); }
        });
    }
})();

/* ===== HORIZONTAL BENEFITS (desktop pin) ===== */
const mm = gsap.matchMedia();
mm.add('(min-width: 769px)', () => {
    const track = $('#hTrack');
    const dist = () => track.scrollWidth - window.innerWidth;
    const tween = gsap.to(track, {
        x: () => -dist(), ease: 'none',
        scrollTrigger: { trigger: '#loi-ich', start: 'top top', end: () => '+=' + dist(), pin: true, scrub: 1, invalidateOnRefresh: true, refreshPriority: 1 }
    });
    $$('.b-card').forEach(card => {
        gsap.from(card.querySelector('.big'), {
            scale: 0, rotate: -30, ease: 'back.out(2)',
            scrollTrigger: { trigger: card, containerAnimation: tween, start: 'left 90%', end: 'left 60%', scrub: true }
        });
    });
});
mm.add('(max-width: 768px)', () => {
    gsap.from('.b-card', { scrollTrigger: { trigger: '#hTrack', start: 'top 85%' }, x: 60, opacity: 0, duration: .8, stagger: .1, ease: 'power3.out' });
});

/* ===== QUIZ ===== */
(function () {
    const steps = $$('.q-step'), total = steps.length;
    const answers = {};
    let cur = 0, busy = false;
    const RESULTS = {
        cradle: { e: '👶', title: 'Bé cần làm sạch cứt trâu', type: 'Cần làm mềm & làm sạch nhẹ nhàng', tips: ['Không cạy, gãi mảng cứt trâu để tránh làm tổn thương da đầu bé.', 'Gội hằng ngày với sữa tắm gội dịu nhẹ có dầu hạnh nhân như Bon Bon để làm mềm và làm sạch dần.', 'Xả thật sạch và lau khô tóc bé bằng khăn mềm sau khi gội.'] },
        dry: { e: '🌵', title: 'Da bé hơi thiếu ẩm', type: 'Cần làm sạch & giữ ẩm', tips: ['Không tắm nước quá nóng và không tắm quá lâu (5-10 phút).', 'Chọn sữa tắm có thành phần dưỡng ẩm, không làm khô căng da.', 'Thoa dưỡng ẩm ngay sau khi lau khô người bé.'] },
        sensitive: { e: '🥺', title: 'Bé có làn da nhạy cảm', type: 'Cần sản phẩm thật dịu nhẹ', tips: ['Chọn sữa tắm dịu nhẹ, hương thơm nhẹ, dùng lượng vừa đủ.', 'Thử trước trên một vùng da nhỏ khi đổi sản phẩm mới.', 'Để chuyên viên tư vấn chi tiết theo tình trạng của bé.'] },
        normal: { e: '🌸', title: 'Da bé khỏe mạnh', type: 'Duy trì làm sạch dịu nhẹ', tips: ['Duy trì thói quen tắm gội đều đặn với sản phẩm dịu nhẹ.', 'Dùng sữa tắm gội 2in1 để giờ tắm nhanh gọn, bé vui hơn.', 'Biến giờ tắm thành giờ chơi với đồ chơi nhà tắm.'] }
    };
    let skinType = 'normal';
    const update = () => {
        $('#qLabel').textContent = cur < total ? `Câu ${cur + 1}/${total}` : 'Kết quả';
        $('#qBar').style.width = (Math.min(cur, total) / total * 100) + '%';
        $('#qBack').style.display = cur > 0 && cur < total ? 'inline-block' : 'none';
    };
    const show = (idx, dir = 1) => {
        const from = steps[cur], to = steps[idx];
        busy = true;
        gsap.to(from, {
            x: -60 * dir, opacity: 0, duration: .25, ease: 'power2.in', onComplete: () => {
                from.classList.remove('active'); gsap.set(from, { x: 0, opacity: 1 });
                to.classList.add('active');
                gsap.fromTo(to, { x: 60 * dir, opacity: 0 }, { x: 0, opacity: 1, duration: .4, ease: 'power3.out' });
                gsap.from(to.querySelectorAll('.q-opt'), { y: 20, opacity: 0, stagger: .06, duration: .4, ease: 'back.out(2)' });
                cur = idx; update(); busy = false;
            }
        });
    };
    const finish = () => {
        const last = steps[cur];
        cur = total; update();
        gsap.to(last, { opacity: 0, duration: .25, onComplete: () => {
            last.classList.remove('active'); gsap.set(last, { opacity: 1 });
            const ld = $('#qLoading'); ld.classList.add('active');
            gsap.to(ld.querySelector('.spin'), { rotate: 360, scale: 1.3, duration: .6, repeat: 2, yoyo: true });
            setTimeout(() => {
                ld.classList.remove('active');
                const r = RESULTS[skinType];
                $('#rEmoji').textContent = r.e; $('#rTitle').textContent = r.title; $('#rType').textContent = r.type;
                $('#rTips').innerHTML = r.tips.map(t => `<li>✅ <span>${t}</span></li>`).join('');
                const box = $('#qResult'); box.classList.add('active');
                gsap.from(box.children, { y: 30, opacity: 0, stagger: .08, duration: .5, ease: 'back.out(2)' });
                gsap.from('#rEmoji', { scale: 0, rotate: -180, duration: .9, ease: 'elastic.out(1, .5)' });
                confetti(30);
                // Prefill form
                $('#hQuiz').value = `${r.title} | Tuổi: ${answers.age} | Da: ${answers.skin} | Gội: ${answers.bath} | Ưu tiên: ${answers.priority}`;
                const ageInput = $(`#ageRow input[value="${answers.age}"]`); if (ageInput) ageInput.checked = true;
                const cMap = { 'Cứt trâu': 'Cứt trâu', 'Da khô': 'Da khô', 'Da nhạy cảm': 'Da nhạy cảm' };
                if (cMap[answers.skin]) { const c = $(`#concernRow input[value="${cMap[answers.skin]}"]`); if (c) c.checked = true; }
                if (answers.bath === 'Khóc, sợ cay mắt') { const c = $('#concernRow input[value="Cay mắt khi gội"]'); if (c) c.checked = true; }
                if (answers.priority === 'Tiện lợi 2in1') { const c = $('#concernRow input[value="Tìm sữa tắm 2in1"]'); if (c) c.checked = true; }
            }, 1400);
        } });
    };
    steps.forEach((step, i) => {
        step.querySelectorAll('.q-opt').forEach(btn => btn.addEventListener('click', () => {
            if (busy) return;
            busy = true;
            step.querySelectorAll('.q-opt').forEach(b => b.classList.remove('picked'));
            btn.classList.add('picked');
            gsap.fromTo(btn, { scale: .94 }, { scale: 1, duration: .5, ease: 'elastic.out(1.2, .4)' });
            answers[step.dataset.q] = btn.dataset.v;
            if (btn.dataset.t) skinType = btn.dataset.t;
            setTimeout(() => { busy = false; i < total - 1 ? show(i + 1) : finish(); }, 280);
        }));
    });
    $('#qBack').addEventListener('click', () => { if (cur > 0 && !busy) show(cur - 1, -1); });
    $('#qRestart').addEventListener('click', () => {
        $('#qResult').classList.remove('active');
        steps.forEach(s => { s.classList.remove('active'); s.querySelectorAll('.q-opt').forEach(b => b.classList.remove('picked')); });
        cur = 0; steps[0].classList.add('active'); update();
        gsap.from(steps[0].querySelectorAll('.q-opt'), { y: 20, opacity: 0, stagger: .06, duration: .4 });
    });
    update();
})();

/* ===== HOW TO (path draw + steps) ===== */
(function () {
    const path = $('#stepsPath');
    const len = path.getTotalLength();
    path.style.strokeDasharray = `${len}`;
    path.style.strokeDashoffset = len;
    gsap.to(path, { strokeDashoffset: 0, ease: 'none', scrollTrigger: { trigger: '.steps', start: 'top 75%', end: 'bottom 60%', scrub: 1 } });
    gsap.from('.step', { scrollTrigger: { trigger: '.steps', start: 'top 78%' }, y: 60, opacity: 0, stagger: .18, duration: .8, ease: 'back.out(1.8)' });
    gsap.from('.step .circle b', { scrollTrigger: { trigger: '.steps', start: 'top 70%' }, scale: 0, stagger: .18, duration: .6, delay: .5, ease: 'back.out(3)' });
    $$('.step .circle').forEach(c => c.addEventListener('mouseenter', () => gsap.fromTo(c, { rotate: -10 }, { rotate: 0, duration: .8, ease: 'elastic.out(1.2, .3)' })));
})();

/* ===== LUCKY WHEEL ===== */
(function () {
    const gifts = CONFIG.gifts, n = gifts.length, seg = 360 / n;
    const R = 200, C = 200;
    const pt = (deg, r) => { const a = (deg - 90) * Math.PI / 180; return [C + r * Math.cos(a), C + r * Math.sin(a)]; };
    let svg = `<svg viewBox="0 0 400 400">`;
    gifts.forEach((g, i) => {
        const [x1, y1] = pt(i * seg, R), [x2, y2] = pt((i + 1) * seg, R);
        svg += `<path d="M${C},${C} L${x1},${y1} A${R},${R} 0 0,1 ${x2},${y2} Z" fill="${g.color}" stroke="#fff" stroke-width="3"/>`;
        const mid = i * seg + seg / 2, [tx, ty] = pt(mid, R * .66);
        svg += `<text x="${tx}" y="${ty}" transform="rotate(${mid} ${tx} ${ty})" text-anchor="middle" dominant-baseline="middle" font-family="Baloo 2, sans-serif" font-weight="800" font-size="19" fill="#34495e">${g.label}</text>`;
        const [ex, ey] = pt(mid, R * .9);
        svg += `<circle cx="${ex}" cy="${ey}" r="5" fill="#fff"/>`;
    });
    svg += `</svg>`;
    const wheel = $('#wheel');
    wheel.innerHTML = svg;
    const btn = $('#wheelSpin');
    const pickWeighted = () => {
        const sum = gifts.reduce((s, g) => s + g.weight, 0);
        let r = Math.random() * sum;
        for (let i = 0; i < n; i++) { r -= gifts[i].weight; if (r <= 0) return i; }
        return n - 1;
    };
    const applyPrize = (label, animate) => {
        $('#wheelPrize').textContent = label;
        $('#wheelResult').classList.add('show');
        $('#wonText').textContent = label;
        $('#wonBanner').classList.add('show');
        $('#hGift').value = label;
        btn.disabled = true;
        btn.innerHTML = 'ĐÃ<br>QUAY';
        if (animate) {
            gsap.from('#wheelResult', { scale: .6, opacity: 0, duration: .7, ease: 'back.out(2.5)' });
            gsap.fromTo('#wheelCta', { scale: 1 }, { scale: 1.1, duration: .4, yoyo: true, repeat: 5 });
        }
    };
    const saved = store.get('bonbon_gift');
    if (saved !== null && gifts[+saved]) {
        gsap.set(wheel, { rotate: 360 - (+saved * seg + seg / 2) });
        applyPrize(gifts[+saved].label, false);
    }
    if (!reduceMotion && saved === null) gsap.to(wheel, { rotate: '+=360', duration: 40, ease: 'none', repeat: -1, id: 'wheelIdle' });
    btn.addEventListener('click', () => {
        if (btn.disabled) return;
        btn.disabled = true;
        const idle = gsap.getById('wheelIdle'); idle && idle.kill();
        const i = pickWeighted();
        const current = gsap.getProperty(wheel, 'rotate') % 360;
        const target = 360 * 6 + (360 - (i * seg + seg / 2)) + gsap.utils.random(-seg * .3, seg * .3);
        gsap.fromTo(wheel, { rotate: current }, {
            rotate: target, duration: 5, ease: 'power4.out',
            onComplete: () => { store.set('bonbon_gift', i); applyPrize(gifts[i].label, true); confetti(70); }
        });
        gsap.to('.wheel-pointer', { rotate: 18, duration: .08, yoyo: true, repeat: 40, ease: 'none', onComplete: () => gsap.set('.wheel-pointer', { rotate: 0 }) });
    });
    gsap.from('.wheel-wrap', { scrollTrigger: { trigger: '#vong-quay', start: 'top 70%' }, scale: .5, rotate: -90, opacity: 0, duration: 1.2, ease: 'back.out(1.6)' });
})();

/* ===== FACT COUNTER ===== */
(function () {
    const o = { v: 0 };
    gsap.to(o, { v: 30, duration: 1.6, ease: 'power2.out', scrollTrigger: { trigger: '.fact', start: 'top 85%' }, onUpdate: () => { $('#factNum').textContent = Math.round(o.v); } });
})();

/* ===== PRODUCT INFO TABS ===== */
(function () {
    const tabs = $$('.tab'), panels = $$('.tab-panel'), pill = $('#tabPill');
    const movePill = (t, instant) => gsap.to(pill, { x: t.offsetLeft, width: t.offsetWidth, duration: instant ? 0 : .45, ease: 'back.out(1.6)' });
    tabs.forEach((t, i) => t.addEventListener('click', () => {
        tabs.forEach(x => x.classList.toggle('active', x === t));
        panels.forEach((p, k) => p.classList.toggle('active', k === i));
        movePill(t);
        gsap.fromTo(panels[i].querySelectorAll('li'), { x: 30, opacity: 0 }, { x: 0, opacity: 1, stagger: .07, duration: .45, ease: 'back.out(2)' });
    }));
    movePill(tabs[0], true);
    window.addEventListener('resize', () => movePill($('.tab.active'), true));
    gsap.fromTo('.vol-tag', { scale: 0, rotate: -120 }, { scrollTrigger: { trigger: '#thong-tin', start: 'top 70%' }, scale: 1, rotate: 0, duration: 1, delay: .3, ease: 'elastic.out(1, .5)' });
})();

/* ===== FAQ ===== */
$$('.faq-item').forEach(item => {
    const q = item.querySelector('.faq-q'), a = item.querySelector('.faq-a');
    q.setAttribute('aria-expanded', 'false');
    q.addEventListener('click', () => {
        const open = item.classList.contains('open');
        $$('.faq-item.open').forEach(o => { if (o !== item) { o.classList.remove('open'); o.querySelector('.faq-q').setAttribute('aria-expanded', 'false'); gsap.to(o.querySelector('.faq-a'), { height: 0, duration: .4, ease: 'power2.inOut' }); } });
        item.classList.toggle('open', !open);
        q.setAttribute('aria-expanded', String(!open));
        gsap.to(a, { height: open ? 0 : 'auto', duration: .45, ease: 'power2.inOut' });
    });
});

/* ===== COUNTDOWN (end of day) ===== */
(function () {
    const pad = v => String(v).padStart(2, '0');
    const tick = () => {
        const now = new Date(), end = new Date(now); end.setHours(23, 59, 59, 999);
        const s = Math.max(0, Math.floor((end - now) / 1000));
        $('#cdH').textContent = pad(Math.floor(s / 3600));
        $('#cdM').textContent = pad(Math.floor(s % 3600 / 60));
        $('#cdS').textContent = pad(s % 60);
    };
    tick(); setInterval(tick, 1000);
})();

/* ===== LEAD FORM ===== */
(function () {
    const params = new URLSearchParams(location.search);
    const source = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'fbclid', 'ttclid', 'gclid']
        .filter(k => params.get(k)).map(k => `${k}=${params.get(k)}`).join('&');
    $('#hSource').value = source || document.referrer || 'direct';

    const form = $('#leadForm');
    const name = $('#fName'), phone = $('#fPhone');
    const phoneRe = /^0(3|5|7|8|9)\d{8}$/;
    const setErr = (input, errEl, bad) => { input.classList.toggle('error', bad); $(errEl).classList.toggle('show', bad); };
    phone.addEventListener('input', () => { phone.value = phone.value.replace(/[^\d\s]/g, ''); });
    [name, phone].forEach(i => i.addEventListener('input', () => { i.classList.remove('error'); i.closest('.field').querySelector('.err').classList.remove('show'); }));

    form.addEventListener('submit', async e => {
        e.preventDefault();
        const ph = phone.value.replace(/\s/g, '');
        const badName = name.value.trim().length < 2, badPhone = !phoneRe.test(ph);
        setErr(name, '#eName', badName);
        setErr(phone, '#ePhone', badPhone);
        if (badName || badPhone) { (badName ? name : phone).focus(); return; }

        const fd = new FormData(form);
        const data = {
            name: name.value.trim(), phone: ph,
            baby_age: fd.get('baby_age') || '',
            concern: fd.getAll('concern').join(', '),
            call_time: fd.get('call_time') || '',
            note: fd.get('note') || '',
            quiz_result: fd.get('quiz_result') || '',
            gift: fd.get('gift') || '',
            source: fd.get('source') || '',
            page: location.href.split('?')[0],
            product: 'Sữa tắm gội Bon Bon',
            time: new Date().toLocaleString('vi-VN')
        };
        const btn = $('#submitBtn');
        btn.disabled = true; btn.innerHTML = '<i class="bb"></i> Đang gửi...';
        try {
            // 1. Submit to WordPress AJAX lead handler
            if (CONFIG.ajaxUrl) {
                const ajaxFd = new FormData();
                ajaxFd.append('action', 'lx_submit_lead');
                ajaxFd.append('nonce', CONFIG.nonce || '');
                for (const [k, v] of Object.entries(data)) {
                    ajaxFd.append(k, v);
                }
                fetch(CONFIG.ajaxUrl, { method: 'POST', body: ajaxFd }).catch(e => console.warn('AJAX submit warning:', e));
            }
            // 2. Submit to external webhook (Pancake / Google Sheet) if configured
            if (CONFIG.webhookUrl) {
                await fetch(CONFIG.webhookUrl, { method: 'POST', mode: 'no-cors', headers: { 'Content-Type': 'text/plain;charset=utf-8' }, body: JSON.stringify(data) });
            } else {
                console.log('[Bon Bon lead captured]', data);
            }
        } catch (err) {
            console.error(err);
        }
        // Conversion tracking
        try { window.fbq && fbq('track', 'Lead', { content_name: data.product }); } catch (e) {}
        try { window.ttq && ttq.track('SubmitForm'); } catch (e) {}
        try { window.gtag && gtag('event', 'generate_lead', { item_name: data.product }); } catch (e) {}
        try { (window.dataLayer = window.dataLayer || []).push({ event: 'lead_submit', ...data }); } catch (e) {}

        $('#sName').textContent = data.name;
        $('#sPhone').textContent = data.phone;
        gsap.to('#formContent', { opacity: 0, y: -20, duration: .3, onComplete: () => {
            $('#formContent').style.display = 'none';
            const s = $('#formSuccess'); s.classList.add('show');
            gsap.from(s.children, { y: 30, opacity: 0, stagger: .1, duration: .6, ease: 'back.out(2)' });
            gsap.from('#formSuccess .big', { scale: 0, rotate: -90, duration: 1, ease: 'elastic.out(1, .4)' });
        } });
        confetti(120);
        gsap.to(window, { scrollTo: { y: '#dang-ky', offsetY: 70 }, duration: .8 });
    });
})();

/* ===== CONFETTI ===== */
function confetti(count) {
    if (reduceMotion) return;
    const colors = ['#4cc0d3', '#ffb5c8', '#ffe08a', '#b8f0d8', '#d9cbff', '#ff8fab'];
    const shapes = ['💧', '⭐', '💖', ''];
    for (let i = 0; i < count; i++) {
        const c = document.createElement('div');
        c.className = 'confetti';
        const shape = shapes[Math.floor(Math.random() * shapes.length)];
        if (shape) { c.textContent = shape; c.style.fontSize = gsap.utils.random(14, 26) + 'px'; }
        else { gsap.set(c, { width: gsap.utils.random(8, 14), height: gsap.utils.random(6, 10), background: colors[i % colors.length], borderRadius: 3 }); }
        c.style.left = Math.random() * 100 + 'vw';
        document.body.appendChild(c);
        gsap.to(c, {
            y: window.innerHeight + 60, x: gsap.utils.random(-120, 120), rotate: gsap.utils.random(-720, 720),
            duration: gsap.utils.random(2, 3.6), delay: Math.random() * .5, ease: 'power1.in', onComplete: () => c.remove()
        });
    }
}

ScrollTrigger.sort();
const refreshAll = () => { ScrollTrigger.sort(); ScrollTrigger.refresh(); };
if (document.readyState === 'complete') refreshAll(); else window.addEventListener('load', refreshAll);
}

/* ===== GSAP LOADER =====
   Một số trình xem (htmlpreview.github.io, in-app browser...) chạy script inline
   trước khi thư viện từ CDN tải xong hoặc bỏ qua thẻ <script src>. Đảm bảo đủ
   thư viện (cdnjs, dự phòng jsDelivr) rồi mới khởi chạy trang. */
(function () {
    const V = '3.12.5';
    const libs = [['gsap', 'gsap.min.js'], ['ScrollTrigger', 'ScrollTrigger.min.js'], ['ScrollToPlugin', 'ScrollToPlugin.min.js'], ['Draggable', 'Draggable.min.js']];
    const hosts = [f => `https://cdnjs.cloudflare.com/ajax/libs/gsap/${V}/${f}`, f => `https://cdn.jsdelivr.net/npm/gsap@${V}/dist/${f}`];
    const load = src => new Promise((ok, fail) => {
        const el = document.createElement('script');
        el.src = src; el.onload = ok; el.onerror = fail;
        document.head.appendChild(el);
    });
    const ensure = async ([name, file]) => {
        if (window[name]) return;
        for (const h of hosts) {
            try { await load(h(file)); } catch (e) { continue; }
            if (window[name]) return;
        }
        throw new Error('Không tải được thư viện ' + name);
    };
    (async () => {
        try {
            for (const lib of libs) await ensure(lib);
        } catch (e) {
            console.error(e);
            document.documentElement.classList.remove('js');
            return;
        }
        bootBonBon();
    })();
})();