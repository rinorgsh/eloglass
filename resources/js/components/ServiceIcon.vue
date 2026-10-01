<script setup>
import { computed } from 'vue';
import {
    Home,
    Sparkles,
    Frame,
    KeyRound,
    Briefcase,
    Store,
    Building,
    SprayCan,
    HardHat,
    Footprints,
    Building2,
    SunMedium,
} from 'lucide-vue-next';

/*
| Table explicite plutôt qu'un `import * as icons` : cela évite d'embarquer
| la totalité de la bibliothèque d'icônes dans le bundle (~600 ko).
*/
const map = {
    // À la maison
    Home,
    Sparkles,
    Frame,
    KeyRound,
    // En entreprise
    Briefcase,
    Store,
    Building,
    SprayCan,
    // Travaux ponctuels
    HardHat,
    Footprints,
    Building2,
    SunMedium,
};

const props = defineProps({
    name: { type: String, required: true },
});

const component = computed(() => map[props.name] ?? Sparkles);
</script>

<template>
    <component :is="component" />
</template>
