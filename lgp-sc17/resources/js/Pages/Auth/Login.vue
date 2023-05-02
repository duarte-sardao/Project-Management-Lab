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
    credential: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head><title>{{ $t('loginTitle') }}</title></Head>
    <NavBarSimple></NavBarSimple>

    <div id="login-grid" class="grid grid-cols-2 relative">
        <img id="login-img" class="absolute" style="right: 15%; height: 120%; top: -10%; z-index: 0" src="/svg_img/login.svg" alt="login image">
        <div class="flex flex-col items-center justify-center col-span-1" style="z-index: 1">
            <div class="py-16 text-2xl font-bold text-gray-800">
                <Link class="py-2 mr-10 text-highlightBlue border-b-2 border-highlightBlue" :href="route('login')">
                    {{ $t('login') }}
                </Link>
                <Link class="py-2 ml-10" :href="route('register')">
                    {{ $t('register') }}
                </Link>
            </div>

            <div class="pb-16">
                <form class="flex flex-col items-center" @submit.prevent="submit">
                    <div class="max-w-[22rem] w-[100vw]">
                        <InputLabel for="credential" :value="$t('loginUsernameEmail')" />
                        <TextInput
                            id="credential"
                            type="text"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                            v-model="form.credential"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.credential" />
                    </div>

                    <div class="mt-4 max-w-[22rem] w-[100vw]">
                        <InputLabel for="password" :value="$t('password')" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
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
                            class="max-w-[13vw] text-md text-gray-800 hover:text-gray-500 font-bold text-center"
                        >
                            {{ $t('forgotPassword') }}
                        </Link>
                        <PrimaryButton class="justify-self-end ml-8" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                            {{ $t('login') }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
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
