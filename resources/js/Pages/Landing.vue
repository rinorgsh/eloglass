<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Phone, Check, ArrowRight, MapPin, Mail, Clock, Droplets, Ruler, ShieldCheck, Building2 } from 'lucide-vue-next';
import ServiceIcon from '../components/ServiceIcon.vue';
import SiteLayout from '../Layouts/SiteLayout.vue';
import LeadForm from '../components/LeadForm.vue';
import FaqList from '../components/FaqList.vue';
import GlassReveal from '../components/GlassReveal.vue';
import { useReveal } from '../composables/useReveal';

const props = defineProps({
    seo: { type: Object, required: true },
    services: { type: Array, required: true },
    families: { type: Object, required: true },
    zones: { type: Array, required: true },
    faq: { type: Array, required: true },
});

// Les prestations arrivent à plat ; on les regroupe par famille pour l'affichage.
const servicesByFamily = computed(() =>
    props.services.reduce((groups, service) => {
        (groups[service.family] ??= []).push(service);

        return groups;
    }, {}),
);

useReveal();

const page = usePage();
const company = computed(() => page.props.company);
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);
const email = computed(() => page.props.contactEmail);

/*
| Le déroulé est daté plutôt que numéroté : ce qui intéresse le visiteur,
| c'est le délai, pas la position dans une liste.
*/
const timeline = [
    {
        when: 'Aujourd’hui',
        title: 'Vous décrivez le besoin',
        text: 'Vitres à laver, bureaux à entretenir : par téléphone, par WhatsApp ou via le formulaire. Quelques photos suffisent la plupart du temps.',
    },
    {
        when: 'Sous 24 h',
        title: 'Vous recevez un prix ferme',
        text: 'Un montant clair, sans engagement. Pas de supplément découvert le jour même.',
    },
    {
        when: 'Le jour convenu',
        title: 'On nettoie',
        text: 'Vitres, châssis et appuis ; sols, sanitaires et plateaux. Pour l’extérieur, votre présence n’est pas nécessaire.',
    },
    {
        when: 'Ensuite',
        title: 'Vous vérifiez',
        text: 'Une trace oubliée, un coin manqué ? On repasse. C’est compris dans le prix.',
    },
];

const method = [
    {
        icon: Droplets,
        title: 'Eau osmosée',
        text: 'Une eau débarrassée du calcaire, qui sèche seule sans laisser de trace. Aucun produit chimique sur vos vitrages ni dans vos massifs.',
    },
    {
        icon: Ruler,
        title: 'Perche télescopique',
        text: 'Les vitres jusqu’à trois étages se nettoient depuis le sol. Pas d’échafaudage, pas de nacelle, pas de facture qui double.',
    },
    {
        icon: ShieldCheck,
        title: 'Châssis compris',
        text: 'Les châssis, les encadrements et les appuis sont nettoyés avec la vitre. Un carreau parfait dans un cadre noir ne sert à rien.',
    },
];

const trust = [
    'Société belge — TVA ' + company.value.vat,
    'Assurance RC professionnelle',
    'Devis gratuit sous ' + company.value.responseTime,
    'Particuliers et professionnels',
];
</script>

