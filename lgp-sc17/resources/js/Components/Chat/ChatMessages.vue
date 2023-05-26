<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import {ref} from "vue";


const user = usePage().props.auth.user;

const profile_img_url = ref(user.profile_img_url);
if (profile_img_url.value == null) {
    profile_img_url.value = '/svg_icons/profile.svg';
}
</script>
<template>
  <div class="overflow-auto h-[36rem]">
    <div v-for="message in messages" :key="message.id">
      <div v-if="message.user.id == user.id" class="chat chat-end">
        <div class="chat-image avatar">
          <div class="w-10 rounded-full">
            <img :src="profile_img_url" alt="ProfileImage"/>
          </div>
        </div>
        <div class="chat-header"> {{ message.user.name }} </div>
        <div class="chat-bubble bg-skyBlue shadow-xl text-black"> {{ message.message }} </div>
        <div class="chat-footer opacity-50">
          
          <time class="text-xs text-black opacity-50">{{ message.created_at }}</time>
        </div>
      </div>

      <div v-if="message.user.id != user.id" class="chat chat-start">
        <div class="chat-image avatar">
          <div class="w-10 rounded-full">
            <img v-if="message.user.profile_img_url == null" src="/svg_icons/profile.svg" alt="ProfileImage"/>
            <img v-if="message.user.profile_img_url == null" :src="profile_img_url" alt="ProfileImage"/>
          </div>
        </div>
        <div class="chat-header">{{ message.user.name }}</div>
        <div class="chat-bubble bg-stone shadow-xl text-black"> {{ message.message }} </div>
        <div class="chat-footer opacity-50">
          <time class="text-xs text-black opacity-50">{{ message.created_at }}</time>
        </div>
      </div>
    </div>
  </div>
</template> 
<script>
export default {
  props: ["messages", "user"],
};
</script>
