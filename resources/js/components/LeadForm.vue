<script setup>
import { ref, computed, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Check, Phone, Loader2 } from 'lucide-vue-next';

const props = defineProps({
    // 'full'     : formulaire de devis complet
    // 'callback' : rappel express, deux champs
    variant: { type: String, default: 'full' },
    services: { type: Array, default: () => [] },
    families: { type: Object, default: () => ({}) },
    defaultCity: { type: String, default: '' },
    defaultService: { type: String, default: '' },
    // Préfixe des identifiants : permet plusieurs formulaires sur une même page.
    idPrefix: { type: String, default: 'lead' },
});

const page = usePage();
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);
const responseTime = computed(() => page.props.company.responseTime);

const propertyTypes = ['Maison', 'Appartement', 'Bureaux', 'Commerce', 'Immeuble', 'Autre'];

const submitted = ref(false);

const form = useForm({
    name: '',
    phone: '',
    email: '',
    company: '',
    city: props.defaultCity,
    property_type: '',
    service: props.defaultService,
    message: '',
    website: '',
});

// Une prestation choisie ailleurs sur la page pré-remplit le sélecteur.
watch(() => props.defaultService, (value) => {
    form.service = value;
    submitted.value = false;
});

const endpoint = computed(() => (props.variant === 'callback' ? '/rappel' : '/contact'));

const servicesByFamily = computed(() =>
    props.services.reduce((groups, service) => {
        (groups[service.family] ??= []).push(service);

        return groups;
    }, {}),
);

function submit() {
    form.post(endpoint.value, {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            // Signal de conversion pour Google Analytics / Ads, si présent.
            window.dataLayer?.push({ event: 'lead_submitted', lead_type: props.variant });
            form.reset();
            form.city = props.defaultCity;
            form.service = props.defaultService;
        },
    });
}
</script>

