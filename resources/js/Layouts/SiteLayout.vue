<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { Phone, Menu, X, MapPin, Mail, Clock, ArrowRight } from 'lucide-vue-next';
import EloLogo from '../components/EloLogo.vue';
import WhatsAppIcon from '../components/WhatsAppIcon.vue';

const page = usePage();
const company = computed(() => page.props.company);
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);
const email = computed(() => page.props.contactEmail);
const whatsappHref = computed(
    () => 'https://wa.me/' + page.props.whatsapp + '?text=' + encodeURIComponent('Bonjour, je souhaite un devis pour le nettoyage de mes vitres.'),
);

const sections = [
    { id: 'prestations', label: 'Prestations' },
    { id: 'methode', label: 'Méthode' },
    { id: 'zones', label: 'Zones' },
    { id: 'questions', label: 'Questions' },
];

const menuOpen = ref(false);
const scrolled = ref(false);

function onScroll() {
    scrolled.value = window.scrollY > 12;
}

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});

// Bloque le défilement de l'arrière-plan quand le menu plein écran est ouvert.
watch(menuOpen, (open) => {
    document.body.style.overflow = open ? 'hidden' : '';
});

const stopNavigateListener = router.on('navigate', () => {
    menuOpen.value = false;
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    document.body.style.overflow = '';
    stopNavigateListener();
});

function goToSection(id) {
    menuOpen.value = false;

    const target = document.getElementById(id);

    if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });

        return;
    }

    router.visit('/#' + id);
}
</script>

