<script setup>
import { ref, computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Phone, Mail, Clock, MapPin, Search } from 'lucide-vue-next';
import SiteLayout from '../Layouts/SiteLayout.vue';
import LeadForm from '../components/LeadForm.vue';
import FaqList from '../components/FaqList.vue';
import GlassReveal from '../components/GlassReveal.vue';
import OrbitArt from '../components/OrbitArt.vue';
import ServiceTicker from '../components/ServiceTicker.vue';
import ServiceExplorer from '../components/ServiceExplorer.vue';
import ProcessTimeline from '../components/ProcessTimeline.vue';
import Sparkle from '../components/Sparkle.vue';
import { useReveal } from '../composables/useReveal';

const props = defineProps({
    seo: { type: Object, required: true },
    services: { type: Array, required: true },
    families: { type: Object, required: true },
    zones: { type: Array, required: true },
    faq: { type: Array, required: true },
});

useReveal();

const page = usePage();
const company = computed(() => page.props.company);
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);
const phone2 = computed(() => page.props.contactPhone2);
const phone2Href = computed(() => 'tel:' + page.props.contactPhone2E164);
const email = computed(() => page.props.contactEmail);

/*
| Le dessin du hero suit légèrement le pointeur : on expose sa position,
| de -1 à 1, dans deux variables CSS lues par OrbitArt.
*/
const hero = ref(null);

function onHeroMove(event) {
    if (event.pointerType !== 'mouse' || ! hero.value) {
        return;
    }

    const rect = hero.value.getBoundingClientRect();

    hero.value.style.setProperty('--px', (((event.clientX - rect.left) / rect.width) * 2 - 1).toFixed(3));
    hero.value.style.setProperty('--py', (((event.clientY - rect.top) / rect.height) * 2 - 1).toFixed(3));
}

// Prestation choisie dans l'explorateur : elle pré-remplit le formulaire de devis.
const chosenService = ref('');

