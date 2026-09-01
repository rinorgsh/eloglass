<script setup>
import { computed } from 'vue';
import {
    Home,
    Store,
    Building2,
    Frame,
    SunMedium,
    HardHat,
    Briefcase,
    SprayCan,
    Footprints,
    Building,
    PackageOpen,
    Sparkles,
} from 'lucide-vue-next';

/*
| Table explicite plutôt qu'un `import * as icons` : cela évite d'embarquer
| la totalité de la bibliothèque d'icônes dans le bundle (~600 ko).
*/
const map = {
    // Lavage de vitres
    Home,
    Store,
    Building2,
    Frame,
    SunMedium,
    HardHat,
    // Nettoyage de bureaux
    Briefcase,
    SprayCan,
    Footprints,
    Building,
    PackageOpen,
};

const props = defineProps({
    name: { type: String, required: true },
});

const component = computed(() => map[props.name] ?? Sparkles);
</script>

<template>
    <component :is="component" />
</template>