<template>
    <div class="min-h-screen bg-white">
        <a
            href="#contenu"
            class="sr-only focus:not-sr-only focus:absolute focus:top-3 focus:left-3 focus:z-[100] focus:rounded-[7px] focus:bg-nuit-800 focus:px-4 focus:py-2.5 focus:text-white"
        >
            Aller au contenu
        </a>

        <!-- ══════════════════ EN-TÊTE ══════════════════ -->
        <header
            class="fixed inset-x-0 top-0 z-50 transition-colors duration-200"
            :class="scrolled ? 'border-b border-filet bg-white/90 backdrop-blur-md' : 'border-b border-transparent'"
        >
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-2.5 sm:px-6 lg:px-8">
                <Link href="/" class="shrink-0" aria-label="Elo Glass — accueil">
                    <EloLogo compact />
                </Link>

                <nav class="hidden items-center gap-7 lg:flex" aria-label="Navigation principale">
                    <button
                        v-for="section in sections"
                        :key="section.id"
                        type="button"
                        @click="goToSection(section.id)"
                        class="text-sm font-medium text-graphite-700 transition hover:text-elo-600"
                    >
                        {{ section.label }}
                    </button>
                </nav>

                <div class="flex items-center gap-2">
                    <a
                        :href="phoneHref"
                        class="hidden items-center gap-2 text-sm font-semibold text-nuit-800 transition hover:text-elo-600 md:inline-flex"
                        data-lead-cta="header-call"
                    >
                        <Phone class="size-4 text-elo-600" aria-hidden="true" />
                        {{ phone }}
                    </a>
                    <button
                        type="button"
                        @click="goToSection('devis')"
                        class="btn btn-primary hidden text-sm md:inline-flex"
                        data-lead-cta="header-quote"
                    >
                        Devis gratuit
                    </button>
                    <button
                        type="button"
                        @click="menuOpen = true"
                        class="grid size-11 place-items-center rounded-[7px] border border-filet bg-white text-nuit-800 lg:hidden"
                        aria-label="Ouvrir le menu"
                        :aria-expanded="menuOpen"
                    >
                        <Menu class="size-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </header>

        <!-- ══════════════════ MENU MOBILE ══════════════════ -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            leave-active-class="transition duration-150 ease-in"
            leave-to-class="opacity-0"
        >
            <div v-if="menuOpen" class="fixed inset-0 z-[60] bg-white lg:hidden">
                <div class="flex h-full flex-col overflow-y-auto">
                    <div class="flex items-center justify-between border-b border-filet px-4 py-2.5 sm:px-6">
                        <EloLogo compact />
                        <button
                            type="button"
                            @click="menuOpen = false"
                            class="grid size-11 place-items-center rounded-[7px] border border-filet text-nuit-800"
                            aria-label="Fermer le menu"
                        >
                            <X class="size-5" aria-hidden="true" />
                        </button>
                    </div>

                    <nav class="flex-1 px-4 py-3 sm:px-6" aria-label="Navigation mobile">
                        <button
                            v-for="section in sections"
                            :key="section.id"
                            type="button"
                            @click="goToSection(section.id)"
                            class="flex w-full items-center justify-between border-b border-filet py-4 text-left font-display text-xl font-semibold text-nuit-800"
                        >
                            {{ section.label }}
                            <ArrowRight class="size-5 text-ciel-500" aria-hidden="true" />
                        </button>
                        <Link
                            href="/lavage-de-vitres"
                            class="flex w-full items-center justify-between border-b border-filet py-4 text-left font-display text-xl font-semibold text-nuit-800"
                        >
                            Toutes nos communes
                            <ArrowRight class="size-5 text-ciel-500" aria-hidden="true" />
                        </Link>
                    </nav>

                    <div class="border-t border-filet bg-verre-50 px-4 py-5 sm:px-6">
                        <a :href="phoneHref" class="btn btn-primary w-full text-base" data-lead-cta="menu-call">
                            <Phone class="size-4" aria-hidden="true" />
                            {{ phone }}
                        </a>
                        <a
                            :href="whatsappHref"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-whatsapp mt-3 w-full text-base"
                            data-lead-cta="menu-whatsapp"
                        >
                            <WhatsAppIcon class="size-5" />
                            Écrire sur WhatsApp
                        </a>
                        <a :href="'mailto:' + email" class="mt-3 flex items-center gap-2 text-sm text-graphite-500">
                            <Mail class="size-4 text-elo-600" aria-hidden="true" /> {{ email }}
                        </a>
                        <p class="mt-2 flex items-center gap-2 text-sm text-graphite-500">
                            <MapPin class="size-4 text-elo-600" aria-hidden="true" />
                            {{ company.address.street }}, {{ company.address.postal_code }} {{ company.address.city }}
                        </p>
                    </div>
                </div>
            </div>
        </Transition>

        <main id="contenu">
            <slot />
        </main>

        <!-- ══════════════════ PIED DE PAGE ══════════════════ -->
        <footer class="bg-nuit-900 text-white">
            <div class="mx-auto max-w-6xl px-4 pt-14 pb-8 sm:px-6 lg:px-8">
                <div class="grid gap-10 border-b border-white/10 pb-10 md:grid-cols-12">
                    <div class="md:col-span-5">
                        <EloLogo theme="dark" />
                        <p class="mt-5 max-w-sm leading-relaxed text-ciel-100/75">
                            Lavage de vitres et nettoyage de bureaux pour les particuliers et les entreprises
                            de Bruxelles et de sa périphérie. Sans traces, à l'eau osmosée.
                        </p>

                        <address class="mt-6 space-y-2.5 text-sm not-italic">
                            <a :href="phoneHref" class="flex items-center gap-2.5 text-white transition hover:text-ciel-300" data-lead-cta="footer-call">
                                <Phone class="size-4 shrink-0 text-ciel-500" aria-hidden="true" />
                                <span class="font-semibold">{{ phone }}</span>
                            </a>
                            <a :href="'mailto:' + email" class="flex items-center gap-2.5 text-ciel-100/80 transition hover:text-white">
                                <Mail class="size-4 shrink-0 text-ciel-500" aria-hidden="true" />
                                {{ email }}
                            </a>
                            <p class="flex items-start gap-2.5 text-ciel-100/80">
                                <MapPin class="mt-0.5 size-4 shrink-0 text-ciel-500" aria-hidden="true" />
                                <span>
                                    {{ company.legalName }}<br />
                                    {{ company.address.street }}<br />
                                    {{ company.address.postal_code }} {{ company.address.city }}, {{ company.address.country }}
                                </span>
                            </p>
                            <p class="flex items-start gap-2.5 text-ciel-100/80">
                                <Clock class="mt-0.5 size-4 shrink-0 text-ciel-500" aria-hidden="true" />
                                <span>
                                    <span v-for="slot in company.hours" :key="slot.label" class="block">
                                        {{ slot.label }} : {{ slot.opens }} – {{ slot.closes }}
                                    </span>
                                </span>
                            </p>
                        </address>
                    </div>

                    <div class="md:col-span-4">
                        <p class="eyebrow text-ciel-500">Communes</p>
                        <ul class="mt-4 grid grid-cols-2 gap-x-4 gap-y-2.5">
                            <li v-for="zone in page.props.footerZones ?? []" :key="zone.slug">
                                <Link :href="'/lavage-de-vitres/' + zone.slug" class="text-sm text-ciel-100/80 transition hover:text-white">
                                    {{ zone.city }}
                                </Link>
                            </li>
                        </ul>
                        <Link href="/lavage-de-vitres" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-ciel-300 hover:text-white">
                            Toutes les zones
                            <ArrowRight class="size-3.5" aria-hidden="true" />
                        </Link>
                    </div>

                    <div class="md:col-span-3">
                        <p class="eyebrow text-ciel-500">Entreprise</p>
                        <ul class="mt-4 space-y-2.5 text-sm text-ciel-100/80">
                            <li>TVA {{ company.vat }}</li>
                            <li>BCE {{ company.bce }}</li>
                            <li>
                                <Link href="/mentions-legales" class="transition hover:text-white">Mentions légales</Link>
                            </li>
                            <li>
                                <a :href="whatsappHref" target="_blank" rel="noopener" class="inline-flex items-center gap-2 transition hover:text-white">
                                    <WhatsAppIcon class="size-4 text-[#25d366]" />
                                    WhatsApp
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <p class="pt-6 text-center text-xs text-ciel-100/50 sm:text-left">
                    © {{ new Date().getFullYear() }} {{ company.legalName }} — Lavage de vitres et nettoyage de bureaux à Bruxelles et en périphérie.
                </p>
            </div>

            <!-- Espace réservé à la barre d'action fixe du mobile. -->
            <div class="h-20 lg:hidden" aria-hidden="true" />
        </footer>

        <!-- ══════════════════ BARRE D'ACTION MOBILE ══════════════════ -->
        <div
            class="fixed inset-x-0 bottom-0 z-40 border-t border-filet bg-white/95 backdrop-blur-md lg:hidden"
            style="padding-bottom: env(safe-area-inset-bottom)"
        >
            <div class="flex items-stretch gap-2 px-3 py-2.5">
                <a :href="phoneHref" class="btn btn-primary flex-1 text-[0.95rem]" data-lead-cta="sticky-call">
                    <Phone class="size-4" aria-hidden="true" />
                    Appeler
                </a>
                <a
                    :href="whatsappHref"
                    target="_blank"
                    rel="noopener"
                    class="btn btn-whatsapp w-12 shrink-0 px-0"
                    aria-label="Écrire sur WhatsApp"
                    data-lead-cta="sticky-whatsapp"
                >
                    <WhatsAppIcon class="size-6" />
                </a>
                <button
                    type="button"
                    @click="goToSection('devis')"
                    class="btn btn-ghost flex-1 text-[0.95rem]"
                    data-lead-cta="sticky-quote"
                >
                    Devis gratuit
                </button>
            </div>
        </div>
    </div>
</template>
