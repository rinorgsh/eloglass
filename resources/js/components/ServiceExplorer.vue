<script setup>
import { ref, computed, watch } from 'vue';
import { Plus } from 'lucide-vue-next';
import ServiceIcon from './ServiceIcon.vue';
import Sparkle from './Sparkle.vue';

const props = defineProps({
    families: { type: Object, required: true },
    services: { type: Array, required: true },
});

// Le visiteur choisit une prestation : la page pré-remplit le formulaire.
const emit = defineEmits(['choose']);

const keys = computed(() => Object.keys(props.families));
const active = ref(keys.value[0]);

const list = computed(() => props.services.filter((service) => service.family === active.value));

// Une seule ligne ouverte à la fois ; la première l'est d'emblée.
const open = ref(list.value[0]?.slug ?? null);

watch(active, () => {
    open.value = list.value[0]?.slug ?? null;
});

function toggle(slug) {
    open.value = open.value === slug ? null : slug;
}

// Flèches gauche / droite : navigation clavier standard d'une liste d'onglets.
function onTabKeydown(event) {
    const direction = { ArrowRight: 1, ArrowDown: 1, ArrowLeft: -1, ArrowUp: -1 }[event.key];

    if (! direction) {
        return;
    }

    event.preventDefault();

    const index = (keys.value.indexOf(active.value) + direction + keys.value.length) % keys.value.length;
    active.value = keys.value[index];
    document.getElementById('famille-' + active.value)?.focus();
}
</script>

<template>
    <div class="grid gap-8 lg:grid-cols-12 lg:gap-16">
        <!-- Familles -->
        <div class="lg:col-span-4">
            <div
                role="tablist"
                aria-label="Familles de prestations"
                class="-mx-5 flex gap-7 overflow-x-auto px-5 pb-1 lg:sticky lg:top-28 lg:mx-0 lg:flex-col lg:gap-1 lg:overflow-visible lg:px-0"
                @keydown="onTabKeydown"
            >
                <button
                    v-for="key in keys"
                    :id="'famille-' + key"
                    :key="key"
                    type="button"
                    role="tab"
                    :aria-selected="active === key"
                    :aria-controls="'prestations-liste'"
                    :tabindex="active === key ? 0 : -1"
                    class="onglet group flex shrink-0 items-center gap-3 py-2 text-left font-display text-[1.75rem] leading-tight whitespace-nowrap transition-colors duration-300 lg:text-[2.5rem]"
                    :class="active === key ? 'text-marine-900' : 'text-encre-400 hover:text-marine-700'"
                    @click="active = key"
                >
                    <Sparkle
                        class="hidden size-4 shrink-0 text-sauge-600 transition-all duration-500 lg:block"
                        :class="active === key ? 'scale-100 opacity-100' : 'scale-0 -rotate-90 opacity-0'"
                    />
                    <span class="onglet-texte" :class="{ 'est-actif': active === key }">{{ families[key].label }}</span>
                </button>
            </div>
        </div>

        <!-- Prestations de la famille active -->
        <div id="prestations-liste" role="tabpanel" :aria-labelledby="'famille-' + active" class="lg:col-span-8">
            <Transition name="famille" mode="out-in">
                <div :key="active">
                    <p class="lead max-w-xl">{{ families[active].lead }}</p>

                    <ul class="mt-7 border-b border-filet">
                        <li
                            v-for="(service, i) in list"
                            :key="service.slug"
                            class="ligne-service border-t border-filet"
                            :style="{ '--i': i }"
                        >
                            <h3 class="font-sans text-base font-normal tracking-normal">
                                <button
                                    type="button"
                                    class="flex w-full items-center gap-4 py-5 text-left sm:gap-5"
                                    :aria-expanded="open === service.slug"
                                    :aria-controls="'detail-' + service.slug"
                                    @click="toggle(service.slug)"
                                >
                                    <span
                                        class="grid size-11 shrink-0 place-items-center rounded-full border transition-colors duration-300"
                                        :class="open === service.slug
                                            ? 'border-marine-900 bg-marine-900 text-white'
                                            : 'border-filet bg-white text-sauge-700'"
                                    >
                                        <ServiceIcon :name="service.icon" class="size-5" stroke-width="1.5" aria-hidden="true" />
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block font-display text-[length:var(--step-h3)] leading-tight font-medium text-marine-900">
                                            {{ service.title }}
                                        </span>
                                        <span class="mt-0.5 block text-[0.95rem] text-encre-600">{{ service.short }}</span>
                                    </span>
                                    <Plus
                                        class="size-5 shrink-0 text-marine-900 transition-transform duration-300"
                                        :class="{ 'rotate-45': open === service.slug }"
                                        stroke-width="1.5"
                                        aria-hidden="true"
                                    />
                                </button>
                            </h3>

                            <!-- Hauteur animée sans JavaScript : la rangée de grille passe de 0fr à 1fr. -->
                            <div
                                :id="'detail-' + service.slug"
                                class="detail"
                                :class="{ 'est-ouvert': open === service.slug }"
                                :inert="open !== service.slug"
                            >
                                <div class="overflow-hidden">
                                    <div class="pb-6 sm:pl-16">
                                        <p class="max-w-xl leading-relaxed text-encre-600">{{ service.text }}</p>
                                        <button
                                            type="button"
                                            class="lien mt-4 font-medium text-marine-900"
                                            @click="emit('choose', service.title)"
                                        >
                                            Demander un prix pour cette prestation
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style scoped>
/* Le trait sous l'onglet actif se trace de gauche à droite. */
.onglet-texte {
    background: linear-gradient(var(--color-sauge-600), var(--color-sauge-600)) 0 100% / 0 1.5px no-repeat;
    padding-bottom: 0.15em;
    transition: background-size 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.onglet-texte.est-actif {
    background-size: 100% 1.5px;
}

.detail {
    display: grid;
    grid-template-rows: 0fr;
    transition: grid-template-rows 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}
.detail.est-ouvert {
    grid-template-rows: 1fr;
}

/* Changement de famille : l'ancienne liste s'efface, la nouvelle arrive ligne par ligne. */
.famille-leave-active {
    transition: opacity 0.18s ease;
}
.famille-leave-to {
    opacity: 0;
}
.famille-enter-active .ligne-service {
    animation: arriver 0.55s cubic-bezier(0.16, 1, 0.3, 1) both;
    animation-delay: calc(var(--i) * 70ms);
}
@keyframes arriver {
    from {
        opacity: 0;
        transform: translateY(14px);
    }
}
</style>
