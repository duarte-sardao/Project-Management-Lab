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
                <div class="card-body
                ">
                    <h1 class="card-title text-3xl">Patient</h1>
                    <div class="card lg:card-side bg-base-100 shadow-xl">
                        <figure><img :src="profile_img_url" alt="ProfileImage"/></figure>
                        <div class="card-body w-2/3">
                            <h2 class="card-title">Rui Moreira</h2>
                            <p>Paciente, 27 anos, vendedor de laticionios</p>
                            <div class="card-actions justify-end">
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <div class="divider divider-horizontal border-[1px] border-black/30 w-[22rem]"></div>
                </div>
                <div class="overflow-auto h-[26rem]"> 
                    <div class="card-body">
                        <h2 class="card-title text-3xl">Team</h2>
                        <div class="card lg:card-side bg-base-100 shadow-xl">
                            <figure><img :src="profile_img_url" alt="ProfileImage"/></figure>
                            <div class="card-body w-2/3">
                                <h2 class="card-title">Antonio Variações</h2>
                                <p>Médico</p>
                                <div class="card-actions justify-end">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card lg:card-side bg-base-100 shadow-xl">
                            <figure><img :src="profile_img_url" alt="ProfileImage"/></figure>
                            <div class="card-body w-2/3">
                                <h2 class="card-title">Antonio Mendes</h2>
                                <p>Médico</p>
                                <div class="card-actions justify-end">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card lg:card-side bg-base-100 shadow-xl">
                            <figure><img :src="profile_img_url" alt="ProfileImage"/></figure>
                            <div class="card-body w-2/3">
                                <h2 class="card-title">Joaquim culatra</h2>
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
    };
  },
  created() {
        this.fetchMessages();

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
      axios.post('/messages2', message).then(response => {
        console.log(response.data);
      })
      this.fetchMessages();
    },
    sendMessage() {
      this.addMessage(message);
    }
  }
};
</script>