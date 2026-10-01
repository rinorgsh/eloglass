<script setup>
import { Plus } from 'lucide-vue-next';

defineProps({
    items: { type: Array, required: true },
});
</script>

<template>
    <!--
        <details> natif : accessible au clavier, ouvrable sans JavaScript,
        et le texte des réponses reste dans le DOM pour l'indexation.
    -->
    <div class="border-b border-filet">
        <details v-for="item in items" :key="item.q" class="group border-t border-filet">
            <summary class="flex cursor-pointer list-none items-start justify-between gap-6 py-5 text-left">
                <h3 class="font-display text-[1.375rem] leading-snug font-medium text-marine-900 transition-colors group-hover:text-sauge-700">
                    {{ item.q }}
                </h3>
                <Plus
                    class="mt-1.5 size-5 shrink-0 text-marine-900 transition-transform duration-300 group-open:rotate-45"
                    stroke-width="1.5"
                    aria-hidden="true"
                />
            </summary>
            <p class="reponse max-w-2xl pb-6 leading-relaxed text-encre-600">{{ item.a }}</p>
        </details>
    </div>
</template>

<style scoped>
/* Masque le triangle par défaut (Safari inclus). */
summary::-webkit-details-marker {
    display: none;
}

details[open] .reponse {
    animation: deplier 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes deplier {
    from {
        opacity: 0;
        transform: translateY(-6px);
    }
}
</style>
