<script setup>
import ProfileTextBox from '@/Components/Profile/ProfileTextBox.vue';
import ProfileInfo from '@/Components/Profile/ProfileInfo.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import {ref} from "vue";
import MessageToast from "@/Components/MessageToast.vue";
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    user: { required: true },
    isGuest: Boolean,
    number: String,
    status: String,
    banned: Boolean,
    hospital: String,
    questionnaire: String,
    nextAppointment: {
        date: String,
        time: String
    },
    hospital_list: { required:true }
});

const user = ref(props.user);
const form = useForm({
    license_number: '',
    healthcare_number: '',
    hospital_id: '',
    date: '',
    time: '',
    action: '',
    questionnaire: props.questionnaire,
});

const submitDate = () => {
    const dateTimeString = form.date + 'T' + form.time;
    const dateTime = new Date(dateTimeString);

    const currentDateTime = new Date();

    if (dateTime < currentDateTime) {
        form.errors.time = "Must be in the future.";
        return;
    }


    const checkbox = document.getElementById('date-modal');
    checkbox.checked = false;
    form.action = 'set_date';
    form.post(route('admin.users.update', {id:user.id}), {
    });
};

const submitMedic = () => {
    if (form.license_number < 1) {
      form.errors.license_number = "Must be greater than 0.";
      return;
    }
    const checkbox = document.getElementById('medic-modal');
    checkbox.checked = false;
    form.action = 'register_medic';
    form.post(route('admin.users.update', {id:user.value.id}), {
    });
};

const submitPatient = () => {
    if (form.healthcare_number < 1) {
      form.errors.healthcare_number = "Must be greater than 0.";
      return;
    }
    const checkbox = document.getElementById('patient-modal');
    checkbox.checked = false;
    form.action = 'register_patient';
    form.post(route('admin.users.update', {id:user.value.id}), {
    });
};

window.banFunc = () => {
    const checkbox = document.getElementById('ban-modal');
    checkbox.checked = false;
    form.action = 'ban';
    form.post(route('admin.users.update', {id:user.value.id}), {
    });
};

window.unbanFunc = () => {
    const checkbox = document.getElementById('unban-modal');
    checkbox.checked = false;
    form.action = 'unban';
    form.post(route('admin.users.update', {id:user.value.id}), {
    });
};

