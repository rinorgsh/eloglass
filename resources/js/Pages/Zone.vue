<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Phone, ChevronRight } from 'lucide-vue-next';
import ServiceIcon from '../components/ServiceIcon.vue';
import SiteLayout from '../Layouts/SiteLayout.vue';
import LeadForm from '../components/LeadForm.vue';
import FaqList from '../components/FaqList.vue';
import Sparkle from '../components/Sparkle.vue';
import { useReveal } from '../composables/useReveal';

const props = defineProps({
    seo: { type: Object, required: true },
    zone: { type: Object, required: true },
    services: { type: Array, required: true },
    families: { type: Object, required: true },
    faq: { type: Array, required: true },
    zones: { type: Array, required: true },
});

useReveal();

const page = usePage();
const company = computed(() => page.props.company);
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);

const servicesByFamily = computed(() =>
    props.services.reduce((groups, service) => {
        (groups[service.family] ??= []).push(service);

        return groups;
    }, {}),
);

// Autres communes de la même zone : maillage interne, limité pour rester lisible.
const nearby = computed(() => props.zones.slice(0, 8));
</script>

<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta head-key="description" name="description" :content="seo.description" />
    </Head>

    <SiteLayout>
        <section class="border-b border-filet pt-28 pb-14 sm:pt-32 lg:pt-40 lg:pb-24">
            <div class="wrap">
                <!-- Fil d'Ariane, identique au balisage BreadcrumbList -->
                <nav aria-label="Fil d'Ariane" class="entree mb-8 flex flex-wrap items-center gap-1.5 text-sm text-encre-600">
                    <Link href="/" class="transition-colors hover:text-marine-900">Accueil</Link>
                    <ChevronRight class="size-3.5" aria-hidden="true" />
                    <Link href="/nettoyage" class="transition-colors hover:text-marine-900">Communes</Link>
                    <ChevronRight class="size-3.5" aria-hidden="true" />
                    <span class="text-marine-900">{{ zone.city }}</span>
                </nav>

                <div class="grid gap-12 lg:grid-cols-12 lg:gap-10">
                    <div class="lg:col-span-7">
                        <h1 class="text-[length:var(--step-h1)] leading-[0.98]">
                            <span class="ligne" style="--d: 100ms"><span>Nettoyage à {{ zone.city }}</span></span>
                            <span class="ligne" style="--d: 220ms">
                                <span class="text-[0.5em] leading-tight text-sauge-700">maisons, bureaux et vitres</span>
                            </span>
                        </h1>

                        <p class="lead entree mt-7 max-w-xl" style="--d: 500ms">{{ zone.intro }}</p>
                        <p v-if="zone.focus" class="entree mt-3 max-w-xl leading-relaxed text-encre-600" style="--d: 580ms">
                            {{ zone.focus }}
                        </p>

                        <div class="entree mt-8 flex flex-col gap-3 sm:flex-row" style="--d: 700ms">
                            <a :href="phoneHref" class="btn btn-primary text-base" data-lead-cta="zone-hero-call">
                                <Phone class="size-4" aria-hidden="true" />
                                {{ phone }}
                            </a>
                            <a href="#devis" class="btn btn-ghost text-base lg:hidden" data-lead-cta="zone-hero-quote">
                                Demander un devis
                            </a>
                        </div>

                        <ul class="entree mt-10 flex flex-wrap gap-x-7 gap-y-3" style="--d: 820ms">
                            <li
                                v-for="item in ['Devis sous ' + company.responseTime, 'Déplacement compris', 'La même personne à chaque passage']"
                                :key="item"
                                class="flex items-center gap-3 text-[0.95rem] text-encre-900"
                            >
                                <Sparkle class="size-3 shrink-0 text-sauge-600" />
                                {{ item }}
                            </li>
                        </ul>
                    </div>

                    <div id="devis" class="entree lg:col-span-5" style="--d: 500ms">
                        <div class="carte p-6 shadow-carte sm:p-7">
                            <h2 class="text-3xl">Votre prix pour {{ zone.city }}</h2>
                            <p class="mt-1.5 mb-6 text-[0.95rem] text-encre-600">Réponse sous {{ company.responseTime }}, sans engagement.</p>
                            <LeadForm :services="services" :families="families" :default-city="zone.city" id-prefix="zone" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quartiers desservis -->
        <section class="border-b border-filet bg-lin py-12">
            <div class="wrap flex flex-col gap-5 lg:flex-row lg:items-center lg:gap-12">
                <h2 class="reveal shrink-0 text-[length:var(--step-h3)]">Nos passages à {{ zone.city }}</h2>
                <ul class="reveal flex flex-wrap gap-2" style="--d: 80ms">
                    <li
                        v-for="area in zone.areas"
                        :key="area"
                        class="inline-flex min-h-9 items-center rounded-full border border-filet bg-white px-4 text-[0.95rem] text-marine-900"
                    >
                        {{ area }}
                    </li>
                </ul>
            </div>
        </section>

        <!-- Prestations -->
        <section class="section-y">
            <div class="wrap">
                <h2 class="reveal max-w-3xl text-[length:var(--step-h2)]">Ce que nous nettoyons à {{ zone.city }}</h2>

                <div class="mt-12 grid gap-12 lg:grid-cols-3 lg:gap-10">
                    <div v-for="(family, key, index) in families" :key="key" class="reveal" :style="{ '--d': index * 90 + 'ms' }">
                        <h3 class="text-[length:var(--step-h3)]">{{ family.label }}</h3>
                        <ul class="mt-5 border-b border-filet">
                            <li
                                v-for="service in servicesByFamily[key]"
                                :key="service.slug"
                                class="flex items-start gap-4 border-t border-filet py-4"
                            >
                                <ServiceIcon :name="service.icon" class="mt-0.5 size-5 shrink-0 text-sauge-600" stroke-width="1.5" aria-hidden="true" />
                                <span>
                                    <span class="block font-medium text-marine-900">{{ service.title }}</span>
                                    <span class="mt-0.5 block text-[0.95rem] text-encre-600">{{ service.short }}</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ locale -->
        <section class="section-y border-t border-filet bg-lin">
            <div class="wrap">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
                    <div class="lg:col-span-4">
                        <h2 class="reveal text-[length:var(--step-h2)] lg:sticky lg:top-32">
                            Le nettoyage à {{ zone.city }}, en pratique
                        </h2>
                    </div>
                    <div class="reveal lg:col-span-8">
                        <FaqList :items="faq" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Autres communes -->
        <section class="py-16">
            <div class="wrap">
                <h2 class="reveal text-[length:var(--step-h3)]">Nous intervenons aussi dans ces communes</h2>
                <ul class="reveal mt-6 flex flex-wrap gap-2.5" style="--d: 80ms">
                    <li v-for="other in nearby" :key="other.slug">
                        <Link
                            :href="'/nettoyage/' + other.slug"
                            class="inline-flex min-h-11 items-center rounded-full border border-filet bg-white px-4 text-[0.95rem] text-marine-900 transition-colors duration-200 hover:border-marine-900 hover:bg-marine-900 hover:text-white"
                        >
                            Nettoyage à {{ other.city }}
                        </Link>
                    </li>
                </ul>
            </div>
        </section>
    </SiteLayout>
</template>
