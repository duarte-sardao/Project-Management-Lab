<script setup>
import ProfileTextBox from '@/Components/Profile/ProfileTextBox.vue';
import ProfileInfo from '@/Components/Profile/ProfileInfo.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import {ref} from "vue";
import MessageToast from "@/Components/MessageToast.vue";
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";

const props = defineProps({
    user: { required: true },
    isGuest: Boolean,
    number: String,
    status: String,
    banned: Boolean,
    hospital: String,
    nextAppointment: {
        date: String,
        time: String
    }
});

const user = props.user;
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
                form.phone_number = user.phone_number;
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
    <AdministrationLayout page="users">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><Link :href="route('admin.users')">{{ $t('users') }}</Link></li>
                <li>{{ $t('userInfo') }}</li>
            </ul>
        </div>

        <div class="pb-8 text-xl text-base-content">
            {{ $t('userInfoEdit') }}
        </div>

        <form @submit.prevent="submit">
        <div id="profile-grid" class="mt-7 mb-14 grid grid-cols-8 relative">
            <div class="col-span-2 bg-[#E9EFFD] ml-[1vw] mr-[1vw] rounded-3xl shadow-md pt-[5vh] relative">
                <img id="profile-img" class="rounded-full mx-auto mb-[7vh] h-fit w-[200px] h-[200px]" :src="profile_img_url" alt="profile image">
                <div class="flex items-center flex-col">
                    <div v-if="!user.is_admin" class="dropdown h-fit">
                        <label tabindex="0" class="btn m-1">{{ $t('setStatus') }}</label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li v-if="status != 'Guest'"><label for="guest-modal">{{$t('guest')}}</label></li>
                            <li v-if="status != 'Patient'"><label for="patient-modal">{{ $t('patient') }}</label></li>
                            <li v-if="status != 'Medic'"><label for="medic-modal">{{ $t('medic') }}</label></li>
                        </ul>
                    </div>
                    <div v-if="!user.is_admin && !banned" class="h-fit">  
                        <label for="ban-modal" class="btn btn-error">{{ $t('ban') }}</label>
                    </div>
                    <div v-if="!user.is_admin && banned" class="h-fit">  
                        <label for="unban-modal" class="btn btn-error">{{ $t('unban') }}</label>
                    </div>
                </div>
            </div>

            <div class="col-span-6 border-2 border-[#E9EFFD] ml-[1vw] mr-[1vw] rounded-lg pt-[5vh] px-[3vw] shadow-md">
                <div class="grid grid-cols-1">
                    <div class="col-span-1 h-fit">
                        <ProfileTextBox
                            :text="$t('fullName')"
                            v-model="form.name"
                            :edit="edit"
                            :isInput="edit"
                            inputType="text"
                            :errors="form.errors.name"
                        />
                        <ProfileTextBox
                            :text="'Username'"
                            v-model="user.username"
                            :edit="edit"
                            :isInput="false"
                            inputType="text"
                            errors=""
                        />
                        <ProfileTextBox
                            v-if="!isGuest"
                            :text="status === 'Patient' ? $t('healthcareNumber'):$t('license')"
                            v-model="props.number"
                            :edit="edit"
                            :isInput="false"
                            input-type="text"
                            errors=""/>
                        <ProfileTextBox
                            :text="'Email'"
                            v-model="user.email"
                            :edit="edit"
                            :isInput="false"
                            inputType="email"
                            errors=""
                        />
                        <ProfileTextBox
                            :text="$t('phoneNumber')"
                            v-model="form.phone_number"
                            :edit="edit"
                            :isInput="edit"
                            :required="false"
                            inputType="number"
                            :errors="(form.errors.phone_number === undefined) ? '':$t(`${form.errors.phone_number}`)"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-4 mt-10 mb-[20vh]">
                    <div class="col-span-3">
                        <div v-if="edit">
                            <label for="image-input" class="pl-5 text-lg text-black/[.57] block">{{ $t('profileImage') }}</label>
                            <input id="image-input" @change="inputFile" type="file" accept="image/*" class="file-input file-input-primary w-full max-w-md right-0 bottom-10" />
                        </div>
                        <ProfileInfo :text="$t('status')" :value="status" />
                        <ProfileInfo v-if="!isGuest" :text="'Hospital'" :value="hospital" />
                        <ProfileInfo v-if="!isGuest" :text="$t('nextAppointmentDate')" :value="nextAppointment.date !== '' ? nextAppointment.date : $t('noFutureAppointment')" />
                        <ProfileInfo v-if="!isGuest" :text="$t('nextAppointmentDate')" :value="nextAppointment.time !== '' ? nextAppointment.time : $t('noFutureAppointment')" />
                        <div v-if="user.is_admin" class="my-5 text-xl">
                            <label class="text-error pr-1">{{ $t('isAdmin') }}</label>
                        </div>
                    </div>
                    <div class="col-span-1 relative">
                        <button
                            class="bg-[#578AD6] rounded-3xl text-white/[.78] px-7 py-3 absolute bottom-4 right-0"
                            v-if="edit"
                            type="submit"
                        >
                            {{ $t('updateProfileButton') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </AdministrationLayout>

    <input type="checkbox" id="ban-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('ban') }}</p>
        <div class="modal-action">
        <label for="ban-modal" class="btn">{{ $t('cancel') }}</label>
        <label class="btn btn-error">{{ $t('confirm') }}</label> <!--ban-->
        </div>
    </div>
    </div>

    <input type="checkbox" id="unban-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('unban') }}</p>
        <div class="modal-action">
        <label for="unban-modal" class="btn">{{ $t('cancel') }}</label>
        <label class="btn btn-error">{{ $t('confirm') }}</label> <!--unban-->
        </div>
    </div>
    </div>

    <input type="checkbox" id="guest-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('actionStatus') }} {{ $t('guest') }}</p>
        <div class="modal-action">
        <label for="guest-modal" class="btn">{{ $t('cancel') }}</label>
        <label class="btn btn-error">{{ $t('confirm') }}</label> <!--set guest-->
        </div>
    </div>
    </div>

    <input type="checkbox" id="patient-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('actionStatus') }} {{ $t('patient') }}</p>
        <div class="modal-action">
        <label for="patient-modal" class="btn">{{ $t('cancel') }}</label>
        <label class="btn btn-error">{{ $t('confirm') }}</label> <!--set patient-->
        </div>
    </div>
    </div>

    <input type="checkbox" id="medic-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('actionStatus') }} {{ $t('medic') }}</p>
        <div class="modal-action">
        <label for="medic-modal" class="btn">{{ $t('cancel') }}</label>
        <label class="btn btn-error">{{ $t('confirm') }}</label> <!--set medic-->
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: "UserInfo"
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
