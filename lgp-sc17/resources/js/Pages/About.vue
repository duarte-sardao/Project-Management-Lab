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
    subject: '',
    message: '',
    terms: false,
});


const submit = () => {
    form.post(route('about-form'), {});
};

</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>

    <div class="p-16 bg-[#FFFCF9]">
        <div id="about-grid" class="grid grid-cols-2 space-evenly place-items-center mb-36">
            <img src="/svg_icons/vision.svg" alt="our vision">
            <div class="pl-16 basis-3/6 m-auto">
                <div class="m-auto p-4 text-black font-bold text-center text-4xl">Our Vision</div>
                <div class="m-auto p-4 text-black text-center text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.</div>
            </div>

            <img id="first-about-pic" class="hidden" src="/svg_icons/howworks.svg" alt="how it works">
            <div class="pl-16 basis-3/6 m-auto">
                <div class="m-auto p-4 text-black font-bold text-center text-4xl">How It Works</div>
                <div class="m-auto p-4 text-black text-center text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.</div>
            </div>
            <img id="second-about-pic" src="/svg_icons/howworks.svg" alt="how it works">

            <img src="/svg_icons/howworks2.svg" alt="how it works">
            <div class="pl-16 basis-3/6 m-auto">
                <div class="m-auto p-4 text-black font-bold text-center text-4xl">How It Works</div>
                <div class="m-auto p-4 text-black text-center text-lg">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.</div>
            </div>
        </div>

        <div class="rounded-[50px] py-10 pl-10 pr-28 m-100 bg-[#E9EFFD] opacity-90 shadow-lg">

            <div class="my-5 ml-4 text-black font-bold text-4xl">Get in touch!</div>
            <div class="my-5 ml-4 text-black test-s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet</div>

            <form @submit.prevent="submit">
                <div class="border-b-2 border-b-gray-400">

                    <input
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

                <div class="mt-4 border-b-2 border-b-gray-400">

                    <input
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

                <div class="mt-4 border-b-2 border-b-gray-400">

                    <input
                        id="subject"
                        type="text"
                        placeholder="Message Subject"
                        class="input input-ghost w-full"
                        v-model="form.subject"
                        required
                        autocomplete="new-subject"
                    />

                    <InputError class="mt-2" :message="form.errors.subject" />
                </div>

                <div class="mt-4 border-b-2 border-b-gray-400">

                    <textarea
                        id="message"
                        type="text"
                        placeholder="Message"
                        class="textarea textarea-ghost w-full"
                        v-model="form.message"
                        required
                        autocomplete="new-message"
                    ></textarea>

                    <InputError class="mt-2" :message="form.errors.message" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <PrimaryButton  class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Send  
                        <svg aria-hidden="true" class="w-5 h-5 text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                            d="M 20.25 11.5008 L 20.6526 11.2043 L 20.8709 11.5008 L 20.6526 11.7972 L 20.25 11.5008 Z M 6.75 12.0008 C 6.4739 12.0008 6.25 11.7769 6.25 11.5008 C 6.25 11.2246 6.4739 11.0008 6.75 11.0008 V 12.0008 Z M 16.1526 5.0932 L 20.6526 11.2043 L 19.8474 11.7972 L 15.3474 5.6861 L 16.1526 5.0932 Z M 20.6526 11.7972 L 16.1526 17.9083 L 15.3474 17.3154 L 19.8474 11.2043 L 20.6526 11.7972 Z M 20.25 12.0008 H 6.75 V 11.0008 H 20.25 V 12.0008 Z">
                        </path></svg>
                    </PrimaryButton >
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

<style>
@media all and (max-width: 1000px) {
    #about-grid{
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
    #first-about-pic{
        display: block 
    }
    #second-about-pic{
        display: none 
    }
}
</style>
