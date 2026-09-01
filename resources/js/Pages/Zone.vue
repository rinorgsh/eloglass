<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Phone, ArrowRight, MapPin, Check, ChevronRight } from 'lucide-vue-next';
import ServiceIcon from '../components/ServiceIcon.vue';
import SiteLayout from '../Layouts/SiteLayout.vue';
import LeadForm from '../components/LeadForm.vue';
import FaqList from '../components/FaqList.vue';
import { useReveal } from '../composables/useReveal';

const props = defineProps({
    seo: { type: Object, required: true },
    zone: { type: Object, required: true },
    services: { type: Array, required: true },
    faq: { type: Array, required: true },
    zones: { type: Array, required: true },
});

useReveal();

const page = usePage();
const company = computed(() => page.props.company);
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);

// Communes voisines : maillage interne, limité pour rester lisible.
const nearby = computed(() => props.zones.slice(0, 8));
</script>

<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>

    <SiteLayout>
        <section class="relative overflow-hidden border-b border-filet pt-24 pb-14 sm:pt-28 lg:pt-32 lg:pb-20">
            <div class="muntins pointer-events-none absolute inset-0 -z-10" aria-hidden="true" />
            <div
                class="pointer-events-none absolute inset-x-0 -top-24 -z-10 h-[26rem] bg-linear-[168deg,var(--color-ciel-100)_0%,var(--color-verre-50)_50%,#ffffff_100%]"
                aria-hidden="true"
            />

            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Fil d'Ariane, identique au balisage BreadcrumbList -->
                <nav aria-label="Fil d'Ariane" class="mb-6 flex flex-wrap items-center gap-1.5 text-sm text-graphite-400">
                    <Link href="/" class="transition hover:text-elo-600">Accueil</Link>
                    <ChevronRight class="size-3.5" aria-hidden="true" />
                    <Link href="/lavage-de-vitres" class="transition hover:text-elo-600">Zones</Link>
                    <ChevronRight class="size-3.5" aria-hidden="true" />
                    <span class="text-graphite-700">{{ zone.city }}</span>
                </nav>

                <div class="grid gap-10 lg:grid-cols-12 lg:gap-12">
                    <div class="lg:col-span-6 xl:col-span-7">
                        <p class="eyebrow reveal text-elo-600">{{ zone.postal }} · {{ zone.province }}</p>

                        <h1 class="reveal mt-4 font-display text-[length:var(--step-h1)] leading-[1.05] font-extrabold text-nuit-800">
                            Lavage de vitres à <span class="text-shine">{{ zone.city }}</span>
                        </h1>

                        <p class="reveal mt-5 max-w-xl text-[length:var(--step-lead)] leading-relaxed text-graphite-500">
                            {{ zone.intro }}
                        </p>
                        <p v-if="zone.focus" class="reveal mt-3 max-w-xl leading-relaxed text-graphite-500">
                            {{ zone.focus }}
                        </p>

                        <div class="reveal mt-7 flex flex-col gap-3 sm:flex-row">
                            <a :href="phoneHref" class="btn btn-primary text-base" data-lead-cta="zone-hero-call">
                                <Phone class="size-4" aria-hidden="true" />
                                {{ phone }}
                            </a>
                            <a href="#devis" class="btn btn-ghost text-base" data-lead-cta="zone-hero-quote">
                                Devis gratuit
                                <ArrowRight class="size-4 text-elo-600" aria-hidden="true" />
                            </a>
                        </div>

                        <ul class="reveal mt-8 flex flex-wrap gap-x-5 gap-y-2.5">
                            <li
                                v-for="item in ['Devis sous ' + company.responseTime, 'Déplacement compris', 'Sans traces, garanti']"
                                :key="item"
                                class="flex items-center gap-2 text-sm text-graphite-700"
                            >
                                <span class="grid size-[18px] shrink-0 place-items-center rounded-full bg-ciel-100 text-elo-600">
                                    <Check class="size-3" aria-hidden="true" />
                                </span>
                                {{ item }}
                            </li>
                        </ul>
                    </div>

                    <div class="reveal lg:col-span-6 xl:col-span-5">
                        <div class="pane pane-tint p-6 shadow-lift">
                            <p class="font-display text-lg font-bold text-nuit-800">
                                Votre prix pour {{ zone.city }}
                            </p>
                            <p class="mt-1 mb-5 text-sm text-graphite-500">Réponse sous {{ company.responseTime }}, sans engagement.</p>
                            <LeadForm :services="services" :default-city="zone.city" id-prefix="zone-hero" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quartiers desservis -->
        <section class="section-y bg-verre-50">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">
                    <div class="lg:col-span-5">
                        <p class="eyebrow reveal text-elo-600">Sur place</p>
                        <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                            Nos passages à {{ zone.city }}
                        </h2>
                        <p class="reveal mt-4 leading-relaxed text-graphite-500">
                            Nous desservons l’ensemble de la commune, sans frais kilométriques&nbsp;:
                        </p>
                        <ul class="reveal mt-5 flex flex-wrap gap-2">
                            <li
                                v-for="area in zone.areas"
                                :key="area"
                                class="pane inline-flex min-h-9 items-center gap-1.5 px-3 text-sm text-nuit-800"
                            >
                                <MapPin class="size-3.5 text-elo-600" aria-hidden="true" />
                                {{ area }}
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-7">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <article
                                v-for="service in services"
                                :key="service.slug"
                                class="pane reveal p-5"
                            >
                                <span
                                    class="relative grid size-9 place-items-center rounded-[7px] text-white"
                                    style="background: linear-gradient(135deg, #57a1d0 0%, #0a529c 55%, #0b275e 100%)"
                                >
                                    <ServiceIcon :name="service.icon" class="size-4" aria-hidden="true" />
                                </span>
                                <h3 class="relative mt-3.5 font-display font-bold text-nuit-800">{{ service.title }}</h3>
                                <p class="relative mt-1.5 text-sm leading-relaxed text-graphite-500">{{ service.short }}</p>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Devis -->
        <section id="devis" class="section-y border-t border-filet">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="eyebrow reveal text-elo-600">Devis</p>
                    <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                        Combien pour vos vitres à {{ zone.city }}&nbsp;?
                    </h2>
                    <p class="reveal mx-auto mt-4 max-w-xl text-[length:var(--step-lead)] leading-relaxed text-graphite-500">
                        Décrivez-nous ce qu’il y a à nettoyer. Vous recevez un prix ferme sous
                        {{ company.responseTime }} — ou appelez directement le {{ phone }}.
                    </p>
                </div>

                <div class="pane pane-tint reveal mt-9 p-6 shadow-pane sm:p-8">
                    <LeadForm :services="services" :default-city="zone.city" id-prefix="zone-devis" />
                </div>
            </div>
        </section>

        <!-- FAQ locale -->
        <section class="section-y border-t border-filet bg-verre-50">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">
                    <div class="lg:col-span-4">
                        <p class="eyebrow reveal text-elo-600">Questions</p>
                        <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                            Lavage de vitres à {{ zone.city }}, en pratique
                        </h2>
                    </div>
                    <div class="reveal lg:col-span-8">
                        <FaqList :items="faq" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Communes voisines -->
        <section class="section-y border-t border-filet">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <h2 class="reveal font-display text-xl font-bold text-nuit-800">
                    Nous intervenons aussi dans les communes voisines
                </h2>
                <ul class="reveal mt-5 flex flex-wrap gap-2.5">
                    <li v-for="other in nearby" :key="other.slug">
                        <Link
                            :href="'/lavage-de-vitres/' + other.slug"
                            class="pane inline-flex min-h-11 items-center gap-2 px-4 text-sm font-medium text-nuit-800 transition hover:border-ciel-500"
                        >
                            <MapPin class="size-3.5 text-elo-600" aria-hidden="true" />
                            Lavage de vitres à {{ other.city }}
                        </Link>
                    </li>
                </ul>
            </div>
        </section>
    </SiteLayout>
</template>
