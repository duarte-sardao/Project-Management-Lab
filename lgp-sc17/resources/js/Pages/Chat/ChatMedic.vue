<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import ChatMessage from "@/Components/Chat/ChatMessages.vue";
import ChatForm from "@/Components/Chat/ChatForm.vue";
import axios from "axios";
import {ref} from "vue";

const user = usePage().props.auth.user;

const profile_img_url = ref(user.profile_img_url);
if (profile_img_url.value == null) {
    profile_img_url.value = '/svg_icons/profile.svg';
}
</script>


<template>
    <NavBarSimple :title="title" :subtitle="subtitle"/>
    <div class="pt-12 mb-7 px-20 flex gap-3 pb-5">
        <div class="card lg:card-side bg-skyBlue shadow-xl w-2/6 rounded-4xl">
            <div class="card-body"> 
                <p class="block card-title text-bold text-black text-5xl text-center pt-5"> {{ $t("patients") }} </p> 
                <div class="overflow-auto h-[36rem]">
                    <div v-for="patient in patients"> 
                        <div class="card-body">
                            <div class="card bg-stone lg:card-side bg-base-100 shadow-xl">
                                <figure><img class="ml-4" :src="profile_img_url" alt="ProfileImage"/></figure>
                                <div class="card-body w-2/3">
                                    <h2 class="card-title">{{patient[0].name}}</h2>
                                    <p> {{ $t("patient") }} </p>
                                    <div class="card-actions justify-end">
                                        <button class="btn btn-circle border-0 bg-adminMainBlue hover:bg-indigo text-white" 
                                            @click="fetchMessages(patient[0])"
                                        >Chat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div v-if="patients.length" class="card lg:card-side bg-inherit border-2 border-skyBlue/75 shadow-xl w-4/6">
            <div class="card-body">
                <h2 class="card-title text-black">{{ $t("currentPatient") }}: {{this.current_patient.name}}</h2>
                <ChatMessage :messages="messages" :user="user" class="h-3/4"></ChatMessage>
                <div class="card-actions justify-end">
                    <ChatForm v-on:messagesent="addMessage" :user="user" :patient="current_patient"></ChatForm>
                </div>
            </div>
        </div>
        <div v-else class="flex items-center w-4/6 justify-center text-lg text-gray-400">
            {{ $t('noPatientsAssociated') }}
        </div>
    </div>  
    <Footer></Footer>
</template>

<script>
export default {
  data() {
    return {
      messages: [],
      patients: [],
      current_patient: [],
    };
  },
  created() {
        this.fetchPatients();

        window.Echo.private('Chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
            })});
  },

  methods: {
    async fetchMessages(patient) {
        axios.get('/messagesMedic', { params: {'patient': patient.id} }).then(response => {
            this.messages = response.data;
            this.current_patient = patient;
        });
    },
    async addMessage(message) {
        axios.post('/messagesMedic', message, { params: {'patient': this.current_patient} }).then(response => {
            console.log(response.data);
        });
        this.fetchMessages(this.current_patient);
    },
    async fetchPatients() {
        axios.get('/getPatients').then(response => {
            this.patients = response.data;
        })
    },
    sendMessage() {
        const message = "New message";
        this.addMessage(message);
    }
  }
};
</script>
