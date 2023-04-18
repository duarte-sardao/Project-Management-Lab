<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="p-7 bg-gradient-to-r from-mainBlue relative overflow-hidden">
        <footer class="footer rounded-[50px] p-16 bg-bgColor shadow-lg opacity-90">
            <div class="flex items-center justify-center h-full">
                <Link id="image" class="flex justify-center align-middle mx-5" :href="route('homepage')">
                    <img src="/svg_img/logo.svg" alt="logo">
                </Link>
            </div>
            <div>
                <span class="mb-5 text-gray-800 text-xl">Learn More</span>
                <ul>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/link.svg" alt="link">
                        <Link class="text-gray-600 normal-case text-md" :href="route('about')">About Us</Link>
                    </li>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/link.svg" alt="link">
                        <Link class="text-gray-600 normal-case text-md" :href="route('library')">Library</Link>
                    </li>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/link.svg" alt="link">
                        <Link class="text-gray-600 normal-case text-md" :href="'#'">Privacy Policy</Link>
                    </li>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/link.svg" alt="link">
                        <Link class="text-gray-600 normal-case text-md" :href="'#'">Cookie Policy</Link>
                    </li>
                </ul>
            </div>
            <div>
                <span class="mb-5 text-gray-800 text-xl">Contact</span>
                <ul>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/phone.svg" alt="phone">
                        <span class="text-gray-600 normal-case text-md">123 456 789</span>
                    </li>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/whatsapp.svg" alt="whatsapp">
                        <span class="text-gray-600 normal-case text-md">Whatsapp</span>
                    </li>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/mail.svg" alt="mail">
                        <span class="text-gray-600 normal-case text-md">contact@gmail.com</span>
                    </li>
                    <li class="mb-3">
                        <img class="inline pr-5" src="/svg_icons/location.svg" alt="location">
                        <span class="text-gray-600 normal-case text-md">Terreiro da Se, 4050-573 Porto • Portugal</span>
                    </li>
                </ul>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    name: "Footer"
}
</script>

<style scoped>

</style>
