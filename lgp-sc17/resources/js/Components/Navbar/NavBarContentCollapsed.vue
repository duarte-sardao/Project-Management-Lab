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
    <div class="ml-auto gap-2">
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-mainBlue" width="30" height="30" viewBox="0 0 96 96" id="menu"><switch><g><path d="M12 28h72a4 4 0 0 0 0-8H12a4 4 0 0 0 0 8zm72 16H12a4 4 0 0 0 0 8h72a4 4 0 0 0 0-8zm0 24H12a4 4 0 0 0 0 8h72a4 4 0 0 0 0-8z"></path></g></switch></svg>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('about')">{{ $t("about") }}</Link>
                </li>
                <li>
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('library')">{{ $t("library") }}</Link>
                </li>
                <li>
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('forum')">{{ $t("forum") }}</Link>
                </li>
                <li>
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('chat')">Chat</Link>
                </li>
                <li v-if="is_admin">
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('admin')">{{ $t("administration") }}</Link>
                </li>
                <template v-for="entry in languages">
                    <li v-if="entry.language != i18n.global.locale.value">
                        <button @click="changeLocale(entry.language)" class="flex justify-center group">
                            <flag :iso="entry.flag" v-bind:squared=false class="transition group-hover:scale-125 duration-300"/>
                        </button>
                    </li>
                </template>
                <li>
                    <Link v-if="$page.props.auth.user === null" :href="route('login')" class="btn bg-lightBlue hover:bg-mainBlue hover:text-gray-200 text-gray-600 border-0 normal-case text-xl rounded-full">
                        {{ $t("login") }}
                    </Link>
                    <Link v-else :href="route('profile')" class="btn p-0 border-0 normal-case text-xl rounded-full bg-transparent hover:bg-lightBlue">
                        <img id="profile-img" class="rounded-full mx-auto h-fit w-[48px] h-[48px] w-fit max-h-[40px]" :src="profile_img_url" alt="profile image">
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBarContentCollapsed",
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
