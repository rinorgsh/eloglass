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
    <div class="divide-y divide-filet border-y border-filet">
        <details v-for="item in items" :key="item.q" class="group">
            <summary
                class="flex cursor-pointer list-none items-start justify-between gap-4 py-5 text-left"
            >
                <h3 class="font-display text-[1.0625rem] font-semibold leading-snug text-nuit-800">
                    {{ item.q }}
                </h3>
                <span
                    class="mt-0.5 grid size-7 shrink-0 place-items-center rounded-full border border-filet bg-verre-50 text-elo-600 transition group-open:rotate-45 group-open:border-elo-600 group-open:bg-elo-600 group-open:text-white"
                    aria-hidden="true"
                >
                    <Plus class="size-4" />
                </span>
            </summary>
            <p class="max-w-2xl pb-6 leading-relaxed text-graphite-500">{{ item.a }}</p>
        </details>
    </div>
</template>

<style scoped>
/* Masque le triangle par défaut (Safari inclus). */
summary::-webkit-details-marker {
    display: none;
}
</style>
