<script setup>
import NavBar from "@/Components/NavBar.vue";

const title="Library"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>
</template>

<script>
export default {
    name: "Library"
}
</script>

<style scoped>

</style>
