<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { Check, Phone, ArrowRight, Loader2 } from 'lucide-vue-next';

const props = defineProps({
    // 'full'     : formulaire de devis complet
    // 'callback' : rappel express, deux champs
    variant: { type: String, default: 'full' },
    services: { type: Array, default: () => [] },
    defaultCity: { type: String, default: '' },
    defaultService: { type: String, default: '' },
    // Préfixe des identifiants : permet plusieurs formulaires sur une même page.
    idPrefix: { type: String, default: 'lead' },
});

const page = usePage();
const phone = computed(() => page.props.contactPhone);
const phoneHref = computed(() => 'tel:' + page.props.contactPhoneE164);
const responseTime = computed(() => page.props.company.responseTime);

const propertyTypes = ['Maison', 'Appartement', 'Commerce', 'Bureaux', 'Immeuble', 'Autre'];

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

const endpoint = computed(() => (props.variant === 'callback' ? '/rappel' : '/contact'));

const familyLabels = { vitres: 'Lavage de vitres', bureaux: 'Nettoyage de bureaux' };

const servicesByFamily = computed(() =>
    props.services.reduce((groups, service) => {
        (groups[service.family ?? 'vitres'] ??= []).push(service);

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
        <div v-if="submitted" class="flex flex-col items-center px-2 py-10 text-center">
            <span class="grid size-14 place-items-center rounded-full bg-ciel-100 text-elo-600">
                <Check class="size-7" aria-hidden="true" />
            </span>
            <p class="mt-5 font-display text-xl font-bold text-nuit-800">C'est envoyé, merci&nbsp;!</p>
            <p class="mt-2 max-w-xs text-graphite-500">
                Nous revenons vers vous sous {{ responseTime }} avec votre prix. Besoin d'une réponse tout de suite&nbsp;?
            </p>
            <a :href="phoneHref" class="btn btn-primary mt-5 w-full sm:w-auto" data-lead-cta="call-after-submit">
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
                    <legend class="mb-2.5 block text-sm font-semibold text-graphite-700">C'est pour quel type de bien&nbsp;?</legend>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="type in propertyTypes"
                            :key="type"
                            type="button"
                            @click="form.property_type = form.property_type === type ? '' : type"
                            :aria-pressed="form.property_type === type"
                            class="min-h-11 rounded-[7px] border px-3.5 text-sm font-medium transition"
                            :class="form.property_type === type
                                ? 'border-elo-600 bg-elo-600 text-white'
                                : 'border-filet bg-verre-50 text-graphite-700 hover:border-ciel-500 hover:bg-white'"
                        >
                            {{ type }}
                        </button>
                    </div>
                </fieldset>
            </template>

            <div class="grid gap-4" :class="variant === 'full' ? 'sm:grid-cols-2' : ''">
                <div>
                    <label :for="idPrefix + '-name'" class="mb-1.5 block text-sm font-semibold text-graphite-700">
                        Votre nom <span class="text-elo-600" aria-hidden="true">*</span>
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
                    <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

                <div>
                    <label :for="idPrefix + '-phone'" class="mb-1.5 block text-sm font-semibold text-graphite-700">
                        Téléphone <span class="text-elo-600" aria-hidden="true">*</span>
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
                    <p v-if="form.errors.phone" class="mt-1.5 text-sm text-red-600">{{ form.errors.phone }}</p>
                </div>
            </div>

            <template v-if="variant === 'full'">
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label :for="idPrefix + '-city'" class="mb-1.5 block text-sm font-semibold text-graphite-700">Localité</label>
                        <input
                            :id="idPrefix + '-city'"
                            v-model="form.city"
                            type="text"
                            autocomplete="address-level2"
                            placeholder="Lasne, Waterloo…"
                            class="field"
                        />
                    </div>
                    <div>
                        <label :for="idPrefix + '-email'" class="mb-1.5 block text-sm font-semibold text-graphite-700">
                            E-mail <span class="font-normal text-graphite-400">(facultatif)</span>
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
                        <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-600">{{ form.errors.email }}</p>
                    </div>
                </div>

                <div v-if="services.length" class="mt-4">
                    <label :for="idPrefix + '-service'" class="mb-1.5 block text-sm font-semibold text-graphite-700">Prestation</label>
                    <select :id="idPrefix + '-service'" v-model="form.service" class="field">
                        <option value="">Je ne sais pas encore</option>
                        <!-- Groupé par métier : le visiteur trouve sa prestation sans lire toute la liste. -->
                        <optgroup v-for="(list, key) in servicesByFamily" :key="key" :label="familyLabels[key]">
                            <option v-for="svc in list" :key="svc.slug" :value="svc.title">{{ svc.title }}</option>
                        </optgroup>
                    </select>
                </div>

                <div class="mt-4">
                    <label :for="idPrefix + '-message'" class="mb-1.5 block text-sm font-semibold text-graphite-700">
                        Détails <span class="font-normal text-graphite-400">(facultatif)</span>
                    </label>
                    <textarea
                        :id="idPrefix + '-message'"
                        v-model="form.message"
                        rows="3"
                        placeholder="Nombre de fenêtres, étage, véranda, accès au jardin…"
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
                {{ form.processing ? 'Envoi…' : (variant === 'callback' ? 'Rappelez-moi' : 'Recevoir mon prix') }}
                <ArrowRight v-if="!form.processing" class="size-4" aria-hidden="true" />
            </button>

            <p class="mt-3 text-center text-sm text-graphite-500">
                Réponse sous {{ responseTime }} · Gratuit et sans engagement
            </p>
        </form>
    </div>
</template>
