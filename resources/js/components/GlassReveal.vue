<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { MoveHorizontal } from 'lucide-vue-next';

/**
 * Carreau interactif : on fait glisser la raclette pour nettoyer la vitre.
 * C'est exactement le geste que vend l'entreprise — d'où sa place sur la page.
 *
 * L'interaction repose sur un <input type="range"> transparent : le clavier,
 * le tactile et la souris fonctionnent sans code supplémentaire.
 */
const clean = ref(0);
const root = ref(null);
let observer;
let raf;

function animateHint() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        clean.value = 55;

        return;
    }

    const start = performance.now();
    const duration = 1100;
    const target = 58;

    const tick = (now) => {
        const t = Math.min((now - start) / duration, 1);
        // Décélération : le geste ralentit en fin de course, comme une vraie raclette.
        clean.value = target * (1 - Math.pow(1 - t, 3));

        if (t < 1) {
            raf = requestAnimationFrame(tick);
        }
    };

    raf = requestAnimationFrame(tick);
}

onMounted(() => {
    if (typeof IntersectionObserver === 'undefined') {
        clean.value = 55;

        return;
    }

    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateHint();
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.45 },
    );

    if (root.value) {
        observer.observe(root.value);
    }
});

onBeforeUnmount(() => {
    observer?.disconnect();
    cancelAnimationFrame(raf);
});
</script>

<template>
    <figure ref="root" class="m-0">
        <div class="pane relative overflow-hidden shadow-pane">
            <div class="relative aspect-[5/4] w-full sm:aspect-[16/10]">
                <!-- La vue derrière la vitre : une skyline, comme les immeubles du logo. -->
                <svg
                    class="absolute inset-0 size-full"
                    viewBox="0 0 800 500"
                    preserveAspectRatio="xMidYMid slice"
                    aria-hidden="true"
                >
                    <defs>
                        <linearGradient id="gr-sky" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#bfdcf1" />
                            <stop offset="55%" stop-color="#e2eff9" />
                            <stop offset="100%" stop-color="#f5fafd" />
                        </linearGradient>
                        <linearGradient id="gr-far" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#9bc9e8" />
                            <stop offset="100%" stop-color="#c4dcee" />
                        </linearGradient>
                        <linearGradient id="gr-mid" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#3f7fbb" />
                            <stop offset="100%" stop-color="#6ea3ce" />
                        </linearGradient>
                        <linearGradient id="gr-near" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#0b275e" />
                            <stop offset="100%" stop-color="#164a8e" />
                        </linearGradient>
                    </defs>

                    <rect width="800" height="500" fill="url(#gr-sky)" />
                    <circle cx="628" cy="104" r="42" fill="#ffffff" opacity="0.85" />
                    <circle cx="628" cy="104" r="66" fill="#ffffff" opacity="0.32" />

                    <!-- Plan lointain -->
                    <g fill="url(#gr-far)">
                        <rect x="20" y="250" width="70" height="250" />
                        <rect x="104" y="212" width="54" height="288" />
                        <rect x="176" y="272" width="86" height="228" />
                        <rect x="470" y="238" width="62" height="262" />
                        <rect x="548" y="286" width="96" height="214" />
                        <rect x="662" y="232" width="58" height="268" />
                        <rect x="734" y="278" width="54" height="222" />
                    </g>

                    <!-- Plan intermédiaire -->
                    <g fill="url(#gr-mid)">
                        <rect x="286" y="182" width="78" height="318" />
                        <polygon points="286,182 325,146 364,182" />
                        <rect x="386" y="252" width="66" height="248" />
                        <rect x="592" y="330" width="74" height="170" />
                    </g>

                    <!-- Premier plan -->
                    <g fill="url(#gr-near)">
                        <rect x="0" y="352" width="118" height="148" />
                        <rect x="140" y="392" width="96" height="108" />
                        <rect x="672" y="366" width="128" height="134" />
                    </g>

                    <!-- Fenêtres allumées -->
                    <g fill="#ffffff" opacity="0.55">
                        <rect x="300" y="208" width="12" height="18" />
                        <rect x="322" y="208" width="12" height="18" />
                        <rect x="300" y="246" width="12" height="18" />
                        <rect x="338" y="284" width="12" height="18" />
                        <rect x="20" y="378" width="16" height="22" />
                        <rect x="52" y="378" width="16" height="22" />
                        <rect x="20" y="422" width="16" height="22" />
                        <rect x="700" y="396" width="18" height="24" />
                        <rect x="736" y="396" width="18" height="24" />
                        <rect x="700" y="440" width="18" height="24" />
                    </g>
                </svg>

                <!-- La saleté, révélée à droite de la raclette -->
                <div
                    class="grime absolute inset-0"
                    :style="{ clipPath: `inset(0 0 0 ${clean}%)` }"
                    aria-hidden="true"
                />

                <!-- Reflet du vitrage, toujours présent -->
                <div class="pointer-events-none absolute inset-0 bg-linear-[128deg,rgba(255,255,255,0.42)_0%,transparent_38%]" aria-hidden="true" />

                <!-- Meneaux : c'est bien une fenêtre -->
                <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                    <span class="absolute inset-y-0 left-1/2 w-px -translate-x-1/2 bg-white/60" />
                    <span class="absolute inset-x-0 top-1/2 h-px -translate-y-1/2 bg-white/60" />
                </div>

                <!-- La raclette -->
                <div
                    class="pointer-events-none absolute inset-y-0 z-10 w-0"
                    :style="{ left: clean + '%' }"
                    aria-hidden="true"
                >
                    <span class="absolute inset-y-0 -left-[3px] w-[6px] rounded-full bg-linear-to-b from-graphite-700 via-graphite-900 to-graphite-700 shadow-[0_0_12px_rgba(11,39,94,0.45)]" />
                    <span class="absolute inset-y-0 left-[3px] w-[10px] bg-linear-to-r from-white/85 to-transparent" />
                    <span class="absolute top-1/2 left-1/2 grid size-11 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border-2 border-white bg-graphite-900 text-white shadow-lift">
                        <MoveHorizontal class="size-5" />
                    </span>
                </div>

                <!-- Étiquettes d'état -->
                <span class="absolute bottom-3 left-3 z-10 rounded-[5px] bg-white/90 px-2.5 py-1 text-[0.7rem] font-semibold tracking-wide text-nuit-800 uppercase">
                    Après
                </span>
                <span class="absolute right-3 bottom-3 z-10 rounded-[5px] bg-graphite-900/80 px-2.5 py-1 text-[0.7rem] font-semibold tracking-wide text-white uppercase">
                    Avant
                </span>

                <!-- Contrôle réel : invisible, mais pilotable au doigt et au clavier -->
                <input
                    v-model.number="clean"
                    type="range"
                    min="0"
                    max="100"
                    step="0.5"
                    class="glass-range absolute inset-0 z-20 size-full cursor-ew-resize appearance-none bg-transparent"
                    aria-label="Faire glisser la raclette pour nettoyer la vitre"
                />
            </div>
        </div>
        <figcaption class="mt-3 text-center text-sm text-graphite-500">
            Faites glisser la raclette — c'est le geste, et le résultat.
        </figcaption>
    </figure>
