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
    healthcare_number: '',
    terms: false,
});

const submit = () => {
    form.post(route('register_patient'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head><title>Patient register</title></Head>
    <NavBarSimple></NavBarSimple>

    <div id="login-grid" class="grid grid-cols-2 relative">
        <img id="login-img" class="absolute" style="right: 7%; height: 85vh; top: 5%; z-index: 0" src="/svg_img/register.svg" alt="register image">
        <div class="flex flex-col items-center justify-center col-span-1" style="z-index: 1">
            <div class="pt-16 pl-4 pb-5 max-w-[22rem] w-[100vw] text-2xl font-bold text-gray-800 text-[#244D89]">
                <div class="w-fit">
                    Patient sign up
                    <img class="inline pl-2" style="height: 4vh;" src="/svg_icons/patient_sign_up.svg" alt="patient">
                    <div class="mt-1 block border-2 border-[#244D89] rounded-3xl"></div>
                </div>
            </div>

            <div class="pb-5">
                <form class="flex flex-col items-center w-full" @submit.prevent="submit">
                    <div class="max-w-[22rem] w-[100vw]">
                        <InputLabel for="name" value="Full Name" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-3 max-w-[22rem] w-[100vw]">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="email"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-3 max-w-[22rem] w-[100vw]">
                        <InputLabel for="username" value="Username" />
                        <TextInput
                            id="username"
                            type="text"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                            v-model="form.username"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.username" />
                    </div>

                    <div class="mt-3 max-w-[22rem] w-[100vw]">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-3 max-w-[22rem] w-[100vw]">
                        <InputLabel for="password_confirmation" value="Repeat Password" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="mt-3 max-w-[22rem] w-[100vw]">
                        <InputLabel for="healthcare" value="Healthcare number" />
                        <TextInput
                            id="healthcare"
                            type="number"
                            class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                            v-model="form.healthcare_number"
                            required
                            autocomplete="new-password"
                        />
                        <InputError class="mt-2" :message="form.errors.healthcare_number" />
                    </div>

                    <div class="max-w-[22rem] w-[100vw] pl-4 pt-4">
                        <input
                            type="checkbox"
                            id="terms"
                            v-model="form.terms"
                            class="rounded-full border-[#AFCDFB] focus:shadow-sm focus:ring-0 focus:ring-offset-0 mb-0.5"
                        />
                        <label for="terms" class="font-bold text-gray-800 pl-3">
                            I agree to
                            <Link
                                :href="route('Terms&Conditions')"
                                class="text-mainBlue hover:text-blue-300"
                            >
                                Terms and Conditions
                            </Link>
                            <InputError class="mt-2" :message="form.errors.terms" />
                        </label>
                    </div>

                    <div class="flex items-center justify-center mt-4 mb-10 grid-cols-2">
                        <Link
                            :href="route('login')"
                            class="text-md text-gray-800 hover:text-gray-500 font-bold"
                        >
                            Already registered?
                        </Link>
                        <PrimaryButton class="justify-self-end ml-8" :class="{ 'opacity-50': form.processing }" :disabled="form.processing">Sign up</PrimaryButton>
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
