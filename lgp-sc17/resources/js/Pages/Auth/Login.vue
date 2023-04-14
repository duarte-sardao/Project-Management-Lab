<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head><title>Log in</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="login-grid" class="grid grid-cols-2 relative">
        <img id="login-img" class="absolute" style="right: 15%; height: 120%; top: -10%; z-index: 0" src="/svg_img/login.svg" alt="login image">
        <div class="flex flex-col items-center justify-center col-span-1" style="z-index: 1">
            <div class="py-16 text-2xl font-bold text-gray-800">
                <Link class="py-2 mr-10 text-highlightBlue border-b-2 border-highlightBlue" :href="route('login')">Log in</Link>
                <Link class="py-2 ml-10" :href="route('register')">Sign up</Link>
            </div>

            <div class="pb-16">
                <form class="flex flex-col items-center" @submit.prevent="submit">
                    <div class="max-w-[22rem] w-[100vw]">
                        <InputLabel for="email" value="Username or Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 input-bordered border-mainBlue rounded-full bg-gray-50 w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4 max-w-[22rem] w-[100vw]">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 input-bordered border-mainBlue rounded-full bg-gray-50 w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center justify-center mt-4 mb-16 grid-cols-2">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-md text-gray-800 hover:text-gray-500 font-bold"
                        >
                            Forgot your password?
                        </Link>
                        <PrimaryButton class="justify-self-end ml-8" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">Log in</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="relative" style="z-index: 1">
        <Footer></Footer>
    </div>
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
