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
const phone2 = computed(() => page.props.contactPhone2);
const email = computed(() => page.props.contactEmail);
</script>

<template>
    <!-- Le « noindex » est posé côté serveur (app.blade.php), pas ici. -->
    <Head>
        <title>{{ seo.title }}</title>
        <meta head-key="description" name="description" :content="seo.description" />
    </Head>

    <SiteLayout>
        <section class="mx-auto max-w-3xl px-5 pt-28 pb-20 sm:px-8 lg:pt-40">
            <nav aria-label="Fil d'Ariane" class="mb-8 flex items-center gap-1.5 text-sm text-encre-600">
                <Link href="/" class="transition-colors hover:text-marine-900">Accueil</Link>
                <ChevronRight class="size-3.5" aria-hidden="true" />
                <span class="text-marine-900">Mentions légales</span>
            </nav>

            <h1 class="text-[length:var(--step-h2)]">Mentions légales</h1>

            <div class="mt-10 space-y-10 leading-relaxed text-encre-900">
                <div>
                    <h2 class="text-[length:var(--step-h3)]">Éditeur du site</h2>
                    <p class="mt-3">
                        {{ company.legalName }}<br />
                        {{ company.address.street }}<br />
                        {{ company.address.postal_code }} {{ company.address.city }}, {{ company.address.country }}
                    </p>
                    <p class="mt-3">
                        Numéro d’entreprise (BCE)&nbsp;: {{ company.bce }}<br />
                        Numéro de TVA&nbsp;: {{ company.vat }}
                    </p>
                    <p class="mt-3">
                        Téléphone&nbsp;:
                        <a :href="'tel:' + page.props.contactPhoneE164" class="lien font-medium text-marine-900">{{ phone }}</a>
                        ou
                        <a :href="'tel:' + page.props.contactPhone2E164" class="lien font-medium text-marine-900">{{ phone2 }}</a><br />
                        E-mail&nbsp;: <a :href="'mailto:' + email" class="lien font-medium text-marine-900">{{ email }}</a>
                    </p>
                </div>

                <div>
                    <h2 class="text-[length:var(--step-h3)]">Activité</h2>
                    <p class="mt-3">
                        Nettoyage pour particuliers et entreprises&nbsp;: ménage régulier et grand nettoyage, entretien
                        de bureaux, de commerces et de parties communes, lavage de vitres, nettoyage après chantier,
                        remise en état de fin de bail, entretien des sols et des moquettes.
                    </p>
                </div>

                <div>
                    <h2 class="text-[length:var(--step-h3)]">Données personnelles</h2>
                    <p class="mt-3">
                        Les informations transmises via les formulaires du site (nom, téléphone, e-mail, commune et
                        description de la demande) servent uniquement à établir un devis et à vous recontacter. Elles ne
                        sont ni vendues ni transmises à des tiers à des fins commerciales. L’adresse IP de l’envoi est
                        enregistrée avec la demande, pour lutter contre les envois abusifs.
                    </p>
                    <p class="mt-3">
                        Conformément au RGPD, vous pouvez demander l’accès, la rectification ou la suppression de vos
                        données en écrivant à
                        <a :href="'mailto:' + email" class="lien font-medium text-marine-900">{{ email }}</a>.
                    </p>
                </div>

                <div>
                    <h2 class="text-[length:var(--step-h3)]">Propriété intellectuelle</h2>
                    <p class="mt-3">
                        Le logo, les textes et les visuels de ce site appartiennent à {{ company.legalName }}. Toute
                        reproduction sans autorisation écrite préalable est interdite.
                    </p>
                </div>

                <div>
                    <h2 class="text-[length:var(--step-h3)]">Responsabilité</h2>
                    <p class="mt-3">
                        Les informations publiées sur ce site sont fournies à titre indicatif. Seul le devis écrit remis
                        au client fait foi quant au prix et à l’étendue des prestations.
                    </p>
                </div>
            </div>
        </section>
    </SiteLayout>
</template>
