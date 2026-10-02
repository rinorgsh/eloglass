<script setup>
import { ref, computed } from 'vue';
import { Star } from 'lucide-vue-next';

const props = defineProps({
    // { rating, count, reviewUrl, mapsUrl, reviews: [{ author, photo, rating, text, date }] }
    data: { type: Object, required: true },
});

const rating = computed(() => props.data.rating.toFixed(1).replace('.', ','));

// Les avis longs sont repliés ; le visiteur les déplie un par un.
const LIMIT = 220;
const expanded = ref(new Set());

function isLong(review) {
    return review.text.length > LIMIT;
}

function shown(review, index) {
    return isLong(review) && ! expanded.value.has(index)
        ? review.text.slice(0, LIMIT).trimEnd() + '…'
        : review.text;
}

function toggle(index) {
    const next = new Set(expanded.value);

    next.has(index) ? next.delete(index) : next.add(index);
    expanded.value = next;
}

function formatDate(date) {
    return date
        ? new Date(date).toLocaleDateString('fr-BE', { month: 'long', year: 'numeric' })
        : '';
}
</script>

<template>
    <section id="avis" class="section-y border-t border-filet">
        <div class="wrap">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="reveal text-[length:var(--step-h2)]">Ce que disent nos clients</h2>
                    <p class="reveal mt-4 flex flex-wrap items-center gap-x-3 gap-y-1 text-encre-600" style="--d: 80ms">
                        <span class="font-display text-4xl leading-none text-marine-900">{{ rating }}</span>
                        <span class="flex gap-0.5" role="img" :aria-label="'Note moyenne : ' + rating + ' sur 5'">
                            <Star
                                v-for="n in 5"
                                :key="n"
                                class="size-5"
                                :class="n <= Math.round(data.rating) ? 'fill-[#f5b400] text-[#f5b400]' : 'text-filet'"
                                stroke-width="1.5"
                                aria-hidden="true"
                            />
                        </span>
                        <span>sur {{ data.count }} avis Google</span>
                    </p>
                </div>

                <div class="reveal flex flex-col gap-3 sm:flex-row" style="--d: 160ms">
                    <a v-if="data.mapsUrl" :href="data.mapsUrl" target="_blank" rel="noopener" class="btn btn-ghost">
                        Voir tous les avis
                    </a>
                    <a v-if="data.reviewUrl" :href="data.reviewUrl" target="_blank" rel="noopener" class="btn btn-primary">
                        Laisser un avis
                    </a>
                </div>
            </div>

            <!-- Sur mobile, les avis défilent de côté, un par un ; sur ordinateur, ils sont en colonnes. -->
            <ul class="avis mt-10 flex snap-x snap-mandatory gap-4 overflow-x-auto pb-3 lg:grid lg:grid-cols-3 lg:overflow-visible lg:pb-0">
                <li
                    v-for="(review, i) in data.reviews"
                    :key="i"
                    class="carte reveal flex w-[85%] shrink-0 snap-start flex-col p-6 sm:w-[46%] lg:w-auto"
                    :style="{ '--d': (i % 3) * 90 + 'ms' }"
                >
                    <span class="flex gap-0.5" role="img" :aria-label="review.rating + ' étoiles sur 5'">
                        <Star
                            v-for="n in 5"
                            :key="n"
                            class="size-4"
                            :class="n <= review.rating ? 'fill-[#f5b400] text-[#f5b400]' : 'text-filet'"
                            stroke-width="1.5"
                            aria-hidden="true"
                        />
                    </span>

                    <blockquote class="mt-4 flex-1 leading-relaxed text-encre-900">
                        {{ shown(review, i) }}
                        <button
                            v-if="isLong(review)"
                            type="button"
                            class="lien ml-1 font-medium text-marine-900"
                            :aria-expanded="expanded.has(i)"
                            @click="toggle(i)"
                        >
                            {{ expanded.has(i) ? 'Réduire' : 'Lire la suite' }}
                        </button>
                    </blockquote>

                    <footer class="mt-5 flex items-center gap-3 border-t border-filet pt-4">
                        <img
                            v-if="review.photo"
                            :src="review.photo"
                            alt=""
                            width="40"
                            height="40"
                            loading="lazy"
                            referrerpolicy="no-referrer"
                            class="size-10 rounded-full"
                        />
                        <span v-else class="grid size-10 place-items-center rounded-full bg-sauge-100 font-display text-xl text-sauge-700" aria-hidden="true">
                            {{ review.author.charAt(0) }}
                        </span>
                        <span>
                            <span class="block font-medium text-marine-900">{{ review.author }}</span>
                            <span class="block text-sm text-encre-600">{{ formatDate(review.date) }}</span>
                        </span>
                    </footer>
                </li>
            </ul>
        </div>
    </section>
</template>

<style scoped>
.avis {
    scrollbar-width: thin;
    scrollbar-color: var(--color-sauge-200) transparent;
}
</style>
