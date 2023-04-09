<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="p-7 bg-gradient-to-r from-mainBlue to-bgColor relative overflow-hidden">
        <div class="navbar rounded-[50px] p-16 bg-bgColor shadow-lg opacity-90">
            <div class="w-full grid-cols-3">
                <Link class="flex justify-center align-middle w-6/12 mx-5" :href="route('homepage')">
                    <img src="/svg_img/logo.svg" alt="logo">
                </Link>
                <div class="w-2/12 mx-5">
                    <div class="text-gray-800 text-xl mb-5">
                        Learn More
                    </div>
                    <ul>
                        <li class="mb-3"><Link class="text-gray-600 normal-case text-md" :href="route('about')">About Us</Link></li>
                        <li class="mb-3"><Link class="text-gray-600 normal-case text-md" :href="route('library')">Library</Link></li>
                        <li class="mb-3"><Link class="text-gray-600 normal-case text-md" :href="'#'">Privacy Policy</Link></li>
                        <li class="mb-3"><Link class="text-gray-600 normal-case text-md" :href="'#'">Cookie Policy</Link></li>
                    </ul>
                </div>
                <div class="w-4/12 mx-5">
                    <div class="text-gray-800 text-xl mb-5">
                        Contact
                    </div>
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Footer"
}
</script>

<style scoped>

</style>
