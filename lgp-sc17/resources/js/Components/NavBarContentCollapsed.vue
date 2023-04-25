<script setup>
import {Link, usePage} from "@inertiajs/vue3";

let profile_img_url = '/svg_icons/profile.svg';
if (usePage().props.auth.user && usePage().props.auth.user.profile_img_url) {
    profile_img_url = usePage().props.auth.user.profile_img_url;
}
</script>

<template>
    <div class="ml-auto gap-2">
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-mainBlue" width="30" height="30" viewBox="0 0 96 96" id="menu"><switch><g><path d="M12 28h72a4 4 0 0 0 0-8H12a4 4 0 0 0 0 8zm72 16H12a4 4 0 0 0 0 8h72a4 4 0 0 0 0-8zm0 24H12a4 4 0 0 0 0 8h72a4 4 0 0 0 0-8z"></path></g></switch></svg>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                <li class="my-2">
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('homepage')">Home</Link>
                </li>
                <li class="my-2">
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('library')">Library</Link>
                </li>
                <li class="my-2">
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('about')">About Us</Link>
                </li>
                <li class="my-2">
                    <Link v-if="$page.props.auth.user === null" :href="route('login')" class="btn bg-lightBlue hover:bg-mainBlue hover:text-gray-200 text-gray-600 border-0 normal-case text-xl rounded-full">Log in</Link>
                    <Link v-else :href="route('profile')" class="btn p-0 border-0 normal-case text-xl rounded-full bg-transparent hover:bg-lightBlue">
                        <img id="profile-img" class="rounded-full mx-auto h-fit w-[48px] h-[48px]" :src="profile_img_url" alt="profile image">
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBarContentCollapsed"
}
</script>

<style scoped>

</style>
