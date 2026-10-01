<script setup>
import Sparkle from './Sparkle.vue';
</script>

<template>
    <!--
        Les deux ellipses entrelacées du monogramme, agrandies. Elles se
        tracent au chargement, puis suivent légèrement le pointeur (les
        variables --px / --py sont posées par la section parente).
    -->
    <div class="orbit pointer-events-none" aria-hidden="true">
        <svg viewBox="0 0 640 520" fill="none" class="size-full overflow-visible">
            <g class="calque calque-1">
                <ellipse
                    class="trace"
                    cx="270" cy="250" rx="250" ry="128"
                    transform="rotate(-9 270 250)"
                    pathLength="1"
                    stroke="var(--color-marine-900)"
                    stroke-width="1.5"
                />
            </g>
            <g class="calque calque-2">
                <ellipse
                    class="trace trace-2"
                    cx="380" cy="262" rx="262" ry="132"
                    transform="rotate(-21 380 262)"
                    pathLength="1"
                    stroke="var(--color-sauge-600)"
                    stroke-width="1.5"
                />
            </g>
        </svg>

        <Sparkle class="etoile scintille text-marine-900" style="top: 62%; left: 86%; width: 2.25rem; --d: 0ms" />
        <Sparkle class="etoile scintille text-sauge-600" style="top: 8%; left: 14%; width: 1.1rem; --d: 900ms" />
        <Sparkle class="etoile scintille text-sauge-400" style="top: 88%; left: 30%; width: 0.8rem; --d: 1800ms" />
    </div>
</template>

<style scoped>
.orbit {
    position: absolute;
}

.calque {
    transition: transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
}
.calque-1 {
    transform: translate(calc(var(--px, 0) * 14px), calc(var(--py, 0) * 10px));
}
.calque-2 {
    transform: translate(calc(var(--px, 0) * -20px), calc(var(--py, 0) * -14px));
}

.trace {
    stroke-dasharray: 1;
    stroke-dashoffset: 1;
    animation: tracer 2.2s cubic-bezier(0.65, 0, 0.35, 1) 0.2s forwards;
}
.trace-2 {
    animation-delay: 0.55s;
}
@keyframes tracer {
    to {
        stroke-dashoffset: 0;
    }
}

.etoile {
    position: absolute;
    height: auto;
    opacity: 0;
    animation:
        apparaitre 0.8s ease 1.9s forwards,
        scintiller 3.6s ease-in-out 2.7s infinite;
}
@keyframes apparaitre {
    from {
        opacity: 0;
        transform: scale(0.2) rotate(-45deg);
    }
    to {
        opacity: 1;
        transform: none;
    }
}

@media (prefers-reduced-motion: reduce) {
    .trace {
        stroke-dashoffset: 0;
    }
    .etoile {
        opacity: 1;
    }
}
</style>
