<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
const form = useForm({
    name: '',
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
    terms: false,
});
const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head><title>Register</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="profile-grid" class="mt-7 mb-14 grid grid-cols-4 relative">
        <div class="grid col-span-1 bg-[#E9EFFD] ml-[3vw] mr-[1vw] rounded-xl pt-[5vh]">
            <img id="profile-img" class="rounded-full justify-self-center mb-[7vh]" src="/svg_img/profile.svg" alt="profile image">
            <div class="px-[4vw] text-gray-800 font-medium text-2xl">
                <Link :href="route('about')">
                    <img src="/svg_icons/settings.svg" class="inline mr-3 pb-1" alt="Edit profile"/>
                    Edit info
                </Link>
            </div>
            <div class="px-[4vw] text-gray-800 font-medium text-2xl mt-4">
                <Link :href="route('about')">
                    <img src="/svg_icons/questionnaire.svg" class="inline mr-3 pb-1" alt="User questionnaire"/>
                    Questionnaire
                </Link>
            </div>
            <div class="px-[4vw] text-[#E67A79] font-medium text-2xl mt-4">
                <Link :href="route('about')">
                    <img src="/svg_icons/logout.svg" class="inline mr-3 pb-1" alt="Log out"/>
                    Log out
                </Link>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center col-span-3 border-2 border-[#E9EFFD] m-3 rounded-lg">
            World
        </div>
    </div>
    <Footer></Footer>
</template>

<style>
@media all and (max-width: 1000px) {
    #login-img{
        display: none
    }
    #login-grid{
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}
</style>