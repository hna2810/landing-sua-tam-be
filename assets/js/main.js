/* ===================================================================
   CẤU HÌNH — Tích hợp WordPress BONBON_CONFIG & Fallback
   =================================================================== */
const DEFAULT_CONFIG = {
    hotline: '0901234567',
    hotlineFormatted: '0901.234.567',
    zalo: '0901234567',
    webhookUrl: '',
    ajaxUrl: '',
    nonce: '',
    offer: { label: 'Combo 299K BIGSIZE tắm gội + Kem bôi', price: 299000, old: 455000 },
    reviews: [
        {
            name: 'Thu Trang (Mẹ Bắp 4 tháng)',
            time: 'Hôm qua',
            stars: 5,
            text: 'Một chai vừa tắm vừa gội tiện ghê, mẹ đỡ phải chuẩn bị nhiều chai lọ lỉnh kỉnh. Bọt vừa phải, xả nhanh sạch mà da con vẫn mềm mướt không hề nhờn rít. Đóng gói cẩn thận, giao nhanh lắm ạ!',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/sua-tam-cho-be-bonbon-homecarte.jpg',
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/bo-sp-scaled.jpg'
            ]
        },
        {
            name: 'Mẹ Bin (Bé 6 tháng - Hà Nội)',
            time: '2 ngày trước',
            stars: 5,
            text: 'Sữa tắm ít bọt, gội đầu bé không bị cay mắt hay quấy khóc như mấy loại trước. Mùi thơm thảo mộc tự nhiên nhẹ tênh rất dễ chịu. Tắm xong thơm tho, da mát rượi, bé ngủ sâu giấc hơn hẳn.',
            video: 'https://www.youtube.com/watch?v=XjWaZd8P3Uk',
            video_poster: 'https://img.youtube.com/vi/XjWaZd8P3Uk/hqdefault.jpg',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/sua-tam-diu-nhe-it-bot-cho-be-bonbon-homecare.png'
            ]
        },
        {
            name: 'Mẹ Ken (Đà Nẵng)',
            time: '3 ngày trước',
            stars: 5,
            text: 'Bé nhà mình da nhạy cảm hay nổi mẩn đỏ quanh cổ, dùng Bon Bon được 1 tuần thấy dịu hẳn, da lặn mụn mà không bị khô ráp. Chai 500ml to đùng dùng vòi pump bấm 1 tay tiện lợi khi bế con. Shop tư vấn siêu nhiệt tình!',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/sau-khi-dung-sua-tam.png'
            ]
        },
        {
            name: 'Hồng Nhung (Mẹ Sóc)',
            time: '5 ngày trước',
            stars: 4,
            text: 'Dùng êm, xả nhanh sạch, hương thơm nhẹ nhàng dễ chịu. Trừ 1 sao vì hôm đặt bên vận chuyển giao hơi trễ 1 hôm, nhưng bù lại đóng gói bọc xốp chống sốc rất kỹ càng.',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/Sua-tam-goi-Bon-Bon_500ml_tach-nen-scaled.png'
            ]
        },
        {
            name: 'Phan Linh (Mẹ Bé Tít)',
            time: '1 tuần trước',
            stars: 5,
            text: 'Mình sinh mổ dùng dịch vụ tắm bé của Home Care được các cô dùng sữa tắm này cho con thích quá nên đặt luôn combo về dùng lâu dài. Thành phần thảo dược tự nhiên lành tính, gội đầu không lo bọt vào mắt cay. Cho 10/10 điểm!',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/home-care-tam-be.png'
            ]
        },
        {
            name: 'Mai Phương (Bé Sam 3m)',
            time: '1 tuần trước',
            stars: 5,
            text: 'Mùi tràm gió và thảo mộc thơm thư giãn cực kỳ, tắm buổi tối là bé ngủ khò khò tới sáng. Rất ưng chất sữa tắm mướt mịn và vòi nhấn nhẹ nhàng.',
            photos: []
        },
        {
            name: 'Thanh Hương (Bình Thạnh, TP.HCM)',
            time: '1 tuần trước',
            stars: 4,
            text: 'Chai to xài lâu hết, bé mình da dễ dị ứng mà trộm vía tắm hạp. Mong hãng ra thêm chai nhỏ mini để tiện mang theo khi về quê hay đi du lịch nhé.',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/bo-sp-scaled.jpg'
            ]
        },
        {
            name: 'Ngọc Ánh (Mẹ Đậu Đậu)',
            time: '2 tuần trước',
            stars: 5,
            text: 'Tìm mãi mới được loại sữa tắm gội 2in1 ưng ý cho con. Không chứa cồn, không paraben, tắm xong con thơm phức ôm chỉ muốn hít hà mãi thôi.',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/sau-khi-dung-sua-tam.png'
            ]
        },
        {
            name: 'Lê Thảo (Bé Bơ 5 tháng)',
            time: '2 tuần trước',
            stars: 5,
            text: 'Sản phẩm có đầy đủ tem chống hàng giả và số công bố của Bộ Y Tế nên mẹ rất yên tâm. Tắm xong con sạch bong mà sờ da ẩm mịn thích lắm ạ.',
            photos: [
                'https://suatambe.bonbonhomecare.vn/wp-content/uploads/2026/10/sua-tam-cho-be-bonbon-homecarte.jpg'
            ]
        },
        {
            name: 'Hoàng Yến (Hải Phòng)',
            time: '3 tuần trước',
            stars: 5,
            text: 'Được chị bạn giới thiệu dùng thử, giờ thành fan ruột của Bon Bon luôn. Mẹ nào bé hay bị rôm sảy mẩn ngứa cứ tự tin dùng thử nha, cải thiện rõ rệt luôn đó ạ.',
            photos: []
        }
    ],
    gifts: [
        { label: 'Giảm 20%',        color: '#ffb5c8', weight: 2 },
        { label: 'Khăn tắm xinh',   color: '#fff6d6', weight: 3 },
        { label: 'Freeship',        color: '#b8f0d8', weight: 3 },
        { label: 'Giảm 30%',        color: '#d9cbff', weight: 1 },
        { label: 'Vịt tắm cute',    color: '#e3f7fa', weight: 3 },
        { label: 'Mua 2 tặng 1',    color: '#ffe08a', weight: 1 }
    ]
};

