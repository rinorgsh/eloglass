<script setup>
import { computed } from 'vue';
import { Home, Store, Building2, Frame, SunMedium, HardHat, Sparkles } from 'lucide-vue-next';

/*
| Table explicite plutôt qu'un `import * as icons` : cela évite d'embarquer
| la totalité de la bibliothèque d'icônes dans le bundle (~600 ko).
*/
const map = { Home, Store, Building2, Frame, SunMedium, HardHat };

const props = defineProps({
    name: { type: String, required: true },
});

const component = computed(() => map[props.name] ?? Sparkles);
</script>

<template>
    <component :is="component" />
</template>
