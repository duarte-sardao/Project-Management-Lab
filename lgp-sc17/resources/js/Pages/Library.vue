<script setup>
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";

const title="Library"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>
    <Footer></Footer>
</template>

<script>
export default {
    name: "Library"
}
</script>

<style scoped>

</style>
