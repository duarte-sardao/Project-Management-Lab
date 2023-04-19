<script setup>
import ProfileTextBox from '@/Components/Profile/ProfileTextBox.vue';
import ProfileInfo from '@/Components/Profile/ProfileInfo.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";

let form = useForm(usePage().props.auth.user);
let userCopy = Object.assign({}, usePage().props.auth.user);

const submit = () => {
    form.patch(route('profile.update'), {
        onFinish: () => userCopy = Object.assign({}, form),
    });
};

defineProps({
    edit: Boolean,
    isGuest: Boolean,
    status: String,
    hospital: String,
    nextAppointment: Date,
});

</script>

<template>
    <Head><title>Register</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="profile-grid" class="mt-7 mb-14 grid grid-cols-8 relative">
        <div class="col-span-2 bg-[#E9EFFD] ml-[3vw] mr-[1vw] rounded-3xl shadow-md pt-[5vh] relative">
            <img id="profile-img" class="rounded-full mx-auto mb-[7vh] h-fit" src="/svg_img/profile.svg" alt="profile image">
            <div class="text-gray-800 font-medium text-2xl mb-[4vh]" :class="edit && 'text-center'">
                <Button  @click="{
                    if (edit) form = useForm(Object.assign({}, userCopy));
                    edit = !edit;
                }">
                    <div v-if="!edit" class="px-[4vw]">
                        <img src="/svg_icons/settings.svg" class="inline mr-3 pb-1" alt="Edit profile"/>
                        <span>Edit info</span>
                    </div>
                    <div v-else class="bg-[#E67A79] border-2 px-3 py-2 text-white rounded-3xl">
                        Cancel edition
                    </div>
                </Button>
            </div>
            <div class="px-[4vw] text-gray-800 font-medium text-2xl">
                <Link :href="route('about')">
                    <img src="/svg_icons/questionnaire.svg" class="inline mr-3 pb-1" alt="User questionnaire"/>
                    Questionnaire
                </Link>
            </div>
            <div class="px-[4vw] text-[#E67A79] font-medium text-2xl mt-4 absolute bottom-[5vh]">
                <Link href="/logout" method="post">
                    <img src="/svg_icons/logout.svg" class="inline mr-3 pb-1" alt="Log out"/>
                    Log out
                </Link>
            </div>
        </div>
        <div class="col-span-6 border-2 border-[#E9EFFD] ml-[1vw] mr-[3vw] rounded-lg pt-[5vh] px-[3vw] shadow-md">
            <div class="grid grid-cols-2">
                <div class="col-span-1 h-fit">
                    <ProfileTextBox :text="'Full Name'" v-model="form.name" :edit="edit" :isInput="edit" inputType="text" errors=""/>
                    <ProfileTextBox :text="'Username'" v-model="form.username" :edit="edit" :isInput="false" inputType="text" errors=""/>
                    <ProfileTextBox
                        v-if="!isGuest"
                        :text="status === 'Patient' ? 'Healthcare number':'License Number'"
                        v-model="form.name"
                        :edit="edit"
                        :isInput="false"
                        errors=""
                    />
                </div>
                <div class="col-span-1 grid justify-items-end flex items-start h-fit">
                    <ProfileTextBox :text="'Email'" v-model="form.email" :edit="edit" :isInput="false" inputType="email" errors=""/>
                    <ProfileTextBox :text="'Phone Number'" v-model="form.phone_number" :edit="edit" :isInput="edit" inputType="number" errors=""/>
                </div>
            </div>
            <div class="grid grid-cols-2 mt-10 mb-[20vh]">
                <div class="col-span-1">
                    <ProfileInfo :text="'Status'" :value="status" />
                    <ProfileInfo :text="'Hospital'" :value="hospital" />
                    <ProfileInfo :text="'Next appointment date'" :value="nextAppointment.date" />
                    <ProfileInfo :text="'Next appointment time'" :value="nextAppointment.time" />
                </div>
                <div class="col-span-1 relative">
                    <button
                        class="bg-[#578AD6] rounded-3xl text-white/[.78] px-7 py-3 absolute bottom-4 right-0"
                        v-if="edit"
                        @click="submit()"
                    >
                        Update Info
                    </button>
                </div>
            </div>
        </div>
    </div>
    <Footer></Footer>
</template>
