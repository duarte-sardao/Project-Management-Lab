<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import SearchAdmin from "@/Components/Admin/SearchAdmin.vue";
import {Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import axios from "axios";

const props = defineProps({
    patients: {
        default: []
    },
    medics: {
        default: []
    },
    patient_id: {
      default: null
    }
});

let patientResults = ref(props.patients);
let medicResults = ref(props.medics);

const searchMedic = ref('');
const searchPatient = ref('');
const getPatients = async (page = 1) => {
    axios.get('/api/admin/chat/patients?page=' + page + '&search=' + searchPatient.value)
        .then(response => {
            patientResults.value = response.data;
        })
}

const getMedics = async (page = 1) => {
    axios.get('/api/admin/chat/medics?page=' + page + '&search=' + searchMedic.value)
        .then(response => {
            medicResults.value = response.data;
        })
}

const deleteForm = useForm({});
const sendDelete = (patient_id, medic_id) => {
    if (props.route_id !== null) {
        deleteForm.delete(route('admin.chat.medics.remove', {patient_id: patient_id, medic_id: medic_id}), {
            onFinish () {
                patientResults.value = null;
                patientResults = ref(props.patients);
                medicResults.value = null;
                medicResults = ref(props.medics);
            }
        });
    }
}

const postForm = useForm({});
const sendPost = (patient_id, medic_id) => {
    if (props.route_id !== null) {
        postForm.post(route('admin.chat.medics.associate', {patient_id: patient_id, medic_id: medic_id}), {
            onFinish () {
                patientResults.value = null;
                patientResults = ref(props.patients);
                medicResults.value = null;
                medicResults = ref(props.medics);
            }
        });
    }
}
</script>

<template>
    <AdministrationLayout page="chat">
        <div id="grid" class="grid grid-cols-2">
            <div class="pb-16 text-xl text-gray-400">
                <div class="text-4xl text-black">{{ $t('chatContent') }}</div>
                {{ $t('chatContentHint') }}
            </div>
            <div></div>

            <div class="overflow-x-auto px-4">
                <div class="flex items-center text-xl text-gray-400">
                    {{ $t('patient') }}
                    <SearchAdmin class="w-full" v-model="searchPatient" @submit="getPatients"></SearchAdmin>
                </div>
                <table class="table w-full my-8">
                    <thead>
                    <tr>
                        <th class="w-3/12">{{ $t('username') }}</th>
                        <th class="w-5/12">{{ $t('name') }}</th>
                        <th class="w-2/12 text-center">{{ $t('healthcareNumber') }}</th>
                        <th class="w-2/12 text-center">{{ $t('state') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="patient in patientResults.data">
                        <td>{{ patient.username }}</td>
                        <td>{{ patient.name }}</td>
                        <td class="text-center">{{ patient.healthcare_number }}</td>
                        <td class="text-center">
                            <Link class="flex justify-center" :href="route('admin.chat.medics', {id: patient.id})">
                                <img v-if="patient_id && patient_id == patient.id" src="/svg_icons/check.svg" alt="our vision">
                                <img v-else src="/svg_icons/pencil.svg" alt="our vision">
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-center">
                    <TailwindPagination
                        :data="patientResults"
                        @pagination-change-page="getPatients"
                    />
                </div>
            </div>

            <div class="overflow-x-auto px-4">
                <div class="flex items-center text-xl text-gray-400">
                    {{ $t('medic') }}
                    <SearchAdmin class="w-full" v-model="searchMedic" @submit="getMedics"></SearchAdmin>
                </div>
                <table class="table w-full my-8">
                    <thead>
                    <tr>
                        <th class="w-6/12">{{ $t('name') }}</th>
                        <th class="w-3/12 text-center">{{ $t('licenseNumber') }}</th>
                        <th class="w-3/12 text-center">{{ $t('associated') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="medic in medicResults.data">
                        <td>{{ medic.name }}</td>
                        <td class="text-center">{{ medic.license_number }}</td>
                        <td v-if="!medic.state" class="text-center">
                            <Link class="flex justify-center">
                                <img src="/svg_icons/minus.svg" alt="our vision">
                            </Link>
                        </td>
                        <td v-else-if="medic.state === 'associated_true'" class="text-center">
                            <Link class="flex justify-center" @click="sendDelete(patient_id, medic.id)">
                                <img src="/svg_icons/check.svg" alt="our vision">
                            </Link>
                        </td>
                        <td v-else-if="medic.state === 'associated_false'" class="text-center">
                            <Link class="flex justify-center" @click="sendPost(patient_id, medic.id)">
                                <img src="/svg_icons/cross.svg" alt="our vision">
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-center">
                    <TailwindPagination
                        :data="medicResults"
                        @pagination-change-page="getMedics"
                    />
                </div>
            </div>
        </div>
    </AdministrationLayout>
</template>

<script>
export default {
    name: "Chat"
}
</script>

<style scoped>
@media all and (max-width: 1000px) {
    #grid{
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}
</style>
