<script setup>
import { Link } from '@inertiajs/vue3';
import NavBarContentExtended from "@/Components/NavBarContentExtended.vue";
import NavBarContentCollapsed from "@/Components/NavBarContentCollapsed.vue";

const props = defineProps({
    title: {
        default: "Page Title",
    },
    subtitle: {
        default: null
    }
});
</script>

<template>
    <div class="relative overflow-hidden" style="z-index: 2">
        <div class="p-7 bg-gradient-to-r from-mainBlue to-bgColor overflow-hidden">
            <img class="absolute" style="right: -100px; height: 900px; top: -200px; z-index: 0" src="/svg_img/polygons.svg" alt="polygons">
            <div class="relative navbar rounded-full px-7 bg-bgColor shadow-lg opacity-90" style="z-index: 2;">
                <label tabindex="0" class="btn btn-ghost">
                    <Link href="/">
                        <img src="/logo.png"  alt="default user"/>
                    </Link>
                </label>
                <NavBarContentExtended v-if="extended"></NavBarContentExtended>
                <NavBarContentCollapsed v-if="!extended"></NavBarContentCollapsed>
            </div>
            <div class="relative m-16 grid grid-cols-2" style="z-index: 1">
                <div class="pl-16">
                    <div class="my-5 text-black font-bold text-4xl">{{title}}</div>
                    <div class="my-5 text-black font-bold">{{subtitle}}</div>
                </div>
                <div>
                    <div class="pl-16 text-black">
                        <slot name="content-right"></slot>
                    </div>
                </div>
            </div>
            <div class="m-16 pl-16 text-black">
                <slot name="content-bottom"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBar",
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