</template>

<style scoped>
/*
| La saleté : un voile gris, des coulures verticales, des gouttes séchées et
| un flou du décor situé derrière. C'est ce flou qui rend l'effet crédible.
*/
.grime {
    backdrop-filter: blur(4px) saturate(0.35) brightness(1.06) contrast(0.82);
    -webkit-backdrop-filter: blur(4px) saturate(0.35) brightness(1.06) contrast(0.82);
    background-color: rgba(147, 138, 116, 0.36);
    background-image:
        radial-gradient(circle at 22% 28%, rgba(255, 255, 255, 0.5) 0 3px, transparent 4px),
        radial-gradient(circle at 68% 16%, rgba(120, 112, 96, 0.35) 0 5px, transparent 6px),
        radial-gradient(circle at 84% 62%, rgba(255, 255, 255, 0.45) 0 4px, transparent 5px),
        radial-gradient(circle at 40% 74%, rgba(120, 112, 96, 0.3) 0 6px, transparent 7px),
        radial-gradient(circle at 56% 44%, rgba(255, 255, 255, 0.4) 0 2px, transparent 3px),
        radial-gradient(circle at 12% 82%, rgba(120, 112, 96, 0.28) 0 4px, transparent 5px),
        repeating-linear-gradient(
            97deg,
            rgba(255, 255, 255, 0.14) 0 7px,
            transparent 7px 22px
        );
}

/*
| La piste et le curseur natifs sont masqués : la raclette dessinée au-dessus
| joue le rôle de curseur. La zone tactile reste, elle, pleine hauteur.
*/
.glass-range::-webkit-slider-thumb {
    appearance: none;
    width: 56px;
    height: 100%;
    background: transparent;
    cursor: ew-resize;
}
.glass-range::-moz-range-thumb {
    width: 56px;
    height: 999px;
    border: none;
    background: transparent;
    cursor: ew-resize;
}
.glass-range:focus-visible {
    outline: 2px solid var(--color-elo-600);
    outline-offset: 2px;
}
</style>
