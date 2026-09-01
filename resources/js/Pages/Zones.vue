<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Phone, MapPin, ChevronRight, ArrowRight } from 'lucide-vue-next';
import SiteLayout from '../Layouts/SiteLayout.vue';
import { useReveal } from '../composables/useReveal';

const props = defineProps({
    seo: { type: Object, required: true },
    zones: { type: Array, required: true },
});

useReveal();

const page = usePage();
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);

// Regroupement par province : c'est ainsi que les clients situent leur commune.
const grouped = computed(() => {
    const map = new Map();

    props.zones.forEach((zone) => {
        if (! map.has(zone.province)) {
            map.set(zone.province, []);
        }

        map.get(zone.province).push(zone);
    });

    return Array.from(map, ([province, list]) => ({ province, list }));
});
</script>

<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>

    <SiteLayout>
        <section class="relative overflow-hidden border-b border-filet pt-24 pb-12 sm:pt-28 lg:pt-32">
            <div
                class="pointer-events-none absolute inset-x-0 -top-24 -z-10 h-[24rem] bg-linear-[168deg,var(--color-ciel-100)_0%,var(--color-verre-50)_50%,#ffffff_100%]"
                aria-hidden="true"
            />
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <nav aria-label="Fil d'Ariane" class="mb-6 flex items-center gap-1.5 text-sm text-graphite-400">
                    <Link href="/" class="transition hover:text-elo-600">Accueil</Link>
                    <ChevronRight class="size-3.5" aria-hidden="true" />
                    <span class="text-graphite-700">Zones d’intervention</span>
                </nav>

                <p class="eyebrow reveal text-elo-600">Zones d’intervention</p>
                <h1 class="reveal mt-4 max-w-3xl font-display text-[length:var(--step-h1)] leading-[1.05] font-extrabold text-nuit-800">
                    Lavage de vitres à <span class="text-shine">Bruxelles</span> et en périphérie
                </h1>
                <p class="reveal mt-5 max-w-2xl text-[length:var(--step-lead)] leading-relaxed text-graphite-500">
                    Les 19 communes bruxelloises et la périphérie proche. Choisissez la vôtre pour voir comment
                    nous y travaillons — ou appelez-nous, nous vous répondrons en un instant.
                </p>
                <a :href="phoneHref" class="btn btn-primary reveal mt-7 text-base" data-lead-cta="zones-call">
                    <Phone class="size-4" aria-hidden="true" />
                    {{ phone }}
                </a>
            </div>
        </section>

        <section class="section-y">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div v-for="group in grouped" :key="group.province" class="mb-12 last:mb-0">
                    <h2 class="eyebrow reveal text-elo-600">{{ group.province }}</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <Link
                            v-for="zone in group.list"
                            :key="zone.slug"
                            :href="'/lavage-de-vitres/' + zone.slug"
                            class="pane reveal group p-5 transition hover:-translate-y-1 hover:border-ciel-500 hover:shadow-pane"
                        >
                            <span class="relative flex items-center gap-2 text-xs tracking-wide text-graphite-400 uppercase">
                                <MapPin class="size-3.5 text-elo-600" aria-hidden="true" />
                                {{ zone.postal }}
                            </span>
                            <h3 class="relative mt-2 font-display text-[length:var(--step-h3)] font-bold text-nuit-800">
                                Lavage de vitres à {{ zone.city }}
                            </h3>
                            <p class="relative mt-2 line-clamp-3 text-sm leading-relaxed text-graphite-500">
                                {{ zone.intro }}
                            </p>
                            <span class="relative mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-elo-600">
                                Voir la page
                                <ArrowRight class="size-3.5 transition-transform group-hover:translate-x-0.5" aria-hidden="true" />
                            </span>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </SiteLayout>
</template>
