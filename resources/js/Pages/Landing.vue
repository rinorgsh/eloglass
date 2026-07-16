<script setup>
import { onMounted, onBeforeUnmount, ref, computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import EloLogo from '../components/EloLogo.vue';
import {
    Sparkles,
    Home,
    Store,
    Building2,
    Frame,
    SunMedium,
    HardHat,
    Droplets,
    Clock,
    ShieldCheck,
    BadgeEuro,
    Users,
    Phone,
    Mail,
    MapPin,
    ArrowRight,
    ArrowUpRight,
    Check,
    Menu,
    X,
    Quote,
    Star,
} from 'lucide-vue-next';

const page = usePage();
const contactEmail = computed(() => page.props.contactEmail);
const contactPhone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + String(contactPhone.value).replace(/\s+/g, ''));

const mobileOpen = ref(false);
const scrolled = ref(false);
function onScroll() {
    scrolled.value = window.scrollY > 24;
}

let observer;
onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    observer.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
});
onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    observer?.disconnect();
});

function goTo(id) {
    mobileOpen.value = false;
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

const navLinks = [
    { id: 'services', label: 'Prestations' },
    { id: 'why', label: 'Pourquoi nous' },
    { id: 'process', label: 'Comment ça marche' },
    { id: 'contact', label: 'Contact' },
];

const services = [
    { icon: Home, title: 'Vitres résidentielles', text: 'Fenêtres, baies vitrées et châssis de votre habitation, nettoyés sans traces ni résidus.' },
    { icon: Store, title: 'Vitrines commerciales', text: 'Des devantures impeccables qui valorisent votre commerce, en entretien ponctuel ou régulier.' },
    { icon: Building2, title: 'Immeubles & bureaux', text: 'Nettoyage des surfaces vitrées de vos bureaux, halls et parties communes, en toute discrétion.' },
    { icon: Frame, title: 'Vérandas & verrières', text: 'Vitrages en hauteur, toitures de véranda et verrières remis à neuf avec le bon matériel.' },
    { icon: SunMedium, title: 'Panneaux solaires', text: 'Un vitrage propre, c’est un meilleur rendement. Nettoyage doux, sans rayures.' },
    { icon: HardHat, title: 'Nettoyage après chantier', text: 'Retrait des étiquettes, ciment, peinture et poussières après vos travaux de rénovation.' },
];

const whyItems = [
    { icon: Sparkles, title: 'Résultat sans traces', text: 'Une finition nette et brillante, garantie sur chaque vitre.' },
    { icon: Droplets, title: 'Eau pure & matériel pro', text: 'Perches télescopiques et eau osmosée pour un séchage parfait, même en hauteur.' },
    { icon: Clock, title: 'Ponctuel & rapide', text: 'On respecte les horaires convenus et on travaille avec efficacité.' },
    { icon: ShieldCheck, title: 'Assuré & soigneux', text: 'Intervention couverte et respectueuse de vos biens, de A à Z.' },
    { icon: BadgeEuro, title: 'Devis gratuit', text: 'Un prix clair et sans engagement, adapté à votre surface vitrée.' },
    { icon: Users, title: 'Particuliers & pros', text: 'Un interlocuteur unique pour la maison comme pour l’entreprise.' },
];

const steps = [
    { n: '01', title: 'Votre demande', text: 'Vous décrivez vos vitres à nettoyer via le formulaire ou par téléphone.' },
    { n: '02', title: 'Devis gratuit', text: 'On vous envoie un prix clair, sans surprise et sans engagement.' },
    { n: '03', title: 'Intervention', text: 'On se déplace avec le matériel professionnel, au moment convenu.' },
    { n: '04', title: 'Vitres impeccables', text: 'Vous profitez de vitres éclatantes, sans traces ni résidus.' },
];

/* Formulaire */
const submitted = ref(false);
const form = useForm({
    name: '',
    company: '',
    email: '',
    phone: '',
    service: '',
    message: '',
    website: '',
});
const serviceOptions = services.map((s) => s.title);

function submit() {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Lavage de vitres professionnel" />

    <div class="min-h-screen bg-white font-sans text-ink-900 antialiased">
        <!-- ===================== NAV ===================== -->
        <header
            class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
            :class="scrolled ? 'glass shadow-[0_6px_30px_-12px_rgba(37,99,235,0.25)]' : 'bg-transparent'"
        >
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3.5 lg:px-8">
                <a href="#top" @click.prevent="goTo('top')" aria-label="Elo Glass">
                    <EloLogo theme="light" compact />
                </a>

                <div class="hidden items-center gap-8 lg:flex">
                    <button
                        v-for="link in navLinks"
                        :key="link.id"
                        @click="goTo(link.id)"
                        class="group relative text-sm font-semibold text-ink-700 transition hover:text-brand-700"
                    >
                        {{ link.label }}
                        <span class="absolute -bottom-1.5 left-0 h-0.5 w-0 rounded-full bg-brand-600 transition-all duration-300 group-hover:w-full" />
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        :href="phoneHref"
                        class="hidden items-center gap-2 text-sm font-semibold text-ink-700 transition hover:text-brand-700 xl:inline-flex"
                    >
                        <Phone class="size-4 text-brand-600" />
                        {{ contactPhone }}
                    </a>
                    <button
                        @click="goTo('contact')"
                        class="hidden items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700 hover:shadow-brand-600/40 lg:inline-flex"
                    >
                        Devis gratuit
                        <ArrowRight class="size-4" />
                    </button>
                    <button
                        @click="mobileOpen = !mobileOpen"
                        class="grid size-10 place-items-center rounded-full border border-brand-100 bg-white/70 text-ink-900 lg:hidden"
                        aria-label="Menu"
                    >
                        <Menu v-if="!mobileOpen" class="size-5" />
                        <X v-else class="size-5" />
                    </button>
                </div>
            </nav>

            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                leave-active-class="transition duration-150 ease-in"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div v-if="mobileOpen" class="glass border-t border-white/50 lg:hidden">
                    <div class="mx-auto flex max-w-7xl flex-col gap-1 px-5 py-4">
                        <button
                            v-for="link in navLinks"
                            :key="link.id"
                            @click="goTo(link.id)"
                            class="rounded-lg px-3 py-3 text-left text-base font-semibold text-ink-700 transition hover:bg-brand-50 hover:text-brand-700"
                        >
                            {{ link.label }}
                        </button>
                        <div class="mt-2 flex items-center justify-between gap-3 px-3">
                            <a :href="phoneHref" class="inline-flex items-center gap-2 text-sm font-semibold text-ink-700">
                                <Phone class="size-4 text-brand-600" /> {{ contactPhone }}
                            </a>
                            <button @click="goTo('contact')" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-4 py-2 text-sm font-semibold text-white">
                                Devis gratuit
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </header>

        <!-- ===================== HERO ===================== -->
        <section id="top" class="relative overflow-hidden pt-32 pb-24 lg:pt-40 lg:pb-32">
            <!-- Fond aéré -->
            <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
                <div class="absolute inset-0" style="background: radial-gradient(1200px 600px at 70% -10%, #dbeafe 0%, #eff6ff 35%, #ffffff 70%)" />
                <div class="absolute -left-24 top-24 h-80 w-80 rounded-full bg-sky-2/40 blur-[110px]" />
                <div class="absolute right-10 top-10 h-96 w-96 rounded-full bg-brand-300/30 blur-[120px]" />
                <div class="absolute inset-0 opacity-[0.5]"
                    style="background-image: linear-gradient(#bfdbfe 1px, transparent 1px), linear-gradient(90deg, #bfdbfe 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(circle at 30% 20%, #000 0%, transparent 60%); -webkit-mask-image: radial-gradient(circle at 30% 20%, #000 0%, transparent 60%);" />
            </div>

            <div class="mx-auto grid max-w-7xl items-center gap-14 px-5 lg:grid-cols-12 lg:px-8">
                <div class="lg:col-span-6">
                    <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-200 bg-white/70 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.14em] text-brand-700 shadow-sm">
                        <Sparkles class="size-3.5 text-sky-1" />
                        Lavage de vitres professionnel
                    </span>

                    <h1 class="reveal mt-6 font-display text-4xl font-extrabold leading-[1.05] tracking-tight text-ink-900 sm:text-5xl lg:text-6xl" style="transition-delay: 80ms">
                        Des vitres
                        <span class="text-gradient">éclatantes</span>,
                        sans la moindre trace.
                    </h1>

                    <p class="reveal mt-6 max-w-xl text-lg leading-relaxed text-ink-500" style="transition-delay: 150ms">
                        Elo Glass nettoie les vitres des particuliers et des professionnels : maisons, vitrines,
                        immeubles, vérandas et panneaux solaires. Un résultat impeccable, avec un matériel professionnel.
                    </p>

                    <div class="reveal mt-8 flex flex-col gap-3 sm:flex-row sm:items-center" style="transition-delay: 220ms">
                        <button
                            @click="goTo('contact')"
                            class="group inline-flex items-center justify-center gap-2 rounded-full bg-brand-600 px-7 py-3.5 text-sm font-semibold text-white shadow-xl shadow-brand-600/30 transition hover:bg-brand-700 hover:shadow-brand-600/50"
                        >
                            Demander un devis gratuit
                            <ArrowRight class="size-4 transition-transform group-hover:translate-x-0.5" />
                        </button>
                        <a
                            :href="phoneHref"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-brand-200 bg-white/70 px-7 py-3.5 text-sm font-semibold text-ink-900 transition hover:border-brand-400 hover:bg-white"
                        >
                            <Phone class="size-4 text-brand-600" />
                            {{ contactPhone }}
                        </a>
                    </div>

                    <div class="reveal mt-9 flex flex-wrap gap-x-6 gap-y-3" style="transition-delay: 300ms">
                        <div v-for="t in ['Devis gratuit & sans engagement', 'Particuliers & professionnels', 'Sans traces, garanti']" :key="t" class="flex items-center gap-2 text-sm font-medium text-ink-700">
                            <span class="grid size-5 place-items-center rounded-full bg-brand-100 text-brand-700"><Check class="size-3.5" /></span>
                            {{ t }}
                        </div>
                    </div>
                </div>

                <!-- Visuel : logo mis en avant dans un panneau verre -->
                <div class="reveal lg:col-span-6" style="transition-delay: 200ms">
                    <div class="relative mx-auto max-w-md">
                        <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-br from-sky-2/50 via-brand-300/30 to-transparent blur-2xl" />
                        <div class="relative overflow-hidden rounded-[2rem] border border-white bg-white/70 p-4 shadow-[var(--shadow-glow)] backdrop-blur">
                            <div class="relative overflow-hidden rounded-[1.5rem] bg-white">
                                <img src="/logo.jpg" alt="Elo Glass — lavage de vitres" class="w-full" />
                                <span class="shine pointer-events-none absolute inset-0" />
                            </div>
                        </div>

                        <!-- Puces flottantes -->
                        <div class="absolute -left-4 top-8 flex items-center gap-2 rounded-2xl border border-white bg-white/90 px-4 py-2.5 shadow-lg backdrop-blur sm:-left-8">
                            <Sparkles class="size-4 text-sky-1 twinkle" />
                            <span class="text-sm font-semibold text-ink-900">Sans traces</span>
                        </div>
                        <div class="absolute -right-3 bottom-10 flex items-center gap-2 rounded-2xl border border-white bg-white/90 px-4 py-2.5 shadow-lg backdrop-blur sm:-right-6">
                            <span class="grid size-6 place-items-center rounded-full bg-brand-600 text-white"><Check class="size-3.5" /></span>
                            <span class="text-sm font-semibold text-ink-900">Devis gratuit</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== SERVICES ===================== -->
        <section id="services" class="relative bg-frost py-24 lg:py-32">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="reveal text-xs font-bold uppercase tracking-[0.18em] text-brand-600">Nos prestations</p>
                    <h2 class="reveal mt-3 font-display text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl lg:text-5xl" style="transition-delay: 70ms">
                        Tout ce qui est en verre, on le fait briller
                    </h2>
                    <p class="reveal mt-4 text-lg leading-relaxed text-ink-500" style="transition-delay: 130ms">
                        Un service de lavage de vitres complet, adapté à chaque type de surface et de bâtiment.
                    </p>
                </div>

                <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="(svc, i) in services"
                        :key="svc.title"
                        class="reveal group relative overflow-hidden rounded-3xl border border-brand-100 bg-white p-7 shadow-[var(--shadow-soft)] transition duration-300 hover:-translate-y-1.5 hover:border-brand-200 hover:shadow-[var(--shadow-card)]"
                        :style="{ transitionDelay: (i * 70) + 'ms' }"
                    >
                        <span class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-brand-50 transition group-hover:scale-150" />
                        <span class="relative grid size-14 place-items-center rounded-2xl text-white shadow-lg shadow-brand-600/25"
                            style="background: linear-gradient(135deg, #38bdf8 0%, #2563eb 60%, #1e3a8a 100%)">
                            <component :is="svc.icon" class="size-6" />
                        </span>
                        <h3 class="relative mt-5 font-display text-xl font-bold text-ink-900">{{ svc.title }}</h3>
                        <p class="relative mt-2.5 text-[0.95rem] leading-relaxed text-ink-500">{{ svc.text }}</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- ===================== POURQUOI ===================== -->
        <section id="why" class="relative overflow-hidden bg-white py-24 lg:py-32">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="grid gap-14 lg:grid-cols-12 lg:items-center">
                    <div class="lg:col-span-4">
                        <p class="reveal text-xs font-bold uppercase tracking-[0.18em] text-brand-600">Pourquoi Elo Glass</p>
                        <h2 class="reveal mt-3 font-display text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl lg:text-5xl" style="transition-delay: 70ms">
                            Le soin du détail, à chaque passage
                        </h2>
                        <p class="reveal mt-4 text-lg leading-relaxed text-ink-500" style="transition-delay: 130ms">
                            Un travail soigné, du matériel professionnel et un contact simple, pour des vitres
                            parfaitement propres, en intérieur comme en extérieur.
                        </p>
                        <button
                            @click="goTo('contact')"
                            class="reveal mt-7 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700"
                            style="transition-delay: 180ms"
                        >
                            Obtenir mon devis
                            <ArrowUpRight class="size-4" />
                        </button>
                    </div>

                    <div class="lg:col-span-8">
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div
                                v-for="(item, i) in whyItems"
                                :key="item.title"
                                class="reveal flex gap-4 rounded-2xl border border-brand-100 bg-frost/60 p-6 transition hover:border-brand-200 hover:bg-white hover:shadow-[var(--shadow-soft)]"
                                :style="{ transitionDelay: (i * 70) + 'ms' }"
                            >
                                <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-brand-100 text-brand-700">
                                    <component :is="item.icon" class="size-5" />
                                </span>
                                <div>
                                    <h3 class="font-display text-lg font-bold text-ink-900">{{ item.title }}</h3>
                                    <p class="mt-1 text-sm leading-relaxed text-ink-500">{{ item.text }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== PROCESS ===================== -->
        <section id="process" class="relative overflow-hidden py-24 text-white lg:py-32"
            style="background: linear-gradient(160deg, #1e3a8a 0%, #0f2456 55%, #0a1836 100%)">
            <div class="pointer-events-none absolute inset-0 opacity-[0.15]" aria-hidden="true"
                style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 60px 60px; mask-image: radial-gradient(circle at 80% 0%, #000, transparent 70%); -webkit-mask-image: radial-gradient(circle at 80% 0%, #000, transparent 70%);" />
            <div class="pointer-events-none absolute -left-20 bottom-0 h-96 w-96 rounded-full bg-brand-500/30 blur-[130px]" aria-hidden="true" />

            <div class="relative mx-auto max-w-7xl px-5 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="reveal text-xs font-bold uppercase tracking-[0.18em] text-sky-2">Comment ça marche</p>
                    <h2 class="reveal mt-3 font-display text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl" style="transition-delay: 70ms">
                        Simple, rapide, impeccable
                    </h2>
                </div>

                <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="(step, i) in steps"
                        :key="step.n"
                        class="reveal relative rounded-2xl border border-white/10 bg-white/[0.04] p-7 transition hover:border-sky-2/40 hover:bg-white/[0.07]"
                        :style="{ transitionDelay: (i * 90) + 'ms' }"
                    >
                        <span class="font-display text-4xl font-extrabold text-sky-2/70">{{ step.n }}</span>
                        <h3 class="mt-4 font-display text-lg font-bold">{{ step.title }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-brand-100/80">{{ step.text }}</p>
                    </div>
                </div>

                <!-- Bandeau avis -->
                <div class="reveal mt-14 flex flex-col items-center justify-between gap-6 rounded-3xl border border-white/10 bg-white/[0.05] p-8 sm:flex-row" style="transition-delay: 120ms">
                    <div class="flex items-start gap-4">
                        <Quote class="size-8 shrink-0 text-sky-2" />
                        <p class="max-w-xl font-display text-lg font-medium leading-snug">
                            « Des vitres parfaitement propres, un travail rapide et soigné. Je recommande sans hésiter. »
                        </p>
                    </div>
                    <div class="flex shrink-0 items-center gap-1 text-sky-2">
                        <Star v-for="s in 5" :key="s" class="size-5 fill-current" />
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== CONTACT ===================== -->
        <section id="contact" class="relative bg-frost py-24 lg:py-32">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-12">
                    <!-- Infos -->
                    <div class="lg:col-span-5">
                        <p class="reveal text-xs font-bold uppercase tracking-[0.18em] text-brand-600">Contact</p>
                        <h2 class="reveal mt-3 font-display text-3xl font-extrabold tracking-tight text-ink-900 sm:text-4xl lg:text-5xl" style="transition-delay: 70ms">
                            Demandez votre devis gratuit
                        </h2>
                        <p class="reveal mt-4 max-w-md text-lg leading-relaxed text-ink-500" style="transition-delay: 130ms">
                            Décrivez-nous les vitres à nettoyer : nous revenons vers vous rapidement avec un prix clair,
                            sans engagement.
                        </p>

                        <div class="reveal mt-8 space-y-4" style="transition-delay: 190ms">
                            <a :href="phoneHref" class="group flex items-center gap-4 rounded-2xl border border-brand-100 bg-white p-4 shadow-[var(--shadow-soft)] transition hover:border-brand-300">
                                <span class="grid size-12 place-items-center rounded-xl bg-brand-100 text-brand-700"><Phone class="size-5" /></span>
                                <div class="leading-tight">
                                    <p class="text-xs uppercase tracking-wide text-ink-500">Téléphone</p>
                                    <p class="font-semibold text-ink-900 transition group-hover:text-brand-700">{{ contactPhone }}</p>
                                </div>
                            </a>
                            <a :href="'mailto:' + contactEmail" class="group flex items-center gap-4 rounded-2xl border border-brand-100 bg-white p-4 shadow-[var(--shadow-soft)] transition hover:border-brand-300">
                                <span class="grid size-12 place-items-center rounded-xl bg-brand-100 text-brand-700"><Mail class="size-5" /></span>
                                <div class="leading-tight">
                                    <p class="text-xs uppercase tracking-wide text-ink-500">Email</p>
                                    <p class="font-semibold text-ink-900 transition group-hover:text-brand-700">{{ contactEmail }}</p>
                                </div>
                            </a>
                            <div class="flex items-center gap-4 rounded-2xl border border-brand-100 bg-white p-4 shadow-[var(--shadow-soft)]">
                                <span class="grid size-12 place-items-center rounded-xl bg-brand-100 text-brand-700"><MapPin class="size-5" /></span>
                                <div class="leading-tight">
                                    <p class="text-xs uppercase tracking-wide text-ink-500">Zone d’intervention</p>
                                    <p class="font-semibold text-ink-900">Bruxelles & Brabant</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <div class="reveal lg:col-span-7" style="transition-delay: 150ms">
                        <div class="rounded-3xl border border-brand-100 bg-white p-7 shadow-[var(--shadow-card)] sm:p-9">
                            <Transition enter-active-class="transition duration-500 ease-out" enter-from-class="opacity-0 scale-95">
                                <div v-if="submitted" class="flex min-h-[22rem] flex-col items-center justify-center text-center">
                                    <span class="grid size-16 place-items-center rounded-full bg-brand-50 text-brand-600"><Check class="size-8" /></span>
                                    <p class="mt-6 max-w-sm font-display text-2xl font-bold text-ink-900">Merci ! Votre demande a bien été envoyée.</p>
                                    <p class="mt-2 text-ink-500">Nous vous recontactons rapidement avec votre devis.</p>
                                    <a :href="phoneHref" class="mt-5 text-sm font-semibold text-brand-700 hover:underline">{{ contactPhone }}</a>
                                </div>

                                <form v-else @submit.prevent="submit" class="space-y-5">
                                    <input v-model="form.website" type="text" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true" />

                                    <div class="grid gap-5 sm:grid-cols-2">
                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-ink-700">Nom complet <span class="text-brand-600">*</span></label>
                                            <input v-model="form.name" type="text" required
                                                class="w-full rounded-xl border border-brand-100 bg-frost/60 px-4 py-3 text-ink-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-500/15" />
                                            <p v-if="form.errors.name" class="mt-1 text-xs text-red-500">{{ form.errors.name }}</p>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-ink-700">Société <span class="font-normal text-ink-500">(optionnel)</span></label>
                                            <input v-model="form.company" type="text"
                                                class="w-full rounded-xl border border-brand-100 bg-frost/60 px-4 py-3 text-ink-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-500/15" />
                                        </div>
                                    </div>

                                    <div class="grid gap-5 sm:grid-cols-2">
                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-ink-700">Email <span class="text-brand-600">*</span></label>
                                            <input v-model="form.email" type="email" required
                                                class="w-full rounded-xl border border-brand-100 bg-frost/60 px-4 py-3 text-ink-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-500/15" />
                                            <p v-if="form.errors.email" class="mt-1 text-xs text-red-500">{{ form.errors.email }}</p>
                                        </div>
                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-ink-700">Téléphone</label>
                                            <input v-model="form.phone" type="tel"
                                                class="w-full rounded-xl border border-brand-100 bg-frost/60 px-4 py-3 text-ink-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-500/15" />
                                        </div>
                                    </div>

                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-ink-700">Prestation souhaitée</label>
                                        <select v-model="form.service"
                                            class="w-full rounded-xl border border-brand-100 bg-frost/60 px-4 py-3 text-ink-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-500/15">
                                            <option value="">Sélectionnez une prestation</option>
                                            <option v-for="opt in serviceOptions" :key="opt" :value="opt">{{ opt }}</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="mb-1.5 block text-sm font-semibold text-ink-700">Votre message <span class="text-brand-600">*</span></label>
                                        <textarea v-model="form.message" required rows="4"
                                            placeholder="Décrivez les vitres à nettoyer (type, nombre, étage, accès…)"
                                            class="w-full resize-none rounded-xl border border-brand-100 bg-frost/60 px-4 py-3 text-ink-900 outline-none transition placeholder:text-ink-400 focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-500/15" />
                                        <p v-if="form.errors.message" class="mt-1 text-xs text-red-500">{{ form.errors.message }}</p>
                                    </div>

                                    <div class="flex items-center justify-between gap-4 pt-1">
                                        <p class="text-xs text-ink-400"><span class="text-brand-600">*</span> Champs obligatoires</p>
                                        <button type="submit" :disabled="form.processing"
                                            class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700 disabled:opacity-60">
                                            {{ form.processing ? 'Envoi en cours…' : 'Envoyer ma demande' }}
                                            <ArrowRight v-if="!form.processing" class="size-4" />
                                        </button>
                                    </div>
                                </form>
                            </Transition>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== FOOTER ===================== -->
        <footer class="bg-ink-900 pt-16 pb-8 text-white">
            <div class="mx-auto max-w-7xl px-5 lg:px-8">
                <div class="grid gap-10 border-b border-white/10 pb-12 lg:grid-cols-12">
                    <div class="lg:col-span-5">
                        <EloLogo theme="dark" />
                        <p class="mt-5 max-w-xs text-brand-100/80">
                            Lavage de vitres professionnel pour particuliers et entreprises. Des vitres éclatantes, sans traces.
                        </p>
                        <div class="mt-5 space-y-2 text-sm">
                            <a :href="phoneHref" class="flex items-center gap-2 text-brand-100 transition hover:text-white"><Phone class="size-4 text-sky-2" /> {{ contactPhone }}</a>
                            <a :href="'mailto:' + contactEmail" class="flex items-center gap-2 text-brand-100 transition hover:text-white"><Mail class="size-4 text-sky-2" /> {{ contactEmail }}</a>
                        </div>
                    </div>

                    <div class="lg:col-span-4 lg:col-start-7">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-2">Prestations</p>
                        <ul class="mt-4 grid grid-cols-1 gap-2.5 sm:grid-cols-2">
                            <li v-for="svc in services" :key="svc.title">
                                <button @click="goTo('services')" class="text-sm text-brand-100 transition hover:text-white">{{ svc.title }}</button>
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-2">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-2">Navigation</p>
                        <ul class="mt-4 space-y-2.5">
                            <li v-for="link in navLinks" :key="link.id">
                                <button @click="goTo(link.id)" class="text-sm text-brand-100 transition hover:text-white">{{ link.label }}</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-between gap-3 pt-6 text-xs text-brand-100/60 sm:flex-row">
                    <p>© {{ new Date().getFullYear() }} Elo Glass. Tous droits réservés.</p>
                    <p>Lavage de vitres · Particuliers & professionnels</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Balayage lumineux facon raclette sur le logo */
.shine::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -60%;
    width: 40%;
    height: 200%;
    transform: rotate(18deg);
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.75), transparent);
    animation: sweep 4.5s ease-in-out infinite;
}
@keyframes sweep {
    0% { left: -60%; }
    45%, 100% { left: 130%; }
}
@media (prefers-reduced-motion: reduce) {
    .shine::after { animation: none; opacity: 0; }
}
</style>