<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta name="description" :content="seo.description" />
    </Head>

    <SiteLayout>
        <!-- ══════════════════ HERO ══════════════════ -->
        <section class="relative overflow-hidden pt-24 pb-14 sm:pt-28 lg:pt-36 lg:pb-24">
            <!-- Meneaux : les montants d'une grande baie vitrée -->
            <div class="muntins pointer-events-none absolute inset-0 -z-10" aria-hidden="true" />
            <div
                class="pointer-events-none absolute inset-x-0 -top-24 -z-10 h-[32rem] bg-linear-[168deg,var(--color-ciel-100)_0%,var(--color-verre-50)_45%,#ffffff_100%]"
                aria-hidden="true"
            />

            <div class="mx-auto grid max-w-6xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:items-center lg:gap-12 lg:px-8">
                <div class="lg:col-span-6 xl:col-span-7">
                    <p class="eyebrow reveal text-elo-600">
                        Bruxelles · Périphérie · Depuis Lasne
                    </p>

                    <h1 class="reveal mt-4 font-display text-[length:var(--step-h1)] leading-[1.04] font-extrabold text-nuit-800">
                        Lavage de vitres <span class="text-shine">sans trace</span> et nettoyage de&nbsp;bureaux
                    </h1>

                    <p class="reveal mt-5 max-w-xl text-[length:var(--step-lead)] leading-relaxed text-graphite-500">
                        À Bruxelles et en périphérie, pour les particuliers comme pour les entreprises.
                        Décrivez-nous ce qu'il y a à faire&nbsp;: vous avez votre prix sous
                        {{ company.responseTime }}, sans engagement.
                    </p>

                    <div class="reveal mt-7 flex flex-col gap-3 sm:flex-row">
                        <a :href="phoneHref" class="btn btn-primary text-base" data-lead-cta="hero-call">
                            <Phone class="size-4" aria-hidden="true" />
                            {{ phone }}
                        </a>
                        <a href="#devis" class="btn btn-ghost text-base" data-lead-cta="hero-quote">
                            Recevoir mon prix
                            <ArrowRight class="size-4 text-elo-600" aria-hidden="true" />
                        </a>
                    </div>

                    <ul class="reveal mt-8 grid gap-2.5 sm:grid-cols-2">
                        <li v-for="item in trust" :key="item" class="flex items-start gap-2.5 text-sm text-graphite-700">
                            <span class="mt-0.5 grid size-[18px] shrink-0 place-items-center rounded-full bg-ciel-100 text-elo-600">
                                <Check class="size-3" aria-hidden="true" />
                            </span>
                            {{ item }}
                        </li>
                    </ul>
                </div>

                <!-- Formulaire visible d'emblée sur grand écran -->
                <div class="reveal hidden lg:col-span-6 lg:block xl:col-span-5">
                    <div class="pane pane-tint p-6 shadow-lift">
                        <p class="font-display text-lg font-bold text-nuit-800">Votre prix, sous {{ company.responseTime }}</p>
                        <p class="mt-1 mb-5 text-sm text-graphite-500">Deux champs suffisent pour démarrer.</p>
                        <LeadForm :services="services" id-prefix="hero" />
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ PRESTATIONS ══════════════════ -->
        <section id="prestations" class="section-y border-t border-filet bg-verre-50">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="eyebrow reveal text-elo-600">Prestations</p>
                    <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                        Lavage de vitres et nettoyage de bureaux
                    </h2>
                    <p class="reveal mt-4 text-[length:var(--step-lead)] leading-relaxed text-graphite-500">
                        Deux métiers, une seule équipe et un seul interlocuteur. La plupart de nos clients
                        professionnels nous confient les deux&nbsp;: leurs vitres et l'entretien de leurs locaux.
                    </p>
                </div>

                <div v-for="(family, key) in families" :key="key" class="mt-12 first:mt-10">
                    <div class="flex flex-wrap items-baseline gap-x-4 gap-y-1">
                        <h3 class="reveal font-display text-xl font-extrabold text-nuit-800 sm:text-2xl">
                            {{ family.label }}
                        </h3>
                        <p class="reveal text-[0.95rem] text-graphite-500">{{ family.lead }}</p>
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <article
                            v-for="(service, i) in servicesByFamily[key]"
                            :key="service.slug"
                            class="pane reveal group p-6 transition duration-200 hover:-translate-y-1 hover:border-ciel-500 hover:shadow-pane"
                            :style="{ transitionDelay: Math.min(i * 60, 240) + 'ms' }"
                        >
                            <span
                                class="relative grid size-11 place-items-center rounded-[7px] text-white"
                                :style="key === 'bureaux'
                                    ? 'background: linear-gradient(135deg, #0b275e 0%, #08447f 55%, #33373d 100%)'
                                    : 'background: linear-gradient(135deg, #57a1d0 0%, #0a529c 55%, #0b275e 100%)'"
                            >
                                <ServiceIcon :name="service.icon" class="size-5" aria-hidden="true" />
                            </span>
                            <h4 class="relative mt-4 font-display text-[length:var(--step-h3)] font-bold text-nuit-800">
                                {{ service.title }}
                            </h4>
                            <p class="relative mt-2 text-[0.95rem] leading-relaxed text-graphite-500">{{ service.text }}</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ MÉTHODE + CARREAU INTERACTIF ══════════════════ -->
        <section id="methode" class="section-y border-t border-filet">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-10 lg:grid-cols-12 lg:gap-14">
                    <div class="reveal lg:col-span-6">
                        <GlassReveal />
                    </div>

                    <div class="lg:col-span-6">
                        <p class="eyebrow reveal text-elo-600">Méthode</p>
                        <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                            Ce qui fait la différence entre propre et impeccable
                        </h2>
                        <p class="reveal mt-4 leading-relaxed text-graphite-500">
                            Sur le vitrage, tout se joue sur la méthode et le matériel.
                        </p>

                        <div class="mt-8 space-y-6">
                            <div v-for="item in method" :key="item.title" class="reveal flex gap-4">
                                <span class="grid size-10 shrink-0 place-items-center rounded-[7px] border border-filet bg-verre-50 text-elo-600">
                                    <component :is="item.icon" class="size-5" aria-hidden="true" />
                                </span>
                                <div>
                                    <h3 class="font-display text-[length:var(--step-h3)] font-bold text-nuit-800">{{ item.title }}</h3>
                                    <p class="mt-1.5 leading-relaxed text-graphite-500">{{ item.text }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ DÉROULÉ ══════════════════ -->
        <section class="section-y bg-nuit-900 text-white">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="eyebrow reveal text-ciel-500">Déroulé</p>
                    <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold">
                        De votre message aux vitres propres
                    </h2>
                </div>

                <ol class="mt-10 grid gap-px overflow-hidden rounded-pane border border-white/10 bg-white/10 sm:grid-cols-2 lg:grid-cols-4">
                    <li
                        v-for="step in timeline"
                        :key="step.title"
                        class="reveal bg-nuit-900 p-6"
                    >
                        <p class="eyebrow text-ciel-500">{{ step.when }}</p>
                        <h3 class="mt-3 font-display text-[length:var(--step-h3)] font-bold">{{ step.title }}</h3>
                        <p class="mt-2 text-[0.95rem] leading-relaxed text-ciel-100/70">{{ step.text }}</p>
                    </li>
                </ol>
            </div>
        </section>

        <!-- ══════════════════ ZONES ══════════════════ -->
        <section id="zones" class="section-y border-t border-filet bg-verre-50">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <p class="eyebrow reveal text-elo-600">Zones d’intervention</p>
                    <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                        Où nous intervenons
                    </h2>
                    <p class="reveal mt-4 text-[length:var(--step-lead)] leading-relaxed text-graphite-500">
                        Les 19 communes de la Région de Bruxelles-Capitale et toute la périphérie, de
                        Rhode-Saint-Genèse à Grimbergen. Le déplacement est compris dans le prix.
                    </p>
                </div>

                <ul class="reveal mt-8 flex flex-wrap gap-2.5">
                    <li v-for="zone in zones" :key="zone.slug">
                        <Link
                            :href="'/lavage-de-vitres/' + zone.slug"
                            class="pane inline-flex min-h-11 items-center gap-2 px-4 text-sm font-medium text-nuit-800 transition hover:border-ciel-500 hover:bg-white"
                        >
                            <MapPin class="size-3.5 text-elo-600" aria-hidden="true" />
                            {{ zone.city }}
                            <span class="text-graphite-400">{{ zone.postal }}</span>
                        </Link>
                    </li>
                </ul>

                <Link
                    href="/lavage-de-vitres"
                    class="reveal mt-6 inline-flex items-center gap-1.5 text-sm font-semibold text-elo-600 hover:underline"
                >
                    Voir toutes les zones d’intervention
                    <ArrowRight class="size-3.5" aria-hidden="true" />
                </Link>
            </div>
        </section>

        <!-- ══════════════════ DEVIS ══════════════════ -->
        <section id="devis" class="section-y border-t border-filet">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">
                    <div class="lg:col-span-5">
                        <p class="eyebrow reveal text-elo-600">Devis</p>
                        <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                            Demandez votre prix
                        </h2>
                        <p class="reveal mt-4 text-[length:var(--step-lead)] leading-relaxed text-graphite-500">
                            Dites-nous ce qu’il y a à nettoyer. Vous recevez un montant ferme sous
                            {{ company.responseTime }}, sans visite préalable dans la plupart des cas.
                        </p>

                        <div class="reveal mt-8 space-y-3">
                            <a :href="phoneHref" class="pane flex min-h-16 items-center gap-4 px-4 transition hover:border-ciel-500" data-lead-cta="devis-call">
                                <span class="grid size-10 shrink-0 place-items-center rounded-[7px] bg-ciel-100 text-elo-600">
                                    <Phone class="size-5" aria-hidden="true" />
                                </span>
                                <span class="relative">
                                    <span class="block text-xs tracking-wide text-graphite-400 uppercase">Le plus rapide</span>
                                    <span class="block font-display font-bold text-nuit-800">{{ phone }}</span>
                                </span>
                            </a>
                            <a :href="'mailto:' + email" class="pane flex min-h-16 items-center gap-4 px-4 transition hover:border-ciel-500">
                                <span class="grid size-10 shrink-0 place-items-center rounded-[7px] bg-ciel-100 text-elo-600">
                                    <Mail class="size-5" aria-hidden="true" />
                                </span>
                                <span class="relative">
                                    <span class="block text-xs tracking-wide text-graphite-400 uppercase">E-mail</span>
                                    <span class="block font-semibold text-nuit-800">{{ email }}</span>
                                </span>
                            </a>
                            <div class="pane flex min-h-16 items-center gap-4 px-4">
                                <span class="grid size-10 shrink-0 place-items-center rounded-[7px] bg-ciel-100 text-elo-600">
                                    <Clock class="size-5" aria-hidden="true" />
                                </span>
                                <span class="relative text-sm">
                                    <span class="block text-xs tracking-wide text-graphite-400 uppercase">Horaires</span>
                                    <span v-for="slot in company.hours" :key="slot.label" class="block font-medium text-nuit-800">
                                        {{ slot.label }} · {{ slot.opens }}–{{ slot.closes }}
                                    </span>
                                </span>
                            </div>
                            <div class="pane flex min-h-16 items-center gap-4 px-4">
                                <span class="grid size-10 shrink-0 place-items-center rounded-[7px] bg-ciel-100 text-elo-600">
                                    <Building2 class="size-5" aria-hidden="true" />
                                </span>
                                <span class="relative text-sm">
                                    <span class="block text-xs tracking-wide text-graphite-400 uppercase">Siège</span>
                                    <span class="block font-medium text-nuit-800">
                                        {{ company.address.street }}, {{ company.address.postal_code }} {{ company.address.city }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="reveal lg:col-span-7">
                        <div class="pane pane-tint p-6 shadow-pane sm:p-8">
                            <LeadForm :services="services" id-prefix="devis" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ QUESTIONS ══════════════════ -->
        <section id="questions" class="section-y border-t border-filet bg-verre-50">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">
                    <div class="lg:col-span-4">
                        <p class="eyebrow reveal text-elo-600">Questions</p>
                        <h2 class="reveal mt-3 font-display text-[length:var(--step-h2)] leading-tight font-extrabold text-nuit-800">
                            Ce qu’on nous demande le plus
                        </h2>
                        <p class="reveal mt-4 leading-relaxed text-graphite-500">
                            Une question qui n’est pas là&nbsp;? Appelez-nous, on répond directement.
                        </p>
                        <a :href="phoneHref" class="btn btn-ghost reveal mt-5" data-lead-cta="faq-call">
                            <Phone class="size-4 text-elo-600" aria-hidden="true" />
                            {{ phone }}
                        </a>
                    </div>

                    <div class="reveal lg:col-span-8">
                        <FaqList :items="faq" />
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ APPEL FINAL ══════════════════ -->
        <section class="border-t border-filet bg-white py-14">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="pane reveal flex flex-col items-start gap-6 overflow-hidden p-7 sm:p-10 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="relative font-display text-2xl leading-tight font-extrabold text-nuit-800 sm:text-3xl">
                            Vos vitres et vos locaux méritent mieux qu’un chiffon
                        </h2>
                        <p class="relative mt-2 text-graphite-500">
                            Un appel, quelques photos, un prix. C’est tout ce que ça demande.
                        </p>
                    </div>
                    <div class="relative flex w-full shrink-0 flex-col gap-3 sm:flex-row md:w-auto">
                        <a :href="phoneHref" class="btn btn-primary text-base" data-lead-cta="final-call">
                            <Phone class="size-4" aria-hidden="true" />
                            {{ phone }}
                        </a>
                        <a href="#devis" class="btn btn-ghost text-base" data-lead-cta="final-quote">Devis gratuit</a>
                    </div>
                </div>
            </div>
        </section>
    </SiteLayout>
</template>
