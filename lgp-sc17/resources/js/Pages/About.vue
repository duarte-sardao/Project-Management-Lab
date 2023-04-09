<script setup>
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const title="About Us"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"

const form = useForm({
    name: '',
    email: '',
    message_subject: '',
    message: '',
    terms: false,
});

</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>

    <div class="p-16 bg-[#FFFCF9]">
        <div class="grid grid-rows-3 mb-100 space-evenly">
            <div class="flex justify-evenly">
                <img src="/svg_icons/vision.svg" alt="our vision">
                <div class="pl-16 basis-3/6 m-auto">
                    <div class="m-auto p-4 text-black font-bold text-center text-4xl">Our Vision</div>
                    <div class="m-auto p-4 text-black text-center text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.</div>
                </div>
            </div>

            <div class="flex justify-evenly">
                <div class="pl-16 basis-3/6 m-auto">
                    <div class="m-auto p-4 text-black font-bold text-center text-4xl">How It Works</div>
                    <div class="m-auto p-4 text-black text-center text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.</div>
                </div>
                <img src="/svg_icons/howworks.svg" alt="how it works">
            </div>

            <div class="flex justify-evenly">
                <img src="/svg_icons/howworks2.svg" alt="how it works">
                <div class="pl-16 basis-3/6 m-auto">
                    <div class="m-auto p-4 text-black font-bold text-center text-4xl">How It Works</div>
                    <div class="m-auto p-4 text-black text-center text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.</div>
                </div>
            </div>
        </div>

        <div class="rounded-[50px] p-4 m-100 bg-[#E9EFFD] opacity-90 shadow-lg">

            <div class="my-5 ml-4 text-black font-bold text-2xl">Get in touch!</div>
            <div class="my-5 ml-4 text-black test-s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</div>

            <form @submit.prevent="submit">
                <div>

                    <TextInput
                        id="name"
                        type="text"
                        placeholder="Name"
                        class="input input-ghost w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">

                    <TextInput
                        id="email"
                        type="email"
                        placeholder="Email"
                        class="input input-ghost w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">

                    <TextInput
                        id="message_subject"
                        type="text"
                        placeholder="Message Subject"
                        class="input input-ghost w-full"
                        v-model="form.message_subject"
                        required
                        autocomplete="new-message_subject"
                    />

                    <InputError class="mt-2" :message="form.errors.message_subject" />
                </div>

                <div class="mt-4">

                    <TextInput
                        id="message"
                        type="text"
                        placeholder="Message"
                        class="input input-ghost w-full"
                        v-model="form.message"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Send
                    </PrimaryButton>
                </div>
            </form>
        </div>


    </div>

    <Footer></Footer>
</template>

<script>
export default {
    name: "About"
}
</script>

<style scoped>

</style>