const BONBON_CFG = window.BONBON_CONFIG || {};
const CONFIG = {
    hotline: BONBON_CFG.hotline || DEFAULT_CONFIG.hotline,
    hotlineFormatted: BONBON_CFG.hotlineFormatted || BONBON_CFG.hotline || DEFAULT_CONFIG.hotlineFormatted,
    zalo: BONBON_CFG.zalo || DEFAULT_CONFIG.zalo,
    webhookUrl: BONBON_CFG.webhookUrl || '',
    ajaxUrl: BONBON_CFG.ajaxUrl || '',
    nonce: BONBON_CFG.nonce || '',
    offer: Object.assign({}, DEFAULT_CONFIG.offer, BONBON_CFG.offer || {}),
    reviews: (Array.isArray(BONBON_CFG.reviews) && BONBON_CFG.reviews.length > 0) ? BONBON_CFG.reviews : DEFAULT_CONFIG.reviews,
    gifts: (Array.isArray(BONBON_CFG.gifts) && BONBON_CFG.gifts.length > 0) ? BONBON_CFG.gifts : DEFAULT_CONFIG.gifts
};

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

/* ===== TOAST ===== */
gsap.set('#toast', { xPercent: -50, y: 20 });
function toast(html, ms = 3200) {
    const t = $('#toast');
    if (!t) return;
    t.innerHTML = html;
    gsap.killTweensOf(t);
    gsap.timeline()
        .to(t, { opacity: 1, y: 0, duration: .35, ease: 'back.out(1.5)' })
        .to(t, { opacity: 0, y: 20, duration: .3, delay: ms / 1000 });
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
    .from('#heroDuck', { x: 120, rotate: 40, opacity: 0, duration: 1, ease: 'back.out(2)' }, 1.1)
    .from('.hero-star', { scale: 0, duration: .6, stagger: .1, ease: 'back.out(3)' }, 1.2);

if (!reduceMotion) {
    gsap.to('.hero-star', { rotate: 20, scale: 1.2, duration: 1.6, ease: 'sine.inOut', yoyo: true, repeat: -1, stagger: .4 });
    gsap.to('#heroDuck', { rotate: 8, y: -8, duration: 1.3, ease: 'sine.inOut', yoyo: true, repeat: -1 });
}

// Hero bottle: draggable, springs back + floating idle + parallax tilt
const heroBottle = $('#heroBottle');
const bottleIdle = reduceMotion ? null : gsap.to(heroBottle.querySelector('img'), { y: -16, rotate: 2, duration: 2.2, ease: 'sine.inOut', yoyo: true, repeat: -1 });
Draggable.create(heroBottle, {
    type: 'x,y',
    onPress() { bottleIdle && bottleIdle.pause(); gsap.to(heroBottle, { scale: 1.05, duration: .2 }); },
    onDrag() { gsap.to(heroBottle, { rotate: gsap.utils.clamp(-25, 25, this.deltaX * 2), duration: .3 }); },
    onRelease() {
        gsap.to(heroBottle, { x: 0, y: 0, rotate: 0, scale: 1, duration: 1.2, ease: 'elastic.out(1, .4)' });
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
        gsap.to(heroBottle.querySelector('img'), { rotationY: px * 16, rotationX: py * -10, transformPerspective: 800, duration: .6 });
    });
}

// Duck squeak (playful mascot bounce)
const heroDuckEl = $('#heroDuck');
if (heroDuckEl) {
    heroDuckEl.addEventListener('click', () => {
        gsap.fromTo(heroDuckEl, { scaleX: 1.3, scaleY: .7 }, { scaleX: 1, scaleY: 1, duration: .8, ease: 'elastic.out(1.2, .3)' });
    });
}

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
        $$('.js-pop-count').forEach(pc => {
            pc.textContent = pops;
            gsap.fromTo(pc, { scale: 1.8 }, { scale: 1, duration: .5, ease: 'back.out(3)' });
        });
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
    onEnter: batch => {
        // Phần tử đã bị cuộn qua (nhảy anchor) thì hiện ngay; phần còn lại xuất hiện so le, tổng thời gian tối đa ~0.6s
        const passed = batch.filter(el => el.getBoundingClientRect().bottom < 0);
        const rest = batch.filter(el => !passed.includes(el));
        if (passed.length) gsap.set(passed, { opacity: 1, y: 0, scale: 1, overwrite: true });
        if (rest.length) gsap.fromTo(rest, { opacity: 0, y: 50, scale: .96 }, { opacity: 1, y: 0, scale: 1, duration: .9, stagger: Math.min(.12, .6 / rest.length), ease: 'power3.out', overwrite: true });
    },
    once: true
});
// Dự phòng: phần tử nào đã lọt vào màn hình mà vẫn ẩn (cuộn quá nhanh, nhảy anchor) thì hiện luôn
const revealStragglers = () => $$('[data-reveal]').forEach(el => {
    if (+getComputedStyle(el).opacity < .05 && el.getBoundingClientRect().top < innerHeight && !gsap.isTweening(el))
        gsap.to(el, { opacity: 1, y: 0, scale: 1, duration: .6, ease: 'power3.out' });
});
ScrollTrigger.addEventListener('scrollEnd', revealStragglers);
let stragglerT = null;
window.addEventListener('scroll', () => { clearTimeout(stragglerT); stragglerT = setTimeout(revealStragglers, 250); }, { passive: true });
$$('.section-title').forEach(t => {
    const hl = t.querySelector('.hl');
    if (!hl) return;
    gsap.from(hl, { scrollTrigger: { trigger: t, start: 'top 85%' }, color: '#34495e', duration: .8, delay: .3 });
});

