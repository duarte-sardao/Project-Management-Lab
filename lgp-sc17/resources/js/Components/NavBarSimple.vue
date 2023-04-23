<script setup>
import {Link, useForm, usePage} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";

let profile_img_url = '/svg_icons/profile.svg';
if (usePage().props.auth.user.profile_img_url) {
    profile_img_url = usePage().props.auth.user.profile_img_url;
}

const form = useForm({
    search: '',
});

const submit = () => {
    /* form.post(route('search'), {
        onFinish: () => {},
    }); */
};
</script>

<template>
    <div class="p-7 bg-gradient-to-r from-mainBlue to-transparent">
        <div class="navbar rounded-full px-7 bg-bgColor shadow-lg opacity-90">
            <label tabindex="0" class="btn btn-ghost">
                <div class="">
                    <img src="/logo.png"  alt="default user"/>
                </div>\
            </label>
            <div class="flex-1 ml-7">
                <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('homepage')">Home</Link>
                <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('library')">Library</Link>
                <Link class="btn btn-ghost text-gray-600 normal-case text-xl" :href="route('about')">About Us</Link>
            </div>
            <div class="flex-none gap-2">
                <form @submit.prevent="submit">
                    <div class="relative mr-7">
                        <TextInput
                            id="search"
                            type="search"
                            class="input block w-full text-sm text-gray-900 input-bordered border-mainBlue rounded-full bg-gray-50"
                            v-model="form.search"
                            placeholder="Search"
                            required
                            autocomplete="search"
                        />
                        <button type="submit" class="text-white absolute right-2.5 bottom-3.5 font-medium "><svg aria-hidden="true" class="w-5 h-5 text-mainBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                    </div>
                </form>
                <Link v-if="$page.props.auth.user === null" :href="route('login')" class="btn bg-lightBlue text-gray-600 hover:bg-mainBlue hover:text-gray-200 border-0 normal-case text-xl rounded-full px-7 mr-7">Log in</Link>
                <Link v-else :href="route('profile')" class="btn p-0 border-0 normal-case text-xl rounded-full">
                    <img id="profile-img" class="rounded-full mx-auto h-fit w-[48px] h-[48px]" :src="profile_img_url" alt="profile image">
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBarSimple"
}
</script>

<style scoped>

</style>
