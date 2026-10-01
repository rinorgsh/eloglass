<script setup>
import Sparkle from './Sparkle.vue';

defineProps({
    items: { type: Array, required: true },
});
</script>

<template>
    <!--
        Bandeau défilant des prestations. La liste est doublée pour boucler
        sans couture ; la seconde copie est masquée aux lecteurs d'écran.
        Le défilement s'arrête au survol.
    -->
    <div class="ticker border-y border-filet bg-lin py-5">
        <div class="piste">
            <ul v-for="copy in 2" :key="copy" class="flex shrink-0 items-center" :aria-hidden="copy === 2">
                <li v-for="item in items" :key="item" class="flex shrink-0 items-center">
                    <span class="px-6 font-display text-2xl whitespace-nowrap text-marine-900 sm:px-8 sm:text-[1.75rem]">{{ item }}</span>
                    <Sparkle class="size-3 shrink-0 text-sauge-600" />
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.ticker {
    overflow: hidden;
    mask-image: linear-gradient(90deg, transparent, #000 8%, #000 92%, transparent);
}
.piste {
    display: flex;
    width: max-content;
    animation: defiler 55s linear infinite;
}
.ticker:hover .piste {
    animation-play-state: paused;
}
@keyframes defiler {
    to {
        transform: translateX(-50%);
    }
}
@media (prefers-reduced-motion: reduce) {
    .piste {
        animation: none;
    }
}
</style>
