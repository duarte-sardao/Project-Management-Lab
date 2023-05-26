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
    <div class="pt-12 px-20 flex gap-3 pb-5">
        <div class="card lg:card-side bg-skyBlue shadow-xl w-2/6 rounded-4xl">  
            <div class="flex-row w-full">
                <div class="card-body">
                    <div class="card bg-stone lg:card-side bg-base-100 shadow-xl">
                        <figure><img :src="profile_img_url" alt="ProfileImage"/></figure>
                        <div class="card-body w-2/3">
                            <h2 class="card-title">{{user.name}}</h2>
                            <p>Pacient</p>
                            <div class="card-actions justify-end">
                            </div>
                        </div>
                    </div>
                    <p></p>
                </div>
                <h2 class="text-center text-4xl text-black pb-2">Medic Team</h2>
                <div class="overflow-auto h-[26rem]"> 
                    <div v-for="medic in medics" class="pl-10 p-7">
                        <div class="card bg-stone lg:card-side bg-base-100 shadow-2xl">
                            <figure><img :src="profile_img_url" alt="ProfileImage"/></figure>
                            <div class="card-body w-2/3">
                                <h2 class="card-title">{{medic[0].name}}</h2>
                                <p>Médico</p>
                                <div class="card-actions justify-end">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card lg:card-side bg-inherit border-2 border-skyBlue/75 shadow-xl w-4/6">
            <div class="card-body">
                <ChatMessage :messages="messages" :user="user" class="h-3/4"></ChatMessage>
                <div class="card-actions justify-end">
                    <ChatForm v-on:messagesent="addMessage" :user="user" ></ChatForm>
                </div>
            </div>
        </div>
    </div>  
    <Footer></Footer>
</template>

<script>
export default {
  data() {
    return {
      messages: [],
      medics: [],
    };
  },
  created() {
        this.fetchMessages();
        this.fetchMedics();

        window.Echo.private('Chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
            })});
  },

  methods: {
    async fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
    },

    async addMessage(message) {
      console.log(message);
      axios.post('/messages', message).then(response => {
        console.log(response.data);
      });
      this.fetchMessages();
    },
    async fetchMedics() {
        axios.get('/getMedics').then(response => {
                this.medics = response.data;
                console.log(this.medics);
        });
    },
    sendMessage() {
      this.addMessage(message);
    }
  }
};
</script>