/* ===== WISH CARDS ===== */
$$('.wish-card').forEach(card => {
    card.addEventListener('click', e => {
        card.classList.toggle('flipped');
        gsap.fromTo(card, { scale: .94 }, { scale: 1, duration: .7, ease: 'elastic.out(1.2, .4)' });
        const r = card.getBoundingClientRect();
        const x = (e.clientX || r.left + r.width / 2) - r.left, y = (e.clientY || r.top + r.height / 2) - r.top;
        ['💖', '✨', '💙', '🌸', '⭐'].forEach((h, i) => {
            const el = document.createElement('span');
            el.className = 'wish-heart'; el.textContent = h;
            gsap.set(el, { left: x, top: y, xPercent: -50, yPercent: -50 });
            card.appendChild(el);
            const a = -Math.PI / 2 + (i - 2) * .55;
            gsap.to(el, { x: Math.cos(a) * 90, y: Math.sin(a) * 90, scale: 1.4, opacity: 0, duration: .9, ease: 'power2.out', onComplete: () => el.remove() });
        });
    });
    const tap = card.querySelector('.wish-tap');
    if (tap && !reduceMotion) gsap.to(tap, { y: -6, duration: .9, yoyo: true, repeat: -1, ease: 'sine.inOut', delay: Math.random() });
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
            bottle.classList.add('glow'); setTimeout(() => bottle.classList.remove('glow'), 700);
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

/* ===== USES (3 trong 1) ===== */
(function () {
    const items = $$('.use-item');
    items.forEach(item => item.addEventListener('click', () => {
        items.forEach(x => x.classList.toggle('active', x === item));
        gsap.fromTo(item.querySelector('.use-num'), { scale: .5, rotate: -20 }, { scale: 1, rotate: 0, duration: .8, ease: 'elastic.out(1.2, .4)' });
    }));
    gsap.fromTo(items, { x: 80, opacity: 0 }, { x: 0, opacity: 1, duration: .9, stagger: .18, ease: 'back.out(1.6)', clearProps: 'opacity',
        scrollTrigger: { trigger: '.uses-track', start: 'top 80%' } });
    gsap.to('#usesLineFill', { scaleY: 1, ease: 'none', scrollTrigger: { trigger: '.uses-track', start: 'top 70%', end: 'bottom 55%', scrub: true } });
    gsap.fromTo('.uses-chip', { scale: 0, rotate: -30 }, { scale: 1, rotate: 0, duration: .8, stagger: .15, ease: 'back.out(2.4)',
        scrollTrigger: { trigger: '.uses-visual', start: 'top 75%' } });
    gsap.fromTo('.uses-bottle', { y: 80, rotate: 30, opacity: 0 }, { y: 0, rotate: 8, opacity: 1, duration: 1.2, ease: 'elastic.out(1, .55)',
        scrollTrigger: { trigger: '.uses-visual', start: 'top 70%' } });
    gsap.to('.uses-bigthree', { yPercent: 25, ease: 'none', scrollTrigger: { trigger: '#cong-dung', start: 'top bottom', end: 'bottom top', scrub: true } });
    if (!reduceMotion) {
        $$('.uses-chip').forEach((c, i) => gsap.to(c, { y: -10, duration: 1.8 + i * .3, yoyo: true, repeat: -1, ease: 'sine.inOut', delay: i * .4 }));
        gsap.to('.uses-bottle', { y: -12, duration: 2.2, yoyo: true, repeat: -1, ease: 'sine.inOut', delay: 1.3 });
    }
})();


/* ===== HOW TO STEPS (section 7) ===== */
(function () {
    const steps = $$('.hstep');
    let auto = null, idx = 0;
    const activate = i => {
        idx = i;
        steps.forEach((st, k) => st.classList.toggle('active', k === i));
        gsap.fromTo(steps[i].querySelector('.hstep-num'), { scale: .6 }, { scale: 1, duration: .7, ease: 'elastic.out(1.2, .4)' });
    };
    steps.forEach((st, i) => st.addEventListener('click', () => { clearInterval(auto); activate(i); }));
    ScrollTrigger.create({
        trigger: '.howto-grid', start: 'top 70%', end: 'bottom 20%',
        onToggle: self => { clearInterval(auto); if (self.isActive && !reduceMotion) auto = setInterval(() => activate((idx + 1) % steps.length), 2600); }
    });
    gsap.fromTo('.howto-phone', { rotate: 7, y: 40 }, { rotate: 4.5, y: 0, ease: 'power1.out', scrollTrigger: { trigger: '.howto-grid', start: 'top 85%', end: 'top 30%', scrub: 1 } });
})();

/* ===== MOM VIDEOS (section 9) ===== */
$$('.mom-card').forEach(card => card.addEventListener('click', () => {
    const v = card.querySelector('video');
    if (!v) { gsap.fromTo(card, { scale: .96 }, { scale: 1, duration: .6, ease: 'elastic.out(1.2, .4)' }); return; }
    $$('.mom-card video').forEach(o => { if (o !== v) o.pause(); });
    v.paused ? v.play() : v.pause();
}));

/* ===== STORES SLIDER (section 10) ===== */
(function () {
    const track = $('#storeTrack'), dots = $('#storeDots');
    const slides = $$('.store-slide', track);
    const stepW = () => slides[0].getBoundingClientRect().width + parseFloat(getComputedStyle(track).columnGap || 20);
    const pages = () => Math.max(1, Math.round((track.scrollWidth - track.clientWidth) / stepW()) + 1);
    const renderDots = () => {
        dots.innerHTML = '';
        for (let i = 0; i < pages(); i++) {
            const d = document.createElement('button');
            d.type = 'button'; d.setAttribute('aria-label', 'Ảnh ' + (i + 1));
            d.addEventListener('click', () => { track.scrollTo({ left: i * stepW() }); restart(); });
            dots.appendChild(d);
        }
        mark();
    };
    const cur = () => Math.round(track.scrollLeft / stepW());
    const mark = () => [...dots.children].forEach((d, i) => d.classList.toggle('on', i === cur()));
    const go = dir => {
        const max = track.scrollWidth - track.clientWidth - 2;
        if (dir > 0 && track.scrollLeft >= max) track.scrollTo({ left: 0 });
        else if (dir < 0 && track.scrollLeft <= 2) track.scrollTo({ left: track.scrollWidth });
        else track.scrollBy({ left: dir * stepW() });
    };
    let timer = null;
    const restart = () => { clearInterval(timer); if (!reduceMotion) timer = setInterval(() => go(1), 3200); };
    $('.store-nav.prev').addEventListener('click', () => { go(-1); restart(); });
    $('.store-nav.next').addEventListener('click', () => { go(1); restart(); });
    track.addEventListener('scroll', () => requestAnimationFrame(mark), { passive: true });
    track.addEventListener('pointerenter', () => clearInterval(timer));
    track.addEventListener('pointerleave', restart);
    window.addEventListener('resize', renderDots);
    renderDots();
    ScrollTrigger.create({ trigger: track, start: 'top bottom', end: 'bottom top', onToggle: self => self.isActive ? restart() : clearInterval(timer) });
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
        const wp = $('#wheelPrize'); if (wp) wp.textContent = label;
        const wr = $('#wheelResult'); if (wr) wr.classList.add('show');

        // Cập nhật quà tặng vào banner đỉnh form & input trong form
        const giftBannerText = $('#orderGiftText');
        if (giftBannerText) giftBannerText.textContent = label;
        const giftBanner = $('#orderGiftBanner');
        if (giftBanner) giftBanner.classList.add('won');
        const giftDisplayInput = $('#fGiftDisplay');
        if (giftDisplayInput) giftDisplayInput.value = label;
        const hGiftInput = $('#hGift');
        if (hGiftInput) hGiftInput.value = label;
        const hNoteInput = $('#hNote');
        if (hNoteInput) hNoteInput.value = 'Quà tặng: ' + label;
        const btnChange = $('#btnChangeGift');
        if (btnChange) btnChange.textContent = 'Đã chọn ✓';

        btn.disabled = true;
        btn.innerHTML = 'ĐÃ<br>QUAY';
        if (animate) {
            gsap.from('#wheelResult', { scale: .6, opacity: 0, duration: .7, ease: 'back.out(2.5)' });
            gsap.fromTo('#wheelCta', { scale: 1 }, { scale: 1.1, duration: .4, yoyo: true, repeat: 5 });
            if (giftBanner) {
                gsap.fromTo(giftBanner, { scale: 0.95 }, { scale: 1.05, duration: 0.35, yoyo: true, repeat: 3, ease: 'power2.out' });
            }
        }
    };
    const saved = store.get('bonbon_gift');
    if (saved !== null && gifts[+saved]) {
        gsap.set(wheel, { rotate: 360 - (+saved * seg + seg / 2) });
        applyPrize(gifts[+saved].label, false);
    } else if (gifts.length > 0) {
        // Mặc định quà đầu tiên nếu chưa quay
        const defaultGift = gifts[0].label;
        const giftBannerText = $('#orderGiftText');
        if (giftBannerText) giftBannerText.textContent = defaultGift;
        const giftDisplayInput = $('#fGiftDisplay');
        if (giftDisplayInput) giftDisplayInput.value = defaultGift;
        const hGiftInput = $('#hGift');
        if (hGiftInput) hGiftInput.value = defaultGift;
        const hNoteInput = $('#hNote');
        if (hNoteInput) hNoteInput.value = 'Quà tặng: ' + defaultGift;
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
    // Lightbox xem ảnh giấy tờ
    const lb = $('#lightbox'), lbBody = $('#lbBody');
    const closeLb = () => gsap.to(lb, { opacity: 0, duration: .25, onComplete: () => { lb.hidden = true; lbBody.innerHTML = ''; } });
    $$('.doc-card').forEach(card => card.addEventListener('click', () => {
        lbBody.innerHTML = card.querySelector('.doc-img').innerHTML;
        lb.hidden = false;
        gsap.fromTo(lb, { opacity: 0 }, { opacity: 1, duration: .25 });
        gsap.fromTo(lbBody, { scale: .85, y: 30 }, { scale: 1, y: 0, duration: .5, ease: 'back.out(1.8)' });
    }));
    lb.addEventListener('click', e => { if (e.target === lb || e.target.closest('.lb-close')) closeLb(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && !lb.hidden) closeLb(); });
})();

/* ===== ĐÁNH GIÁ SẢN PHẨM ===== */
(function () {
    const all = CONFIG.reviews || [];
    const grid = $('#rvGrid'), filters = $('#rvFilters'), more = $('#rvMore');
    if (!grid || !filters) return;

    // Yêu cầu: Hiển thị ban đầu 4 đánh giá, click xem thêm thì hiển thị tối đa 10 đánh giá
    const INITIAL_COUNT = 4;
    const MAX_COUNT = 10;
    let shown = INITIAL_COUNT, current = 'all';

    const esc = t => String(t || '').replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
    const stars = n => '★'.repeat(n) + '☆'.repeat(5 - n);

    // Thống kê > 1000 đánh giá (chia ra 5 sao và 4 sao)
    const STATS = {
        total: 1286,
        s5: 1218,
        s4: 68,
        text: 1286,
        media: 356
    };

    const tests = {
        all: () => true,
        s5: r => r.stars === 5,
        s4: r => r.stars === 4,
        text: r => !!(r.text && r.text.trim()),
        media: r => !!(r.video || (r.photos && r.photos.length))
    };

    const avgEl = $('#rvAvg'), avgStarsEl = $('#rvAvgStars');
    if (avgEl) avgEl.textContent = '4.9';
    if (avgStarsEl) avgStarsEl.textContent = '★★★★★';

    const labels = [
        ['all', `Tất cả (${STATS.total.toLocaleString('vi-VN')})`],
        ['s5', `5 Sao (${STATS.s5.toLocaleString('vi-VN')})`],
        ['s4', `4 Sao (${STATS.s4.toLocaleString('vi-VN')})`],
        ['text', `Có Bình Luận (${STATS.text.toLocaleString('vi-VN')})`],
        ['media', `Có Hình Ảnh / Video (${STATS.media.toLocaleString('vi-VN')})`]
    ];

    filters.innerHTML = labels.map(([k, l]) =>
        `<button type="button" class="rv-filter${k === 'all' ? ' on' : ''}" data-k="${k}">${l}</button>`
    ).join('');

    const render = animate => {
        const filtered = all.filter(tests[current]);
        const list = filtered.slice(0, shown);

        grid.innerHTML = list.map(r => {
            const avaLetter = esc((r.name || '?').trim()[0] || '?').toUpperCase();
            let mediaHtml = '';

            const hasVideo = !!r.video;
            const hasPhotos = Array.isArray(r.photos) && r.photos.length > 0;

            if (hasVideo || hasPhotos) {
                mediaHtml += '<div class="rv-photos">';
                if (hasVideo) {
                    const poster = r.video_poster || 'https://img.youtube.com/vi/XjWaZd8P3Uk/hqdefault.jpg';
                    mediaHtml += `
                        <button type="button" class="rv-media-btn rv-video-btn" data-video="${esc(r.video)}" aria-label="Xem video đánh giá của ${esc(r.name)}">
                            <img src="${esc(poster)}" alt="Video review" loading="lazy">
                            <span class="rv-play-badge" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20 6 4"/></svg>
                            </span>
                            <span class="rv-vid-tag">VIDEO</span>
                        </button>`;
                }
                if (hasPhotos) {
                    r.photos.forEach(src => {
                        mediaHtml += `
                            <button type="button" class="rv-media-btn" data-src="${esc(src)}" aria-label="Xem ảnh đánh giá của ${esc(r.name)}">
                                <img src="${esc(src)}" alt="Ảnh đánh giá của ${esc(r.name)}" loading="lazy">
                            </button>`;
                    });
                }
                mediaHtml += '</div>';
            }

            return `
                <article class="rv-card">
                    <div class="rv-head">
                        <span class="rv-ava">${avaLetter}</span>
                        <div>
                            <div class="rv-name-row">
                                <strong class="rv-name">${esc(r.name)}</strong>
                                <span class="rv-verified">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                    Đã mua hàng
                                </span>
                            </div>
                            <div class="rv-meta">
                                <i class="rv-stars">${stars(r.stars)}</i>
                                <span>${esc(r.time || 'Gần đây')}</span>
                            </div>
                        </div>
                    </div>
                    <p class="rv-text">${esc(r.text || '')}</p>
                    ${mediaHtml}
                </article>`;
        }).join('') || '<p class="rv-empty">Chưa có đánh giá phù hợp.</p>';

        if (more) {
            const remaining = Math.min(filtered.length, MAX_COUNT) - shown;
            if (shown < MAX_COUNT && remaining > 0) {
                more.hidden = false;
                more.textContent = `Xem thêm đánh giá (${remaining} đánh giá) ▾`;
            } else {
                more.hidden = true;
            }
        }

        if (animate) {
            gsap.fromTo(grid.children, { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.45, stagger: 0.05, ease: 'power2.out' });
        }
    };

    filters.addEventListener('click', e => {
        const b = e.target.closest('.rv-filter');
        if (!b) return;
        $$('.rv-filter', filters).forEach(x => x.classList.toggle('on', x === b));
        current = b.dataset.k;
        shown = INITIAL_COUNT;
        render(true);
    });

    if (more) {
        more.addEventListener('click', () => {
            shown = MAX_COUNT;
            render(true);
        });
    }

    // Lightbox handler cho ảnh & video
    const lb = $('#lightbox'), lbBody = $('#lbBody');
    const closeLb = () => {
        if (!lb) return;
        gsap.to(lb, { opacity: 0, duration: 0.2, onComplete: () => {
            lb.hidden = true;
            if (lbBody) lbBody.innerHTML = '';
        } });
    };

    const extractYtId = url => {
        if (!url) return null;
        const m = url.match(/(?:shorts\/|watch\?v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/);
        return m ? m[1] : null;
    };

    grid.addEventListener('click', e => {
        const b = e.target.closest('.rv-media-btn');
        if (!b || !lb || !lbBody) return;

        if (b.dataset.video) {
            const vid = b.dataset.video;
            const ytId = extractYtId(vid);
            if (ytId) {
                lbBody.innerHTML = `<div style="position:relative;width:min(90vw, 420px);aspect-ratio:9/16;max-height:85vh;border-radius:20px;overflow:hidden;box-shadow:0 20px 50px rgba(0,0,0,0.5);"><iframe src="https://www.youtube-nocookie.com/embed/${ytId}?autoplay=1&playsinline=1&rel=0" style="width:100%;height:100%;border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>`;
            } else {
                lbBody.innerHTML = `<video src="${esc(vid)}" controls autoplay playsinline style="max-height:85vh;max-width:90vw;border-radius:18px;box-shadow:0 20px 50px rgba(0,0,0,0.5);"></video>`;
            }
        } else if (b.dataset.src) {
            lbBody.innerHTML = `<img src="${esc(b.dataset.src)}" alt="Ảnh đánh giá" style="max-height:85vh;max-width:90vw;object-fit:contain;border-radius:18px;box-shadow:0 20px 50px rgba(0,0,0,0.5);">`;
        }

        lb.hidden = false;
        gsap.fromTo(lb, { opacity: 0 }, { opacity: 1, duration: 0.25 });
        gsap.fromTo(lbBody, { scale: 0.9, y: 20 }, { scale: 1, y: 0, duration: 0.4, ease: 'back.out(1.8)' });
    });

    if (lb) {
        lb.addEventListener('click', e => {
            if (e.target === lb || e.target.closest('.lb-close')) closeLb();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && !lb.hidden) closeLb();
        });
    }

    render(false);
    gsap.fromTo('#rvGrid .rv-card', { y: 40, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7, stagger: 0.1, ease: 'back.out(1.6)', scrollTrigger: { trigger: '#rvGrid', start: 'top 85%' } });
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
    const money = v => v.toLocaleString('vi-VN') + 'đ';
    const offer = CONFIG.offer;
    $('#opPrice').textContent = offer.price ? money(offer.price) : 'Giá ưu đãi';
    $('#opOld').textContent = offer.old ? money(offer.old) : '';
    if (offer.price && offer.old) { $('#opOff').hidden = false; $('#opOff').textContent = '-' + Math.round((1 - offer.price / offer.old) * 100) + '%'; }
    gsap.fromTo('#opPrice', { scale: .6, opacity: 0 }, { scale: 1, opacity: 1, duration: 1, ease: 'elastic.out(1, .5)', scrollTrigger: { trigger: '#dang-ky', start: 'top 70%' } });
    gsap.fromTo('.oi-lion', { x: 60, rotate: 30, opacity: 0 }, { x: 0, rotate: 0, opacity: 1, duration: 1, ease: 'back.out(2)', scrollTrigger: { trigger: '.order-img', start: 'top 80%' } });
    if (!reduceMotion) gsap.to('.oi-bottle', { y: -12, rotate: -2, duration: 2.2, yoyo: true, repeat: -1, ease: 'sine.inOut' });

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
        if (form.dataset.submitting === 'true') {
            return;
        }

        const ph = phone.value.replace(/\s/g, '');
        const badName = name.value.trim().length < 2, badPhone = !phoneRe.test(ph);
        setErr(name, '#eName', badName);
        setErr(phone, '#ePhone', badPhone);
        if (badName || badPhone) { (badName ? name : phone).focus(); return; }

        form.dataset.submitting = 'true';
        const btn = $('#submitBtn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="bb"></i> Đang gửi đơn...';
        }

        const fd = new FormData(form);
        const giftVal = fd.get('gift') || (window.localStorage ? (localStorage.getItem('bonbon_gift_label') || '') : '') || 'Vịt tắm cute';
        const noteVal = 'Quà tặng: ' + giftVal;

        const data = {
            name: name.value.trim(),
            phone: ph,
            address: fd.get('address') || '',
            package: CONFIG.offer.label,
            price: CONFIG.offer.price || '',
            gift: giftVal,
            note: noteVal,
            ghi_chu: noteVal,
            'Ghi chú': noteVal,
            ghichu: noteVal,
            source: fd.get('source') || '',
            page: location.href.split('?')[0],
            product: 'Sữa tắm gội Bon Bon',
            time: new Date().toLocaleString('vi-VN')
        };

        // 1. Gửi qua WordPress AJAX handler (Server xử lý lưu DB, gửi Mail thông báo và forward Webhook duy nhất 1 lần để chống lặp đơn)
        if (CONFIG.ajaxUrl) {
            try {
                const wpBody = new URLSearchParams();
                wpBody.append('action', 'lx_submit_lead');
                wpBody.append('nonce', CONFIG.nonce || '');
                wpBody.append('name', data.name);
                wpBody.append('phone', data.phone);
                wpBody.append('address', data.address);
                wpBody.append('package', data.package);
                wpBody.append('price', data.price);
                wpBody.append('gift', data.gift);
                wpBody.append('note', data.note);
                wpBody.append('source', data.source);
                wpBody.append('page', data.page);

                await fetch(CONFIG.ajaxUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    body: wpBody.toString()
                }).catch(e => console.warn('[WP lead error]', e));
            } catch (e) {
                console.warn(e);
            }
        } else if (CONFIG.webhookUrl) {
            // Dự phòng: chỉ gọi trực tiếp Webhook khi không có endpoint WordPress AJAX
            try {
                await fetch(CONFIG.webhookUrl, {
                    method: 'POST',
                    mode: 'no-cors',
                    headers: { 'Content-Type': 'text/plain;charset=utf-8' },
                    body: JSON.stringify(data)
                });
            } catch (err) {
                console.error(err);
            }
        }

        // Conversion tracking
        try { window.fbq && fbq('track', 'Lead', { content_name: data.product }); } catch (e) {}
        try { window.ttq && ttq.track('SubmitForm'); } catch (e) {}
        try { window.gtag && gtag('event', 'generate_lead', { item_name: data.product }); } catch (e) {}
        try { (window.dataLayer = window.dataLayer || []).push({ event: 'lead_submit', ...data }); } catch (e) {}

        $('#sName').textContent = data.name;
        $('#sPhone').textContent = data.phone;
        $('#sPkg').textContent = data.package;
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

// ===== Typewriter effect cho phần CÂU CHUYỆN THƯƠNG HIỆU =====
(function () {
    function initStoryTypewriter() {
        const box = document.getElementById('storyTypewriterBox');
        if (!box) return;

        const bodyTarget = document.getElementById('storyTypewriterTarget');
        const highlightTarget = document.getElementById('storyTypewriterHighlight');
        if (!bodyTarget) return;

        const bodyTextSpan = bodyTarget.querySelector('.typewriter-text');
        const highlightTextSpan = highlightTarget ? highlightTarget.querySelector('.typewriter-highlight-text') : null;
        const cursor = box.querySelector('.typewriter-cursor');

        const bodyText = box.getAttribute('data-body') || box.getAttribute('data-text') || (bodyTextSpan ? bodyTextSpan.textContent.trim() : '');
        const highlightText = box.getAttribute('data-highlight') || (highlightTextSpan ? highlightTextSpan.textContent.trim() : '');

        if (!bodyText && !highlightText) return;

        if (bodyTextSpan) bodyTextSpan.textContent = '';
        if (highlightTextSpan) highlightTextSpan.textContent = '';
        if (highlightTarget) highlightTarget.style.display = 'none';

        if (cursor && bodyTarget) {
            bodyTarget.appendChild(cursor);
        }

        let hasStarted = false;

        function startTyping() {
            if (hasStarted) return;
            hasStarted = true;

            let bodyIndex = 0;
            let highlightIndex = 0;
            const speed = 25; // 25ms mỗi ký tự

            function typeBody() {
                if (bodyIndex < bodyText.length) {
                    if (bodyTextSpan) {
                        bodyTextSpan.textContent += bodyText.charAt(bodyIndex);
                    }
                    bodyIndex++;
                    const char = bodyText.charAt(bodyIndex - 1);
                    const delay = (char === '.' || char === ',' || char === '—') ? 70 : speed;
                    setTimeout(typeBody, delay);
                } else if (highlightText && highlightTextSpan) {
                    setTimeout(() => {
                        if (highlightTarget) {
                            highlightTarget.style.display = 'block';
                        }
                        if (cursor && highlightTarget) {
                            highlightTarget.appendChild(cursor);
                        }
                        typeHighlight();
                    }, 300);
                } else {
                    finishTyping();
                }
            }

            function typeHighlight() {
                if (highlightIndex < highlightText.length) {
                    if (highlightTextSpan) {
                        highlightTextSpan.textContent += highlightText.charAt(highlightIndex);
                    }
                    highlightIndex++;
                    const char = highlightText.charAt(highlightIndex - 1);
                    const delay = (char === '-' || char === ',' || char === '.') ? 80 : speed;
                    setTimeout(typeHighlight, delay);
                } else {
                    finishTyping();
                }
            }

            function finishTyping() {
                setTimeout(() => {
                    if (cursor) cursor.classList.add('cursor-finished');
                }, 3000);
            }

            if (bodyText.length > 0) {
                typeBody();
            } else if (highlightText.length > 0) {
                if (highlightTarget) highlightTarget.style.display = 'block';
                if (cursor && highlightTarget) highlightTarget.appendChild(cursor);
                typeHighlight();
            }
        }

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        startTyping();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            observer.observe(box);
        } else {
            startTyping();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStoryTypewriter);
    } else {
        initStoryTypewriter();
    }
})();

// ===== TIKTOK / REELS SHORT-FORM VIDEO SHOWCASE (IDEA 4) =====
(function () {
    function initReelsShowcase() {
        const track = document.getElementById('reelsTrack');
        if (!track) return;

        const prevBtn = document.getElementById('reelPrev');
        const nextBtn = document.getElementById('reelNext');
        const cards = track.querySelectorAll('.reel-card');

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                const cardWidth = cards[0] ? cards[0].offsetWidth + 20 : 300;
                track.scrollBy({ left: -cardWidth, behavior: 'smooth' });
            });
            nextBtn.addEventListener('click', () => {
                const cardWidth = cards[0] ? cards[0].offsetWidth + 20 : 300;
                track.scrollBy({ left: cardWidth, behavior: 'smooth' });
            });
        }

        function showReelToast(msg) {
            toast(msg, 2400);
        }

        function spawnFloatingHearts(container, x, y) {
            for (let i = 0; i < 5; i++) {
                const heart = document.createElement('span');
                heart.className = 'floating-mini-heart';
                heart.textContent = '❤️';
                heart.style.left = (x ? (x + (Math.random() * 40 - 20)) : (container.offsetWidth - 35)) + 'px';
                heart.style.top = (y ? (y + (Math.random() * 30 - 15)) : (container.offsetHeight - 120)) + 'px';
                heart.style.fontSize = (16 + Math.random() * 14) + 'px';
                container.appendChild(heart);
                setTimeout(() => heart.remove(), 1200);
            }
        }

        cards.forEach((card) => {
            const videoContainer = card.querySelector('.reel-video-container');
            const videoEl = card.querySelector('.js-reel-video');
            const playBtn = card.querySelector('.js-reel-play');
            const soundBtn = card.querySelector('.js-reel-sound');
            const soundIcon = soundBtn ? soundBtn.querySelector('.sound-icon') : null;
            const likeBtn = card.querySelector('.js-reel-like');
            const likeIcon = likeBtn ? likeBtn.querySelector('.heart-icon') : null;
            const likeCountEl = likeBtn ? likeBtn.querySelector('.count-like') : null;
            const commentBtn = card.querySelector('.js-reel-comment');
            const shareBtn = card.querySelector('.js-reel-share');
            const bigHeart = card.querySelector('.reel-big-heart');

            const formatCount = (n) => n >= 1000 ? (n / 1000).toFixed(1).replace('.0', '') + 'K' : String(n);

            let lastTap = 0;
            let tapTimer = null;
            if (videoContainer) {
                videoContainer.addEventListener('click', (e) => {
                    if (e.target.closest('.reel-like-wrap') || e.target.closest('.reel-top-bar') || e.target.closest('.reel-play-btn')) {
                        return;
                    }

                    const currentTime = new Date().getTime();
                    const tapLength = currentTime - lastTap;
                    if (tapLength < 320 && tapLength > 0) {
                        clearTimeout(tapTimer);
                        if (bigHeart) {
                            bigHeart.classList.remove('pop');
                            void bigHeart.offsetWidth;
                            bigHeart.classList.add('pop');
                        }
                        if (likeBtn && !likeBtn.classList.contains('is-liked')) {
                            likeBtn.click();
                        } else if (videoContainer) {
                            const rect = videoContainer.getBoundingClientRect();
                            spawnFloatingHearts(videoContainer, e.clientX - rect.left, e.clientY - rect.top);
                        }
                        lastTap = 0;
                    } else {
                        lastTap = currentTime;
                        tapTimer = setTimeout(() => {
                            togglePlay();
                        }, 300);
                    }
                });
            }

            function togglePlay() {
                const ytId = card.dataset.ytId;
                if (ytId) {
                    let iframe = videoContainer.querySelector('.js-reel-yt-iframe');
                    if (!iframe) {
                        // Pause all HTML5 videos
                        document.querySelectorAll('.js-reel-video').forEach(v => {
                            v.pause();
                            v.closest('.reel-card')?.classList.remove('is-playing', 'has-yt-playing');
                        });
                        // Remove any other playing YouTube iframes
                        document.querySelectorAll('.js-reel-yt-iframe').forEach(f => {
                            f.closest('.reel-card')?.classList.remove('is-playing', 'has-yt-playing');
                            f.remove();
                        });

                        iframe = document.createElement('iframe');
                        iframe.className = 'reel-video-el js-reel-yt-iframe';
                        iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(ytId) + '?autoplay=1&playsinline=1&rel=0&controls=1&modestbranding=1';
                        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                        iframe.allowFullscreen = true;
                        iframe.style.zIndex = '3';
                        iframe.style.border = '0';
                        videoContainer.appendChild(iframe);
                        card.classList.add('is-playing', 'has-yt-playing');
                    } else {
                        card.classList.remove('is-playing', 'has-yt-playing');
                        iframe.remove();
                    }
                    return;
                }

                if (videoEl) {
                    if (videoEl.paused) {
                        document.querySelectorAll('.js-reel-video').forEach(v => {
                            if (v !== videoEl) {
                                v.pause();
                                v.closest('.reel-card')?.classList.remove('is-playing', 'has-yt-playing');
                            }
                        });
                        document.querySelectorAll('.js-reel-yt-iframe').forEach(f => {
                            f.closest('.reel-card')?.classList.remove('is-playing', 'has-yt-playing');
                            f.remove();
                        });
                        videoEl.play().then(() => {
                            card.classList.add('is-playing');
                        }).catch(() => {
                            card.classList.toggle('is-playing');
                        });
                    } else {
                        videoEl.pause();
                        card.classList.remove('is-playing');
                    }
                } else {
                    card.classList.toggle('is-playing');
                }
            }

            if (playBtn) {
                playBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    togglePlay();
                });
            }

            if (soundBtn && videoEl) {
                soundBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    videoEl.muted = !videoEl.muted;
                    if (soundIcon) {
                        soundIcon.textContent = videoEl.muted ? '🔇' : '🔊';
                    }
                });
            }

            if (likeBtn) {
                likeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isLiked = likeBtn.classList.contains('is-liked');
                    let count = parseInt(likeBtn.getAttribute('data-count'), 10) || 12800;

                    if (!isLiked) {
                        likeBtn.classList.add('is-liked');
                        count += 1;
                        if (likeIcon) likeIcon.textContent = '❤️';
                        if (videoContainer) spawnFloatingHearts(videoContainer);
                    } else {
                        likeBtn.classList.remove('is-liked');
                        count = Math.max(0, count - 1);
                        if (likeIcon) likeIcon.textContent = '🤍';
                    }

                    likeBtn.setAttribute('data-count', count);
                    if (likeCountEl) {
                        likeCountEl.textContent = formatCount(count);
                    }
                });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initReelsShowcase);
    } else {
        initReelsShowcase();
    }
})();