<template>
    <div>
        <!-- Confirmation -->
        <div v-if="submitted" class="flex flex-col items-center px-2 py-10 text-center" role="status">
            <span class="confirme grid size-14 place-items-center rounded-full bg-sauge-600 text-white">
                <Check class="size-7" stroke-width="1.5" aria-hidden="true" />
            </span>
            <p class="mt-5 font-display text-3xl text-marine-900">Demande envoyée</p>
            <p class="mt-2 max-w-xs text-encre-600">
                Nous vous répondons sous {{ responseTime }} avec votre prix. Pour une réponse immédiate, appelez-nous.
            </p>
            <a :href="phoneHref" class="btn btn-primary mt-6 w-full sm:w-auto" data-lead-cta="call-after-submit">
                <Phone class="size-4" aria-hidden="true" />
                {{ phone }}
            </a>
        </div>

        <form v-else @submit.prevent="submit" novalidate>
            <!-- Piège à robots : invisible pour les visiteurs. -->
            <div class="absolute left-[-9999px]" aria-hidden="true">
                <label>Ne pas remplir <input v-model="form.website" type="text" tabindex="-1" autocomplete="off" /></label>
            </div>

            <template v-if="variant === 'full'">
                <fieldset class="mb-5">
                    <legend class="mb-2.5 block text-sm font-medium text-encre-900">Quel type de lieu&nbsp;?</legend>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="type in propertyTypes"
                            :key="type"
                            type="button"
                            @click="form.property_type = form.property_type === type ? '' : type"
                            :aria-pressed="form.property_type === type"
                            class="min-h-10 rounded-full border px-4 text-[0.95rem] transition-colors duration-200"
                            :class="form.property_type === type
                                ? 'border-marine-900 bg-marine-900 text-white'
                                : 'border-filet bg-ivoire text-encre-900 hover:border-sauge-600'"
                        >
                            {{ type }}
                        </button>
                    </div>
                </fieldset>
            </template>

            <div class="grid gap-4" :class="variant === 'full' ? 'sm:grid-cols-2' : ''">
                <div>
                    <label :for="idPrefix + '-name'" class="mb-1.5 block text-sm font-medium text-encre-900">
                        Votre nom <span class="text-sauge-700" aria-hidden="true">*</span>
                    </label>
                    <input
                        :id="idPrefix + '-name'"
                        v-model="form.name"
                        type="text"
                        required
                        autocomplete="name"
                        placeholder="Prénom et nom"
                        class="field"
                        :class="{ 'field-error': form.errors.name }"
                        :aria-invalid="!!form.errors.name"
                    />
                    <p v-if="form.errors.name" class="mt-1.5 text-sm text-[#b42318]">{{ form.errors.name }}</p>
                </div>

                <div>
                    <label :for="idPrefix + '-phone'" class="mb-1.5 block text-sm font-medium text-encre-900">
                        Téléphone <span class="text-sauge-700" aria-hidden="true">*</span>
                    </label>
                    <input
                        :id="idPrefix + '-phone'"
                        v-model="form.phone"
                        type="tel"
                        required
                        inputmode="tel"
                        autocomplete="tel"
                        placeholder="0470 12 34 56"
                        class="field"
                        :class="{ 'field-error': form.errors.phone }"
                        :aria-invalid="!!form.errors.phone"
                    />
                    <p v-if="form.errors.phone" class="mt-1.5 text-sm text-[#b42318]">{{ form.errors.phone }}</p>
                </div>
            </div>

            <template v-if="variant === 'full'">
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label :for="idPrefix + '-city'" class="mb-1.5 block text-sm font-medium text-encre-900">Commune</label>
                        <input
                            :id="idPrefix + '-city'"
                            v-model="form.city"
                            type="text"
                            autocomplete="address-level2"
                            placeholder="Londerzeel, Uccle…"
                            class="field"
                        />
                    </div>
                    <div>
                        <label :for="idPrefix + '-email'" class="mb-1.5 block text-sm font-medium text-encre-900">
                            E-mail <span class="font-normal text-encre-400">(facultatif)</span>
                        </label>
                        <input
                            :id="idPrefix + '-email'"
                            v-model="form.email"
                            type="email"
                            inputmode="email"
                            autocomplete="email"
                            placeholder="vous@exemple.be"
                            class="field"
                            :class="{ 'field-error': form.errors.email }"
                        />
                        <p v-if="form.errors.email" class="mt-1.5 text-sm text-[#b42318]">{{ form.errors.email }}</p>
                    </div>
                </div>

                <div v-if="services.length" class="mt-4">
                    <label :for="idPrefix + '-service'" class="mb-1.5 block text-sm font-medium text-encre-900">Prestation</label>
                    <select :id="idPrefix + '-service'" v-model="form.service" class="field">
                        <option value="">Je ne sais pas encore</option>
                        <!-- Groupé par famille : le visiteur trouve sa prestation sans lire toute la liste. -->
                        <optgroup v-for="(list, key) in servicesByFamily" :key="key" :label="families[key]?.label ?? key">
                            <option v-for="svc in list" :key="svc.slug" :value="svc.title">{{ svc.title }}</option>
                        </optgroup>
                    </select>
                </div>

                <div class="mt-4">
                    <label :for="idPrefix + '-message'" class="mb-1.5 block text-sm font-medium text-encre-900">
                        Détails <span class="font-normal text-encre-400">(facultatif)</span>
                    </label>
                    <textarea
                        :id="idPrefix + '-message'"
                        v-model="form.message"
                        rows="3"
                        placeholder="Surface, nombre de pièces, fréquence souhaitée…"
                        class="field resize-y"
                    />
                </div>
            </template>

            <button
                type="submit"
                :disabled="form.processing"
                class="btn btn-primary mt-6 w-full text-base disabled:opacity-70"
                data-lead-cta="submit"
            >
                <Loader2 v-if="form.processing" class="size-4 animate-spin" aria-hidden="true" />
                {{ form.processing ? 'Envoi…' : (variant === 'callback' ? 'Me faire rappeler' : 'Recevoir mon prix') }}
            </button>

            <p class="mt-3 text-center text-sm text-encre-600">
                Réponse sous {{ responseTime }}, gratuit et sans engagement.
            </p>
        </form>
    </div>
</template>

<style scoped>
.confirme {
    animation: confirmer 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes confirmer {
    from {
        transform: scale(0.4);
        opacity: 0;
    }
}
</style>
