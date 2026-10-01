<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Phone, ChevronRight } from 'lucide-vue-next';
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

// Regroupement Bruxelles / périphérie : c'est ainsi que les clients situent leur commune.
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
        <meta head-key="description" name="description" :content="seo.description" />
    </Head>

    <SiteLayout>
        <section class="border-b border-filet pt-28 pb-14 sm:pt-32 lg:pt-40 lg:pb-20">
            <div class="wrap">
                <nav aria-label="Fil d'Ariane" class="entree mb-8 flex items-center gap-1.5 text-sm text-encre-600">
                    <Link href="/" class="transition-colors hover:text-marine-900">Accueil</Link>
                    <ChevronRight class="size-3.5" aria-hidden="true" />
                    <span class="text-marine-900">Communes desservies</span>
                </nav>

                <h1 class="max-w-4xl text-[length:var(--step-h1)] leading-[0.98]">
                    <span class="ligne" style="--d: 100ms"><span>Nettoyage à Bruxelles</span></span>
                    <span class="ligne" style="--d: 220ms"><span class="text-sauge-700">et en périphérie</span></span>
                </h1>
                <p class="lead entree mt-7 max-w-2xl" style="--d: 500ms">
                    Les 19 communes bruxelloises et la périphérie proche. Choisissez la vôtre pour voir comment
                    nous y travaillons, ou appelez-nous.
                </p>
                <a :href="phoneHref" class="btn btn-primary entree mt-8 text-base" style="--d: 650ms" data-lead-cta="zones-call">
                    <Phone class="size-4" aria-hidden="true" />
                    {{ phone }}
                </a>
            </div>
        </section>

        <section class="section-y">
            <div class="wrap">
                <div v-for="group in grouped" :key="group.province" class="mb-20 last:mb-0">
                    <h2 class="reveal text-[length:var(--step-h2)]">{{ group.province }}</h2>
                    <ul class="mt-8 grid border-t border-filet sm:grid-cols-2 sm:gap-x-12 lg:grid-cols-3">
                        <li v-for="zone in group.list" :key="zone.slug" class="border-b border-filet">
                            <Link :href="'/nettoyage/' + zone.slug" class="commune group block py-6">
                                <span class="flex items-baseline justify-between gap-4">
                                    <h3 class="font-display text-[length:var(--step-h3)] leading-tight font-medium text-marine-900 transition-colors group-hover:text-sauge-700">
                                        {{ zone.city }}
                                    </h3>
                                    <span class="text-sm text-encre-400">{{ zone.postal }}</span>
                                </span>
                                <span class="mt-2 line-clamp-3 block text-[0.95rem] leading-relaxed text-encre-600">
                                    {{ zone.intro }}
                                </span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </SiteLayout>
</template>
