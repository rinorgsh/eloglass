<script setup>
import { ref, computed, onMounted, onBeforeUnmount, watch } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { Phone, Menu, X, MapPin, Mail, Clock } from 'lucide-vue-next';
import BrandLogo from '../components/BrandLogo.vue';
import WhatsAppIcon from '../components/WhatsAppIcon.vue';

const page = usePage();
const company = computed(() => page.props.company);
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);
const phone2 = computed(() => page.props.contactPhone2);
const phone2Href = computed(() => 'tel:' + page.props.contactPhone2E164);
const email = computed(() => page.props.contactEmail);
const whatsappHref = computed(
    () => 'https://wa.me/' + page.props.whatsapp + '?text=' + encodeURIComponent('Bonjour, je souhaite un devis de nettoyage.'),
);

const sections = [
    { id: 'prestations', label: 'Prestations' },
    { id: 'methode', label: 'Méthode' },
    { id: 'communes', label: 'Communes' },
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

/*
| Les entrées du menu sont de vrais liens (/#section) : lisibles par les
| robots et utilisables sans JavaScript. Quand la section existe sur la
| page courante, on se contente d'y défiler.
*/
function goToSection(event, id) {
    menuOpen.value = false;

    const target = document.getElementById(id);

    if (target) {
        event.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>

<template>
    <div class="min-h-screen">
        <a
            href="#contenu"
            class="sr-only focus:not-sr-only focus:absolute focus:top-3 focus:left-3 focus:z-[100] focus:rounded-full focus:bg-marine-900 focus:px-4 focus:py-2.5 focus:text-white"
        >
            Aller au contenu
        </a>

        <!-- ══════════════════ EN-TÊTE ══════════════════ -->
        <header
            class="fixed inset-x-0 top-0 z-50 border-b transition-[background-color,border-color] duration-300"
            :class="scrolled ? 'border-filet bg-ivoire/90 backdrop-blur-md' : 'border-transparent'"
        >
            <div class="wrap flex items-center justify-between gap-4 py-3">
                <Link href="/" class="shrink-0" aria-label="Clean Company, accueil">
                    <BrandLogo compact />
                </Link>

                <nav class="hidden items-center gap-8 lg:flex" aria-label="Navigation principale">
                    <a
                        v-for="section in sections"
                        :key="section.id"
                        :href="'/#' + section.id"
                        class="nav-lien text-[0.95rem] text-encre-900"
                        @click="goToSection($event, section.id)"
                    >
                        {{ section.label }}
                    </a>
                </nav>

                <div class="flex items-center gap-3">
                    <a
                        :href="phoneHref"
                        class="hidden items-center gap-2 text-[0.95rem] font-medium text-marine-900 transition-colors hover:text-sauge-700 md:inline-flex"
                        data-lead-cta="header-call"
                    >
                        <Phone class="size-4 text-sauge-600" stroke-width="1.5" aria-hidden="true" />
                        {{ phone }}
                    </a>
                    <a
                        href="/#devis"
                        class="btn btn-primary hidden min-h-11 text-[0.95rem] md:inline-flex"
                        data-lead-cta="header-quote"
                        @click="goToSection($event, 'devis')"
                    >
                        Demander un devis
                    </a>
                    <button
                        type="button"
                        @click="menuOpen = true"
                        class="grid size-11 place-items-center rounded-full border border-filet bg-ivoire text-marine-900 lg:hidden"
                        aria-label="Ouvrir le menu"
                        :aria-expanded="menuOpen"
                    >
                        <Menu class="size-5" stroke-width="1.5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </header>

        <!-- ══════════════════ MENU MOBILE ══════════════════ -->
        <Transition name="menu">
            <div v-if="menuOpen" class="fixed inset-0 z-[60] bg-ivoire lg:hidden">
                <div class="flex h-full flex-col overflow-y-auto">
                    <div class="wrap flex w-full items-center justify-between py-3">
                        <BrandLogo compact />
                        <button
                            type="button"
                            @click="menuOpen = false"
                            class="grid size-11 place-items-center rounded-full border border-filet text-marine-900"
                            aria-label="Fermer le menu"
                        >
                            <X class="size-5" stroke-width="1.5" aria-hidden="true" />
                        </button>
                    </div>

                    <nav class="wrap w-full flex-1 pt-6" aria-label="Navigation mobile">
                        <a
                            v-for="(section, i) in sections"
                            :key="section.id"
                            :href="'/#' + section.id"
                            class="menu-entree block border-b border-filet py-4 font-display text-4xl text-marine-900"
                            :style="{ '--i': i }"
                            @click="goToSection($event, section.id)"
                        >
                            {{ section.label }}
                        </a>
                        <Link
                            href="/nettoyage"
                            class="menu-entree block border-b border-filet py-4 font-display text-4xl text-marine-900"
                            :style="{ '--i': sections.length }"
                        >
                            Toutes les communes
                        </Link>
                    </nav>

                    <div class="wrap w-full border-t border-filet bg-lin py-6">
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
                        <a :href="'mailto:' + email" class="mt-4 flex items-center gap-2 text-sm text-encre-600">
                            <Mail class="size-4 text-sauge-600" stroke-width="1.5" aria-hidden="true" /> {{ email }}
                        </a>
                    </div>
                </div>
            </div>
        </Transition>

        <main id="contenu">
            <slot />
        </main>

        <!-- ══════════════════ PIED DE PAGE ══════════════════ -->
        <footer class="bg-marine-950 text-white">
            <div class="wrap pt-16 pb-8">
                <div class="grid gap-12 border-b border-white/10 pb-12 md:grid-cols-12">
                    <div class="md:col-span-5">
                        <BrandLogo theme="dark" />
                        <p class="mt-6 max-w-sm leading-relaxed text-white/70">
                            Nettoyage de maisons, de bureaux, de commerces et de vitres, à Bruxelles et en périphérie.
                        </p>

                        <address class="mt-7 space-y-3 text-[0.95rem] not-italic">
                            <p class="flex items-center gap-3">
                                <Phone class="size-4 shrink-0 text-sauge-400" stroke-width="1.5" aria-hidden="true" />
                                <span>
                                    <a :href="phoneHref" class="lien font-medium text-white" data-lead-cta="footer-call">{{ phone }}</a>
                                    <span class="px-2 text-white/30" aria-hidden="true">/</span>
                                    <a :href="phone2Href" class="lien font-medium text-white" data-lead-cta="footer-call-2">{{ phone2 }}</a>
                                </span>
                            </p>
                            <p class="flex items-center gap-3">
                                <Mail class="size-4 shrink-0 text-sauge-400" stroke-width="1.5" aria-hidden="true" />
                                <a :href="'mailto:' + email" class="lien text-white/80">{{ email }}</a>
                            </p>
                            <p class="flex items-start gap-3 text-white/80">
                                <MapPin class="mt-1 size-4 shrink-0 text-sauge-400" stroke-width="1.5" aria-hidden="true" />
                                <span>
                                    {{ company.address.street }}<br />
                                    {{ company.address.postal_code }} {{ company.address.city }}, {{ company.address.country }}
                                </span>
                            </p>
                            <p class="flex items-start gap-3 text-white/80">
                                <Clock class="mt-1 size-4 shrink-0 text-sauge-400" stroke-width="1.5" aria-hidden="true" />
                                <span>
                                    <span v-for="slot in company.hours" :key="slot.label" class="block">
                                        {{ slot.label }} : {{ slot.opens }} – {{ slot.closes }}
                                    </span>
                                </span>
                            </p>
                        </address>
                    </div>

                    <div class="md:col-span-4">
                        <h2 class="font-display text-2xl text-white">Communes</h2>
                        <ul class="mt-5 grid grid-cols-2 gap-x-4 gap-y-2.5">
                            <li v-for="zone in page.props.footerZones ?? []" :key="zone.slug">
                                <Link :href="'/nettoyage/' + zone.slug" class="text-[0.95rem] text-white/70 transition-colors hover:text-white">
                                    {{ zone.city }}
                                </Link>
                            </li>
                        </ul>
                        <Link href="/nettoyage" class="lien mt-5 inline-block text-[0.95rem] font-medium text-sauge-200">
                            Toutes les communes
                        </Link>
                    </div>

                    <div class="md:col-span-3">
                        <h2 class="font-display text-2xl text-white">Entreprise</h2>
                        <ul class="mt-5 space-y-2.5 text-[0.95rem] text-white/70">
                            <li>TVA {{ company.vat }}</li>
                            <li>
                                <Link href="/mentions-legales" class="transition-colors hover:text-white">Mentions légales</Link>
                            </li>
                            <li>
                                <a :href="whatsappHref" target="_blank" rel="noopener" class="inline-flex items-center gap-2 transition-colors hover:text-white">
                                    <WhatsAppIcon class="size-4 text-[#25d366]" />
                                    WhatsApp
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <p class="pt-6 text-center text-sm text-white/50 sm:text-left">
                    © {{ new Date().getFullYear() }} {{ company.legalName }}. Société de nettoyage à Bruxelles et en périphérie.
                </p>
            </div>

            <!-- Espace réservé à la barre d'action fixe du mobile. -->
            <div class="h-20 lg:hidden" aria-hidden="true" />
        </footer>

        <!-- ══════════════════ BARRE D'ACTION MOBILE ══════════════════ -->
        <div
            class="fixed inset-x-0 bottom-0 z-40 border-t border-filet bg-ivoire/95 backdrop-blur-md lg:hidden"
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
                <a
                    href="/#devis"
                    class="btn btn-ghost flex-1 text-[0.95rem]"
                    data-lead-cta="sticky-quote"
                    @click="goToSection($event, 'devis')"
                >
                    Devis gratuit
                </a>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Lien de navigation : le trait se trace sous le mot au survol. */
.nav-lien {
    background: linear-gradient(var(--color-sauge-600), var(--color-sauge-600)) 0 100% / 0 1px no-repeat;
    padding-block: 0.35rem;
    transition: background-size 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.nav-lien:hover {
    background-size: 100% 1px;
}

/* Menu mobile : le voile s'ouvre, puis les entrées arrivent une à une. */
.menu-enter-active {
    transition: opacity 0.25s ease;
}
.menu-leave-active {
    transition: opacity 0.18s ease;
}
.menu-enter-from,
.menu-leave-to {
    opacity: 0;
}
.menu-enter-active .menu-entree {
    animation: glisser 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: calc(var(--i) * 60ms + 80ms);
}
@keyframes glisser {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
}
</style>
