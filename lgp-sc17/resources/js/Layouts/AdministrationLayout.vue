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
            <main class="pt-20 px-16">
                <slot/>
            </main>
        </div>

        <div class="drawer-side">
            <label for="my-drawer" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 space-y-4 bg-adminBackground text-base-content text-xl flex-col">
                <li><Link class="justify-center" :href="route('homepage')"><img src="/logo.png" alt="default user"/></Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'dashboard' }" class="justify-center" :href="route('admin')">Dashboard</Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'users' }" class="justify-center" :href="route('admin.users')">{{ $t("users") }}</Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'library' }" class="justify-center" :href="route('admin.library')">{{ $t("library") }}</Link></li>
                <li><Link :class="{ 'bg-mainBlue text-white': props.page === 'forum' }" class="justify-center" :href="route('admin.forum')">Forum</Link></li>
                <template v-for="entry in languages">
                    <li v-if="entry.language != i18n.global.locale.value" style="margin-top: auto !important;">
                        <button @click="changeLocale(entry.language)" class="flex justify-center group">
                            <flag :iso="entry.flag" v-bind:squared=false class="transition group-hover:scale-125 duration-300"/>
                        </button>
                    </li>
                </template>
                <li>
                    <Link class="justify-center text-error" :href="route('logout')">
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
