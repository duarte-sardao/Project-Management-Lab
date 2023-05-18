<script setup>
import { Link } from '@inertiajs/vue3';
import NavBarContentExtended from "@/Components/Navbar/NavBarContentExtended.vue";
import NavBarContentCollapsed from "@/Components/Navbar/NavBarContentCollapsed.vue";

defineProps({
    background: {
        type: Boolean,
        default: true
    }
})

</script>

<template>
    <div class="relative" style="z-index: 2">
        <div class="p-7" :class="background && 'bg-gradient-to-r from-mainBlue to-transparent'">
            <div class="navbar rounded-full px-7 bg-bgColor shadow-lg opacity-90">
                <label tabindex="0" class="btn btn-ghost max-w-[40%]">
                    <Link href="/">
                        <img src="/logo.png" alt="default user"/>
                    </Link>
                </label>
                <NavBarContentExtended v-if="extended"></NavBarContentExtended>
                <NavBarContentCollapsed v-if="!extended"></NavBarContentCollapsed>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBarSimple",
    data() {
        return {
            extended: window.innerWidth > 1000
        };
    },
    mounted() {
        window.addEventListener("resize", this.myEventHandler);
    },
    unmounted() {
        window.removeEventListener("resize", this.myEventHandler);
    },
    methods: {
        myEventHandler() {
            this.extended = window.innerWidth > 1000
        }
    }
}
</script>

<style scoped>

</style>
