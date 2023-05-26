<script setup>
import {Link} from '@inertiajs/vue3';
import { i18n, changeLocale } from "@/plugins/i18n";

const props = defineProps({
    'page': {
        type: String,
        required: true,
    }
});
</script>

<template>
    <div class="drawer drawer-mobile">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col bg-white">
            <label for="my-drawer" class="absolute bottom-4 left-4 btn border-0 bg-adminMainBlue hover:bg-mainBlue drawer-button lg:hidden">❯</label>
            <main class="py-20 px-16">
                <slot/>
            </main>
        </div>

        <div class="drawer-side">
            <label for="my-drawer" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 space-y-4 bg-adminBackground text-base-content text-xl text-[#4A4A4A] flex-col">
                <li><Link class="justify-center active:bg-mainBlue" :href="route('homepage')"><img src="/logo.png" alt="default user"/></Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'dashboard' }" class="pl-[25%] active:bg-mainBlue" :href="route('admin')">
                    <img :src="`/svg_icons/adminDashboard${props.page === 'dashboard' ? 'Selected':''}.svg`" alt="Dashboard" class="max-h-[25px] h-[25px] w-fit"/>
                    Dashboard
                </Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'users' }" class="pl-[25%] active:bg-mainBlue" :href="route('admin.users')">
                    <img :src="`/svg_icons/adminUsers${props.page === 'users' ? 'Selected':''}.svg`" alt="Dashboard" class="max-h-[25px] h-[25px] w-fit"/>
                    {{ $t("users") }}
                </Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'library' }" class="pl-[25%] active:bg-mainBlue" :href="route('admin.library')">
                    <img :src="`/svg_icons/adminLibrary${props.page === 'library' ? 'Selected':''}.svg`" alt="Dashboard" class="max-h-[25px] h-[25px] w-fit"/>
                    {{ $t("library") }}
                </Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'forum' }" class="pl-[25%] active:bg-mainBlue" :href="route('admin.forum')">
                    <img :src="`/svg_icons/adminForum${props.page === 'forum' ? 'Selected':''}.svg`" alt="Dashboard" class="max-h-[25px] h-[25px] w-fit"/>
                    {{ $t("forumTitle") }}
                </Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'hospitals' }" class="pl-[25%] active:bg-mainBlue" :href="route('admin.hospitals')">
                    <img :src="`/svg_icons/adminHospitals${props.page === 'hospitals' ? 'Selected':''}.svg`" alt="Dashboard" class="max-h-[25px] h-[25px] w-fit"/>
                    {{ $t("hospitals") }}
                </Link></li>
                <template v-for="entry in languages">
                    <li v-if="entry.language != i18n.global.locale.value" style="margin-top: auto !important;">
                        <button @click="changeLocale(entry.language)" class="flex justify-center group">
                            <flag :iso="entry.flag" v-bind:squared=false class="transition group-hover:scale-125 duration-300"/>
                        </button>
                    </li>
                </template>
                <li>
                    <Link class="justify-center text-error" method="post" as="button" :href="route('logout')">
                        <img src="/svg_icons/logout.svg" class="inline mr-3 pb-1" alt="Log out"/>
                        {{ $t("logout") }}
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

export default {
    name: "AdministrationLayout",
    data() {
        return {
            languages: [
                { flag: 'us', language: 'en' },
                { flag: 'pt', language: 'pt' }
            ],
        }
    }
}
</script>

<style scoped>

</style>
