<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { i18n, changeLocale } from "@/plugins/i18n";

let profile_img_url = '/svg_icons/profile.svg';
if (usePage().props.auth.user && usePage().props.auth.user.profile_img_url) {
    profile_img_url = usePage().props.auth.user.profile_img_url;
}

let is_admin = (usePage().props.auth.user && usePage().props.auth.user.is_admin)
</script>

<template>
    <div class="flex-1 ml-7">
        <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('about')">{{ $t("about") }}</Link>
        <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('forum')">{{ $t("forum") }}</Link>
        <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('homepage')">{{ $t("home") }}</Link>
        <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('library')">{{ $t("library") }}</Link>
        <Link v-if="is_admin" class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('admin')">{{ $t("administration") }}</Link>
    </div>
    <div v-for="entry in languages">
        <button v-if="entry.language != i18n.global.locale.value" @click="changeLocale(entry.language)" class="transition mr-4 hover:scale-125 duration-300">
            <flag :iso="entry.flag" v-bind:squared=false />
        </button>
    </div>
    <div class="flex-none gap-2">
        <Link v-if="$page.props.auth.user === null" :href="route('login')" class="btn bg-lightBlue hover:bg-mainBlue hover:text-gray-200 text-gray-600 border-0 normal-case text-xl rounded-full">Log in</Link>
        <Link v-else :href="route('profile')" class="btn p-0 border-0 normal-case text-xl rounded-full bg-transparent hover:bg-lightBlue">
            <img id="profile-img" class="rounded-full mx-auto h-fit w-[48px] h-[48px] max-h-[48px] w-fit" :src="profile_img_url" alt="profile image">
        </Link>
    </div>
</template>

<script>
export default {
    name: "NavBarMainButtons",
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
