<script setup>
import NavBar from "@/Components/NavBar.vue";

const title="About Us"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right>asdfasd</template>
        <template v-slot:content-bottom></template>
    </NavBar>
</template>

<script>
export default {
    name: "About"
}
</script>

<style scoped>

</style>
