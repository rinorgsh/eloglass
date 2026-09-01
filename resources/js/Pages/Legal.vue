<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';
import SiteLayout from '../Layouts/SiteLayout.vue';

defineProps({
    seo: { type: Object, required: true },
});

const page = usePage();
const company = computed(() => page.props.company);
const phone = computed(() => page.props.contactPhone);
const email = computed(() => page.props.contactEmail);
</script>

<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
        <meta name="robots" content="noindex, follow" />
    </Head>

    <SiteLayout>
        <section class="mx-auto max-w-3xl px-4 pt-28 pb-16 sm:px-6 lg:px-8 lg:pt-32">
            <nav aria-label="Fil d'Ariane" class="mb-6 flex items-center gap-1.5 text-sm text-graphite-400">
                <Link href="/" class="transition hover:text-elo-600">Accueil</Link>
                <ChevronRight class="size-3.5" aria-hidden="true" />
                <span class="text-graphite-700">Mentions légales</span>
            </nav>

            <h1 class="font-display text-[length:var(--step-h2)] font-extrabold text-nuit-800">Mentions légales</h1>

            <div class="mt-8 space-y-8 leading-relaxed text-graphite-700">
                <div>
                    <h2 class="font-display text-lg font-bold text-nuit-800">Éditeur du site</h2>
                    <p class="mt-2">
                        {{ company.legalName }}<br />
                        {{ company.address.street }}<br />
                        {{ company.address.postal_code }} {{ company.address.city }}, {{ company.address.country }}
                    </p>
                    <p class="mt-3">
                        Numéro d’entreprise (BCE) : {{ company.bce }}<br />
                        Numéro de TVA : {{ company.vat }}<br />
                        Forme juridique : société à responsabilité limitée
                    </p>
                    <p class="mt-3">
                        Téléphone : <a :href="'tel:' + page.props.contactPhoneE164" class="font-medium text-elo-600 hover:underline">{{ phone }}</a><br />
                        E-mail : <a :href="'mailto:' + email" class="font-medium text-elo-600 hover:underline">{{ email }}</a>
                    </p>
                </div>

                <div>
                    <h2 class="font-display text-lg font-bold text-nuit-800">Activité</h2>
                    <p class="mt-2">
                        Nettoyage de surfaces vitrées pour les particuliers et les professionnels : vitres d’habitation,
                        vitrines commerciales, bureaux et immeubles, vérandas et verrières, panneaux photovoltaïques,
                        nettoyage après chantier.
                    </p>
                </div>

                <div>
                    <h2 class="font-display text-lg font-bold text-nuit-800">Données personnelles</h2>
                    <p class="mt-2">
                        Les informations transmises via les formulaires du site (nom, téléphone, e-mail, localité et
                        description de la demande) servent uniquement à établir un devis et à vous recontacter. Elles ne
                        sont ni vendues ni transmises à des tiers à des fins commerciales.
                    </p>
                    <p class="mt-3">
                        Conformément au RGPD, vous pouvez demander l’accès, la rectification ou la suppression de vos
                        données en écrivant à
                        <a :href="'mailto:' + email" class="font-medium text-elo-600 hover:underline">{{ email }}</a>.
                    </p>
                </div>

                <div>
                    <h2 class="font-display text-lg font-bold text-nuit-800">Propriété intellectuelle</h2>
                    <p class="mt-2">
                        Le logo, les textes et les visuels de ce site appartiennent à {{ company.legalName }}. Toute
                        reproduction sans autorisation écrite préalable est interdite.
                    </p>
                </div>

                <div>
                    <h2 class="font-display text-lg font-bold text-nuit-800">Responsabilité</h2>
                    <p class="mt-2">
                        Les informations publiées sur ce site sont fournies à titre indicatif. Seul le devis écrit remis
                        au client fait foi quant au prix et à l’étendue des prestations.
                    </p>
                </div>
            </div>
        </section>
    </SiteLayout>
</template>
