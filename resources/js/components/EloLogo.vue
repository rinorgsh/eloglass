<script setup>
defineProps({
    // 'light' : sur fond clair — 'dark' : sur fond bleu profond
    theme: { type: String, default: 'light' },
    compact: { type: Boolean, default: false },
});
</script>

<template>
    <span class="inline-flex items-center gap-2.5 select-none">
        <!--
            Sur fond bleu profond, le graphite de la raclette disparaît :
            le monogramme est posé sur un carreau blanc.
        -->
        <span
            class="grid shrink-0 place-items-center"
            :class="theme === 'dark' ? 'rounded-[7px] bg-white p-1.5' : ''"
        >
            <img
                src="/logo-mark.webp"
                alt=""
                width="256"
                height="246"
                :class="compact ? 'h-9 w-auto' : 'h-10 w-auto'"
                decoding="async"
            />
        </span>
        <span class="flex flex-col leading-none">
            <span
                class="font-display font-extrabold tracking-[0.14em]"
                :class="[compact ? 'text-[0.95rem]' : 'text-lg', theme === 'dark' ? 'text-white' : 'text-nuit-800']"
            >
                ELO<span :class="theme === 'dark' ? 'text-ciel-300' : 'text-elo-600'"> GLASS</span>
            </span>
            <span
                v-if="!compact"
                class="mt-1 text-[0.6rem] font-medium tracking-[0.12em] uppercase"
                :class="theme === 'dark' ? 'text-ciel-300/80' : 'text-graphite-500'"
            >
                Lavage de vitres
            </span>
        </span>
    </span>
</template>
