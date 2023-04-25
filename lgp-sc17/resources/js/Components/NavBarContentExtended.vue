<script setup>
import {Link, usePage} from "@inertiajs/vue3";

let profile_img_url = '/svg_icons/profile.svg';
if (usePage().props.auth.user && usePage().props.auth.user.profile_img_url) {
    profile_img_url = usePage().props.auth.user.profile_img_url;
}
</script>

<template>
    <div class="flex-1 ml-7">
        <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('homepage')">Home</Link>
        <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('library')">Library</Link>
        <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('about')">About Us</Link>
    </div>
    <div class="flex-none gap-2">
        <Link v-if="$page.props.auth.user === null" :href="route('login')" class="btn bg-lightBlue hover:bg-mainBlue hover:text-gray-200 text-gray-600 border-0 normal-case text-xl rounded-full">Log in</Link>
        <Link v-else :href="route('profile')" class="btn p-0 border-0 normal-case text-xl rounded-full bg-transparent hover:bg-lightBlue">
            <img id="profile-img" class="rounded-full mx-auto h-fit w-[48px] h-[48px]" :src="profile_img_url" alt="profile image">
        </Link>
    </div>
</template>

<script>
export default {
    name: "NavBarMainButtons"
}
</script>

<style scoped>

</style>
