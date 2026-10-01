<script setup>
defineProps({
    // 'light' : sur fond clair — 'dark' : sur fond marine
    theme: { type: String, default: 'light' },
    compact: { type: Boolean, default: false },
});
</script>

<template>
    <span class="inline-flex items-center gap-3 select-none">
        <!--
            Sur fond marine, le bleu du monogramme disparaît : il est posé
            sur une pastille ivoire, la forme de l'ellipse du logo.
        -->
        <span
            class="grid shrink-0 place-items-center"
            :class="theme === 'dark' ? 'rounded-full bg-ivoire px-3 py-2.5' : ''"
        >
            <img
                src="/logo-mark.webp"
                alt=""
                width="400"
                height="287"
                :class="compact ? 'h-9 w-auto' : 'h-11 w-auto'"
                decoding="async"
            />
        </span>
        <!-- Le logotype est composé en capitales, comme sur le logo. -->
        <span class="flex flex-col leading-none">
            <span
                class="font-display font-semibold tracking-[0.08em]"
                :class="[compact ? 'text-[1.35rem]' : 'text-[1.7rem]', theme === 'dark' ? 'text-white' : 'text-marine-900']"
            >
                CLEAN
            </span>
            <span
                class="mt-1 font-medium tracking-[0.42em]"
                :class="[compact ? 'text-[0.5rem]' : 'text-[0.6rem]', theme === 'dark' ? 'text-sauge-200' : 'text-sauge-700']"
            >
                COMPANY
            </span>
        </span>
    </span>
</template>