function chooseService(title) {
    chosenService.value = title;
    document.getElementById('devis')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Recherche de commune, insensible aux accents et à la casse.
const zoneQuery = ref('');

const normalize = (text) => text.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();

const matchingZones = computed(() => {
    const query = normalize(zoneQuery.value.trim());

    if (! query) {
        return props.zones;
    }

    return props.zones.filter((zone) => normalize(zone.city).includes(query) || zone.postal.startsWith(query));
});

const trust = [
    'Société belge, TVA ' + company.value.vat,
    'Devis gratuit sous ' + company.value.responseTime,
    'Particuliers et entreprises',
    'La même personne à chaque passage',
];

const method = [
    {
        title: 'Une personne attitrée',
        text: 'Pour un ménage régulier ou un contrat de bureaux, la même personne revient. Elle connaît les lieux et les points auxquels vous tenez.',
    },
    {
        title: 'Le bon produit pour chaque surface',
        text: 'Bois, pierre, inox, verre : chaque matière a son produit et son geste. Rien d’agressif là où ce n’est pas nécessaire.',
    },
    {
        title: 'Les vitres à l’eau osmosée',
        text: 'Une eau déminéralisée qui sèche sans laisser de trace. Les châssis et les appuis sont nettoyés avec la vitre.',
    },
];

// Le déroulé est une vraie séquence dans le temps : d'où la frise.
const timeline = [
    {
        when: 'Aujourd’hui',
        title: 'Vous décrivez ce qu’il y a à faire',
        text: 'Par téléphone, par WhatsApp ou via le formulaire. Quelques photos suffisent la plupart du temps.',
    },
    {
        when: 'Sous 24 h',
        title: 'Vous recevez un prix ferme',
        text: 'Un montant clair, sans engagement, et pas de supplément le jour même.',
    },
    {
        when: 'Le jour convenu',
        title: 'Nous nettoyons',
        text: 'Avec notre matériel et nos produits. Votre présence n’est pas nécessaire si nous avons un accès.',
    },
    {
        when: 'Ensuite',
        title: 'Vous vérifiez',
        text: 'Un coin oublié ? Nous repassons, sans supplément.',
    },
];
</script>

<template>
    <Head>
        <title>{{ seo.title }}</title>
        <meta head-key="description" name="description" :content="seo.description" />
    </Head>

    <SiteLayout>
        <!-- ══════════════════ HERO ══════════════════ -->
        <section
            ref="hero"
            class="relative overflow-hidden pt-28 pb-16 sm:pt-32 lg:pt-40 lg:pb-28"
            @pointermove="onHeroMove"
        >
            <!-- Sur mobile, les ellipses débordent en haut à droite, derrière le titre. -->
            <OrbitArt class="top-16 -right-40 w-[30rem] opacity-60 lg:hidden" />

            <div class="wrap relative grid gap-12 lg:grid-cols-12 lg:items-center lg:gap-10">
                <div class="lg:col-span-7">
                    <h1 class="text-[length:var(--step-h1)] leading-[0.98]">
                        <span class="ligne" style="--d: 100ms"><span>Une maison nette,</span></span>
                        <span class="ligne" style="--d: 220ms"><span class="text-sauge-700">des bureaux soignés,</span></span>
                        <span class="ligne" style="--d: 340ms"><span>des vitres sans trace.</span></span>
                    </h1>

                    <p class="lead entree mt-7 max-w-xl" style="--d: 700ms">
                        Clean Company nettoie les maisons, les bureaux, les commerces et les vitres à Bruxelles
                        et en périphérie. Dites-nous ce qu’il y a à faire&nbsp;: vous recevez un prix ferme
                        sous {{ company.responseTime }}.
                    </p>

                    <div class="entree mt-8 flex flex-col gap-3 sm:flex-row" style="--d: 850ms">
                        <a :href="phoneHref" class="btn btn-primary text-base" data-lead-cta="hero-call">
                            <Phone class="size-4" aria-hidden="true" />
                            {{ phone }}
                        </a>
                        <a href="#devis" class="btn btn-ghost text-base" data-lead-cta="hero-quote">
                            Demander un devis
                        </a>
                    </div>

                    <ul class="entree mt-10 grid gap-3 sm:grid-cols-2" style="--d: 1000ms">
                        <li v-for="item in trust" :key="item" class="flex items-center gap-3 text-[0.95rem] text-encre-900">
                            <Sparkle class="size-3 shrink-0 text-sauge-600" />
                            {{ item }}
                        </li>
                    </ul>
                </div>

                <!-- Formulaire visible d'emblée sur grand écran, posé sur les ellipses du logo. -->
                <div class="relative hidden lg:col-span-5 lg:block">
                    <OrbitArt class="-inset-x-28 -top-24 -bottom-24" />
                    <div class="carte entree relative p-7 shadow-carte" style="--d: 600ms">
                        <h2 class="text-3xl">Votre prix sous {{ company.responseTime }}</h2>
                        <p class="mt-1.5 mb-6 text-[0.95rem] text-encre-600">Un nom et un numéro suffisent pour commencer.</p>
                        <LeadForm :services="services" :families="families" id-prefix="hero" />
                    </div>
                </div>
            </div>
        </section>

        <ServiceTicker :items="services.map((service) => service.title)" />

        <!-- ══════════════════ PRESTATIONS ══════════════════ -->
        <section id="prestations" class="section-y">
            <div class="wrap">
                <div class="max-w-3xl">
                    <h2 class="reveal text-[length:var(--step-h2)]">Tout ce que nous nettoyons</h2>
                    <p class="lead reveal mt-5" style="--d: 80ms">
                        Du ménage de la semaine au nettoyage après chantier. Choisissez une famille, ouvrez une
                        prestation, et demandez son prix.
                    </p>
                </div>

                <div class="mt-12 lg:mt-16">
                    <ServiceExplorer :families="families" :services="services" @choose="chooseService" />
                </div>
            </div>
        </section>

        <!-- ══════════════════ MÉTHODE + CARREAU INTERACTIF ══════════════════ -->
        <section id="methode" class="section-y border-y border-filet bg-lin">
            <div class="wrap">
                <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-16">
                    <div class="reveal lg:col-span-6">
                        <GlassReveal />
                    </div>

                    <div class="lg:col-span-6">
                        <h2 class="reveal text-[length:var(--step-h2)]">Ce qui sépare le propre de l’impeccable</h2>

                        <dl class="mt-9">
                            <div
                                v-for="(item, i) in method"
                                :key="item.title"
                                class="reveal border-t border-filet py-6 last:border-b"
                                :style="{ '--d': i * 90 + 'ms' }"
                            >
                                <dt class="font-display text-[length:var(--step-h3)] leading-tight font-medium text-marine-900">
                                    {{ item.title }}
                                </dt>
                                <dd class="mt-2 max-w-lg leading-relaxed text-encre-600">{{ item.text }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ DÉROULÉ ══════════════════ -->
        <section class="section-y bg-marine-900 text-white">
            <div class="wrap grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-5">
                    <div class="lg:sticky lg:top-32">
                        <h2 class="reveal text-[length:var(--step-h2)] text-white">De votre message au résultat</h2>
                        <p class="reveal mt-5 max-w-sm text-[length:var(--step-lead)] leading-relaxed text-white/70" style="--d: 80ms">
                            Quatre étapes, et vous savez à chaque moment ce qui vient ensuite.
                        </p>
                        <a href="#devis" class="btn btn-clair reveal mt-8" style="--d: 160ms" data-lead-cta="process-quote">
                            Demander un devis
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-7">
                    <ProcessTimeline :steps="timeline" />
                </div>
            </div>
        </section>

        <!-- ══════════════════ COMMUNES ══════════════════ -->
        <section id="communes" class="section-y">
            <div class="wrap">
                <div class="grid gap-8 lg:grid-cols-12 lg:items-end lg:gap-16">
                    <div class="lg:col-span-7">
                        <h2 class="reveal text-[length:var(--step-h2)]">Où nous intervenons</h2>
                        <p class="lead reveal mt-5 max-w-xl" style="--d: 80ms">
                            Les 19 communes de Bruxelles et la périphérie, de Londerzeel à Waterloo.
                            Le déplacement est compris dans le prix.
                        </p>
                    </div>
                    <div class="reveal lg:col-span-5" style="--d: 160ms">
                        <label for="recherche-commune" class="mb-1.5 block text-sm font-medium text-encre-900">
                            Chercher votre commune
                        </label>
                        <div class="relative">
                            <Search class="pointer-events-none absolute top-1/2 left-4 size-4 -translate-y-1/2 text-encre-400" stroke-width="1.5" aria-hidden="true" />
                            <input
                                id="recherche-commune"
                                v-model="zoneQuery"
                                type="search"
                                placeholder="Nom ou code postal"
                                autocomplete="off"
                                class="field rounded-full pl-11"
                            />
                        </div>
                    </div>
                </div>

                <TransitionGroup tag="ul" name="commune" class="relative mt-10 flex flex-wrap gap-2.5">
                    <li v-for="zone in matchingZones" :key="zone.slug">
                        <Link
                            :href="'/nettoyage/' + zone.slug"
                            class="inline-flex min-h-11 items-center gap-2 rounded-full border border-filet bg-white px-4 text-[0.95rem] text-marine-900 transition-colors duration-200 hover:border-marine-900 hover:bg-marine-900 hover:text-white"
                        >
                            {{ zone.city }}
                            <span class="text-sm opacity-60">{{ zone.postal }}</span>
                        </Link>
                    </li>
                </TransitionGroup>

                <p v-if="! matchingZones.length" class="mt-2 text-encre-600" role="status">
                    Cette commune n’est pas dans notre liste. Appelez le
                    <a :href="phoneHref" class="lien font-medium text-marine-900">{{ phone }}</a>&nbsp;:
                    nous nous déplaçons peut-être quand même.
                </p>

                <Link href="/nettoyage" class="lien mt-8 inline-block font-medium text-marine-900">
                    Voir le détail par commune
                </Link>
            </div>
        </section>

        <!-- ══════════════════ DEVIS ══════════════════ -->
        <section id="devis" class="section-y border-y border-filet bg-lin">
            <div class="wrap">
                <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                    <div class="lg:col-span-5">
                        <h2 class="reveal text-[length:var(--step-h2)]">Demandez votre prix</h2>
                        <p class="lead reveal mt-5" style="--d: 80ms">
                            Décrivez les lieux et ce que vous attendez. Vous recevez un montant ferme sous
                            {{ company.responseTime }}, le plus souvent sans visite.
                        </p>

                        <dl class="reveal mt-9 border-b border-filet" style="--d: 160ms">
                            <div class="flex items-start gap-4 border-t border-filet py-4">
                                <Phone class="mt-1 size-5 shrink-0 text-sauge-600" stroke-width="1.5" aria-hidden="true" />
                                <div>
                                    <dt class="text-sm text-encre-600">Téléphone</dt>
                                    <dd class="mt-0.5 font-display text-2xl text-marine-900">
                                        <a :href="phoneHref" class="lien" data-lead-cta="devis-call">{{ phone }}</a>
                                        <span class="px-2 text-encre-400" aria-hidden="true">/</span>
                                        <a :href="phone2Href" class="lien" data-lead-cta="devis-call-2">{{ phone2 }}</a>
                                    </dd>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 border-t border-filet py-4">
                                <Mail class="mt-1 size-5 shrink-0 text-sauge-600" stroke-width="1.5" aria-hidden="true" />
                                <div>
                                    <dt class="text-sm text-encre-600">E-mail</dt>
                                    <dd class="mt-0.5 text-marine-900"><a :href="'mailto:' + email" class="lien">{{ email }}</a></dd>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 border-t border-filet py-4">
                                <Clock class="mt-1 size-5 shrink-0 text-sauge-600" stroke-width="1.5" aria-hidden="true" />
                                <div>
                                    <dt class="text-sm text-encre-600">Horaires</dt>
                                    <dd class="mt-0.5 text-marine-900">
                                        <span v-for="slot in company.hours" :key="slot.label" class="block">
                                            {{ slot.label }}, {{ slot.opens }} – {{ slot.closes }}
                                        </span>
                                    </dd>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 border-t border-filet py-4">
                                <MapPin class="mt-1 size-5 shrink-0 text-sauge-600" stroke-width="1.5" aria-hidden="true" />
                                <div>
                                    <dt class="text-sm text-encre-600">Adresse</dt>
                                    <dd class="mt-0.5 text-marine-900">
                                        {{ company.address.street }}, {{ company.address.postal_code }} {{ company.address.city }}
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>

                    <div class="reveal lg:col-span-7" style="--d: 120ms">
                        <div class="carte p-6 shadow-carte sm:p-9">
                            <LeadForm :services="services" :families="families" :default-service="chosenService" id-prefix="devis" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ QUESTIONS ══════════════════ -->
        <section id="questions" class="section-y">
            <div class="wrap">
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
                    <div class="lg:col-span-4">
                        <div class="lg:sticky lg:top-32">
                            <h2 class="reveal text-[length:var(--step-h2)]">Ce qu’on nous demande le plus</h2>
                            <p class="reveal mt-5 leading-relaxed text-encre-600" style="--d: 80ms">
                                Votre question n’est pas dans la liste&nbsp;? Appelez-nous, on vous répond directement.
                            </p>
                            <a :href="phoneHref" class="btn btn-ghost reveal mt-6" style="--d: 160ms" data-lead-cta="faq-call">
                                <Phone class="size-4" aria-hidden="true" />
                                {{ phone }}
                            </a>
                        </div>
                    </div>

                    <div class="reveal lg:col-span-8">
                        <FaqList :items="faq" />
                    </div>
                </div>
            </div>
        </section>

        <!-- ══════════════════ APPEL FINAL ══════════════════ -->
        <section class="relative overflow-hidden bg-sauge-100 py-20 sm:py-28">
            <div class="wrap relative text-center">
                <Sparkle class="scintille mx-auto size-7 text-marine-900" />
                <h2 class="reveal mx-auto mt-6 max-w-3xl text-[length:var(--step-h2)]">
                    Un appel, quelques photos, un prix.
                </h2>
                <p class="lead reveal mx-auto mt-4 max-w-xl" style="--d: 80ms">
                    C’est tout ce qu’il faut pour commencer.
                </p>
                <div class="reveal mt-9 flex flex-col justify-center gap-3 sm:flex-row" style="--d: 160ms">
                    <a :href="phoneHref" class="btn btn-primary text-base" data-lead-cta="final-call">
                        <Phone class="size-4" aria-hidden="true" />
                        {{ phone }}
                    </a>
                    <a href="#devis" class="btn btn-ghost text-base" data-lead-cta="final-quote">Demander un devis</a>
                </div>
            </div>
        </section>
    </SiteLayout>
</template>

<style scoped>
/* Filtre des communes : les pastilles se réordonnent en glissant. */
.commune-move,
.commune-enter-active,
.commune-leave-active {
    transition: opacity 0.3s ease, transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.commune-enter-from,
.commune-leave-to {
    opacity: 0;
    transform: scale(0.9);
}
.commune-leave-active {
    position: absolute;
}
</style>
