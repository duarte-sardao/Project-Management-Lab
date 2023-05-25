<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    patients: {
        default: []
    },
    medics: {
        default: []
    },
});
</script>

<template>
    <AdministrationLayout page="chat">

    </AdministrationLayout>
</template>

<script>
export default {
    name: "Chat"
}
</script>

<style scoped>

</style>
