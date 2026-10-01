<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import Sparkle from './Sparkle.vue';

const props = defineProps({
    steps: { type: Array, required: true },
});

/*
| Le fil se remplit à mesure que la section défile : le visiteur voit
| où il en est dans le déroulé.
*/
const root = ref(null);
const progress = ref(0);

let frame = null;

function measure() {
    frame = null;

    if (! root.value) {
        return;
    }

    const rect = root.value.getBoundingClientRect();
    const anchor = window.innerHeight * 0.62;

    progress.value = Math.min(1, Math.max(0, (anchor - rect.top) / rect.height));
}

function onScroll() {
    frame ??= requestAnimationFrame(measure);
}

function reached(index) {
    return progress.value >= (index + 0.35) / props.steps.length;
}

onMounted(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        progress.value = 1;

        return;
    }

    measure();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    window.removeEventListener('resize', onScroll);
    cancelAnimationFrame(frame);
});
</script>

<template>
    <ol ref="root" class="relative">
        <!-- Le fil : fond discret, puis remplissage sauge piloté par le défilement. -->
        <span class="absolute top-2 bottom-2 left-[0.6875rem] w-px bg-white/15" aria-hidden="true" />
        <span
            class="absolute top-2 bottom-2 left-[0.6875rem] w-px origin-top bg-sauge-400"
            :style="{ transform: `scaleY(${progress})` }"
            aria-hidden="true"
        />

        <li
            v-for="(step, i) in steps"
            :key="step.title"
            class="relative pb-12 pl-12 last:pb-0 sm:pl-16"
        >
            <span
                class="absolute top-1 left-0 grid size-[1.4375rem] place-items-center rounded-full border transition-all duration-500"
                :class="reached(i) ? 'border-sauge-400 bg-sauge-400 text-marine-950' : 'border-white/30 bg-marine-900 text-transparent'"
                aria-hidden="true"
            >
                <Sparkle class="size-2.5 transition-transform duration-500" :class="reached(i) ? 'scale-100' : 'scale-0'" />
            </span>

            <div class="transition-opacity duration-500" :class="reached(i) ? 'opacity-100' : 'opacity-60'">
                <p class="text-sm font-medium text-sauge-200">{{ step.when }}</p>
                <h3 class="mt-1 font-display text-[length:var(--step-h3)] text-white">{{ step.title }}</h3>
                <p class="mt-2 max-w-md leading-relaxed text-white/70">{{ step.text }}</p>
            </div>
        </li>
    </ol>
</template>
