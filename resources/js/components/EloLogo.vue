<script setup>
defineProps({
    theme: { type: String, default: 'light' }, // 'light' => sur fond clair, 'dark' => sur fond bleu foncé
    compact: { type: Boolean, default: false },
});
</script>

<template>
    <span class="inline-flex items-center gap-2.5 select-none">
        <span
            class="grid place-items-center rounded-xl shadow-sm"
            :class="compact ? 'size-9' : 'size-10'"
            style="background: linear-gradient(135deg, #7dd3fc 0%, #2563eb 50%, #0f2456 100%)"
        >
            <svg viewBox="0 0 64 64" class="h-3/5 w-3/5" fill="none" aria-hidden="true">
                <path d="M32 14c6 8 11 13 11 20a11 11 0 0 1-22 0c0-7 5-12 11-20z" fill="#fff" fill-opacity="0.95" />
                <path d="M40 25l1.7 3.6L45.5 30l-3.8 1.4L40 35l-1.7-3.6L34.5 30l3.8-1.4L40 25z" fill="#38bdf8" />
            </svg>
        </span>
        <span class="font-display font-extrabold tracking-tight" :class="compact ? 'text-lg' : 'text-xl'">
            <span class="text-gradient">Elo</span>
            <span :class="theme === 'dark' ? 'text-white' : 'text-ink-900'"> Glass</span>
        </span>
    </span>
</template>
