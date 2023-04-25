<script setup>
import ProfileTextBox from '@/Components/Profile/ProfileTextBox.vue';
import ProfileInfo from '@/Components/Profile/ProfileInfo.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import {ref} from "vue";
import MessageToast from "@/Components/MessageToast.vue";

const props = defineProps({
    isGuest: Boolean,
    number: String,
    status: String,
    hospital: String,
    nextAppointment: {
        date: String,
        time: String
    }
});

const user = usePage().props.auth.user;
const form = useForm({
    name: user.name,
    phone_number: user.phone_number,
    profile_img: null
});

const displayToast = ref(false);
function cleanToast() {
    usePage().props.flash.success_message = null;
    usePage().props.flash.error_message = null;
    displayToast.value = false;
}
const submit = () => {
    displayToast.value = true;
    form.post(route('profile.update'), {
        onFinish () {
            if (form.profile_img != null) {
                window.location.reload();
            }
            if (form.errors.phone_number) {
                form.phone_number = user.phone_number
            }
            setTimeout(cleanToast, 3000);
        }
    });
    edit.value = false;
};

function inputFile(event) {
    form.profile_img = event.target.files[0];
}

const edit = ref(false);
const profile_img_url = ref(user.profile_img_url);
if (profile_img_url.value == null) {
    profile_img_url.value = '/svg_icons/profile.svg';
}
</script>

<template>
    <Head><title>Profile</title></Head>
    <NavBarSimple></NavBarSimple>

    <MessageToast v-if="displayToast" :message="$page.props.flash.success_message" :error="$page.props.flash.error_message"></MessageToast>

    <form @submit.prevent="submit">
        <div id="profile-grid" class="mt-7 mb-14 grid grid-cols-8 relative">
            <div class="col-span-2 bg-[#E9EFFD] ml-[3vw] mr-[1vw] rounded-3xl shadow-md pt-[5vh] relative">
                <img id="profile-img" class="rounded-full mx-auto mb-[7vh] h-fit w-[200px] h-[200px]" :src="profile_img_url" alt="profile image">
                <div class="text-gray-800 font-medium text-2xl mb-[4vh]" :class="edit && 'text-center'">
                    <button class="border-0" @click="edit = !edit" type="button">
                        <div v-if="!edit" class="ml-[4vw]">
                            <img src="/svg_icons/settings.svg" class="inline mr-3 pb-1" alt="Edit profile"/>
                            <span>Edit info</span>
                        </div>
                        <div v-else class="bg-[#E67A79] border-2 px-3 py-2 text-white rounded-3xl">
                            Cancel edition
                        </div>
                    </button>
                </div>
                <div class="ml-[4vw] text-gray-800 font-medium text-2xl">
                    <Link v-if="!isGuest" href="#">
                        <img src="/svg_icons/questionnaire.svg" class="inline mr-3 pb-1" alt="User questionnaire"/>
                        Questionnaire
                    </Link>
                </div>
                <div class="ml-[4vw] text-error font-medium text-2xl mt-4 absolute bottom-[5vh]">
                    <Link :href="route('logout')" method="post" as="button">
                        <img src="/svg_icons/logout.svg" class="inline mr-3 pb-1" alt="Log out"/>
                        Log out
                    </Link>
                </div>
            </div>
            <div class="col-span-6 border-2 border-[#E9EFFD] ml-[1vw] mr-[3vw] rounded-lg pt-[5vh] px-[3vw] shadow-md">
                <div class="grid grid-cols-2">
                    <div class="col-span-1 h-fit">
                        <ProfileTextBox :text="'Full Name'" v-model="form.name" :edit="edit" :isInput="edit" inputType="text" :errors="form.errors.name"/>
                        <ProfileTextBox :text="'Username'" v-model="user.username" :edit="edit" :isInput="false" inputType="text" errors=""/>
                        <ProfileTextBox
                            v-if="!isGuest"
                            :text="status === 'Patient' ? 'Healthcare number':'License Number'"
                            v-model="props.number"
                            :edit="edit"
                            :isInput="false"
                            errors=""
                        />
                    </div>
                    <div class="col-span-1 grid justify-items-end flex items-start h-fit">
                        <ProfileTextBox :text="'Email'" v-model="user.email" :edit="edit" :isInput="false" inputType="email" errors=""/>
                        <ProfileTextBox :text="'Phone Number'" v-model="form.phone_number" :edit="edit" :isInput="edit" :required="false" inputType="number" :errors="form.errors.phone_number"/>
                    </div>
                </div>
                <div class="grid grid-cols-4 mt-10 mb-[20vh]">
                    <div class="col-span-3">
                        <div v-if="edit">
                            <label for="image-input" class="pl-5 text-lg text-black/[.57] block">Profile Image</label>
                            <input id="image-input" @change="inputFile" type="file" accept="image/*" class="file-input file-input-primary w-full max-w-md right-0 bottom-10" />
                        </div>
                        <ProfileInfo :text="'Status'" :value="status" />
                        <ProfileInfo v-if="!isGuest" :text="'Hospital'" :value="hospital" />
                        <ProfileInfo v-if="!isGuest" :text="'Next appointment date'" :value="nextAppointment.date !== '' ? nextAppointment.date : 'No future appointment'" />
                        <ProfileInfo v-if="!isGuest" :text="'Next appointment time'" :value="nextAppointment.time !== '' ? nextAppointment.time : 'No future appointment'" />
                    </div>
                    <div class="col-span-1 relative">
                        <button
                            class="bg-[#578AD6] rounded-3xl text-white/[.78] px-7 py-3 absolute bottom-4 right-0"
                            v-if="edit"
                            type="submit"
                        >
                            Update Info
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <Footer></Footer>
</template>

<script>
export default {
    name: "Profile"
}
</script>

<style scoped>
    #image-input {
        --tw-border-opacity: 1;
        border-color: #578AD6;
    }
    #image-input:focus {
        outline: 2px solid hsl(var(--p));
    }
    #image-input::file-selector-button {
        --tw-border-opacity: 1;
        border-color: #578AD6;
        --tw-bg-opacity: 1;
        background-color: #578AD6;
        --tw-text-opacity: 1;
        color: hsl(var(--pc) / var(--tw-text-opacity));
    }
</style>