const submit = () => {
    displayToast.value = true;
    form.post(route('profile.update'), {
        onFinish () {
            if (form.profile_img != null) {
                window.location.reload();
            }
            if (form.errors.phone_number) {
                form.phone_number = user.value.phone_number;
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
const profile_img_url = ref(user.value.profile_img_url);
if (profile_img_url.value == null) {
    profile_img_url.value = '/svg_icons/profile.svg';
}

const adminManagement = () => {
    useForm({}).post(route(`admin.users.${props.user.is_admin ? 'un' : ''}setAdmin`, { id: user.value.id }), {
        onFinish: () => {
            user.value = props.user;
            displayToastAction();
        },
    })
};
const displayToast = ref(false)
function cleanToast() {
    usePage().props.flash.success_message = null;
    usePage().props.flash.error_message = null;
    displayToast.value = false;
};
const displayToastAction = () => {
    displayToast.value = true;
    setTimeout(cleanToast, 3000);
};

</script>

<template>
    <MessageToast
        v-if="displayToast"
        :message="usePage().props.flash.success_message == null ? '':$t(`${usePage().props.flash.success_message}`)"
        :error="usePage().props.flash.error_message == null ? '':$t(`${usePage().props.flash.error_message}`)"
    />
    <Head><title>{{ $t("adminUserInfoTitle") }}</title></Head>
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
                    <div class="w-[75%] dropdown h-fit">
                        <label tabindex="0" class="btn w-full hover:opacity-70">{{ $t('setStatus') }}</label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li><label for="patient-modal">{{ $t('patient') }}</label></li>
                            <li><label for="medic-modal">{{ $t('medic') }}</label></li>
                        </ul>
                    </div>
                    <div v-if="!isGuest" class="mt-10 h-fit w-[75%]">  
                        <label for="date-modal" class="btn w-full hover:opacity-70">{{ $t('setDate') }}</label>
                    </div>
                    <div class="mt-10 h-fit w-[75%]">
                        <div class="btn w-full hover:opacity-70" v-on:click="adminManagement">
                            {{ $t(user.is_admin ? 'unsetAdmin':'setAdmin') }}
                        </div>
                    </div>
                    <div v-if="!user.is_admin && !banned" class="h-fit w-[75%] absolute bottom-[4vh] hover:opacity-70">  
                        <label for="ban-modal" class="btn btn-error w-full">{{ $t('ban') }}</label>
                    </div>
                    <div v-if="!user.is_admin && banned" class="h-fit w-[75%] absolute bottom-[4vh] hover:opacity-70">  
                        <label for="unban-modal" class="btn btn-error w-full">{{ $t('unban') }}</label>
                    </div>
                </div>
            </div>

            <div class="col-span-6 border-2 border-[#E9EFFD] ml-[1vw] mr-[1vw] rounded-lg pt-[5vh] px-[3vw] shadow-md">
                <div class="grid grid-cols-1">
                    <div class="col-span-1 h-fit">
                        <ProfileTextBox
                            :text="$t('fullName')"
                            v-model="user.name"
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
                            :text="status === 'Patient' ? $t('healthcareNumber'):$t('licenseNumber')"
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
                            v-model="user.phone_number"
                            :edit="edit"
                            :isInput="edit"
                            :required="false"
                            inputType="number"
                            :errors="(form.errors.phone_number === undefined) ? '':$t(`${form.errors.phone_number}`)"
                        />
                        <ProfileTextBox
                            v-if="!isGuest && status == 'Patient'"
                            :text="$t('questionnaire')"
                            v-model="form.questionnaire"
                            :edit="edit"
                            :isInput="edit"
                            :required="false"
                            inputType="url"
                            :errors="(form.errors.questionnaire === undefined) ? '':$t(`${form.errors.questionnaire}`)"
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
                        <ProfileInfo v-if="!isGuest" :text="$t('nextAppointmentTime')" :value="nextAppointment.time !== '' ? nextAppointment.time : $t('noFutureAppointment')" />
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
        <label class="btn btn-error" onclick="banFunc()">{{ $t('confirm') }}</label> <!--ban-->
        </div>
    </div>
    </div>

    <input type="checkbox" id="unban-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('unban') }}</p>
        <div class="modal-action">
        <label for="unban-modal" class="btn">{{ $t('cancel') }}</label>
        <label class="btn btn-error" onclick="unbanFunc()">{{ $t('confirm') }}</label> <!--unban-->
        </div>
    </div>
    </div>

    <input type="checkbox" id="patient-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
    <form @submit.prevent="submitPatient">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('actionStatus') }} {{ $t('patient') }}</p>
        <div class="mt-3 w-full">
            <InputLabel for="healthcare" :value="$t('healthcareNumber')" />
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
        <div class="mt-3 w-full">
            <InputLabel for="hospital" value="Hospital" />
            <select class="form-control mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full" 
            id="hospital" name="hospital" v-model="form.hospital_id" required focus>
                <option v-for="hosp in hospital_list" :value=hosp.id  selected>{{hosp.name}}</option>  
            </select>
            <InputError class="mt-2" :message="form.errors.hospital_id" />
        </div>
        <div class="modal-action">
        <label for="patient-modal" class="btn">{{ $t('cancel') }}</label>
        <PrimaryButton :disabled="form.processing">{{ $t('confirm') }}</PrimaryButton> <!--should close modal-->
        </div>
    </form>
    </div>
    </div>

    <input type="checkbox" id="medic-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
    <form @submit.prevent="submitMedic">
        <p class="py-4">{{ $t("confirmAction")}} {{  $t('actionStatus') }} {{ $t('medic') }}</p>
        <div class="mt-3 w-full">
            <InputLabel for="license" :value="$t('licenseNumber')" />
            <TextInput
                id="license"
                type="number"
                class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                v-model="form.license_number"
                required
                autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.license_number" />
        </div>
        <div class="mt-3 w-full">
            <InputLabel for="hospital" value="Hospital" />
            <select class="form-control mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full" 
            id="hospital" name="hospital" v-model="form.hospital_id" required focus>
                <option v-for="hosp in hospital_list" :value=hosp.id  selected>{{hosp.name}}</option>  
            </select>
            <InputError class="mt-2" :message="form.errors.hospital_id" />
        </div>
        <div class="modal-action">
        <label for="medic-modal" class="btn">{{ $t('cancel') }}</label>
        <PrimaryButton :disabled="form.processing">{{ $t('confirm') }}</PrimaryButton> <!--and this too-->
        </div>
    </form>
    </div>
    </div>

    <input type="checkbox" id="date-modal" class="modal-toggle" />
    <div class="modal">
    <div class="modal-box">
    <form @submit.prevent="submitDate">
        <p class="py-4">{{ $t("updateAppointment")}}</p>
        <div class="mt-3 w-full">
            <TextInput
                id="date"
                type="date"
                class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                v-model="form.date"
                required
            />
            <InputError class="mt-2" :message="form.errors.date" />
        </div>
        <div class="mt-3 w-full">
            <TextInput
                id="time"
                type="time"
                class="mt-1 input-bordered border-mainBlue rounded-full text-gray-800 w-full"
                v-model="form.time"
                required
            />
            <InputError class="mt-2" :message="form.errors.time" />
        </div>
        <div class="modal-action">
        <label for="date-modal" class="btn">{{ $t('cancel') }}</label>
        <PrimaryButton :disabled="form.processing">{{ $t('confirm') }}</PrimaryButton> <!--and this too-->
        </div>
    </form>
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
