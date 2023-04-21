<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import TopicButton from "@/Components/TopicButton.vue";

const clickTopic = (index) => {
    topics[index].selected = !topics[index].selected;
};

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    credential: '',
    password: '',
});



// const submit = () => {
//     form.post(route('login'), {
//         onFinish: () => form.reset('password'),
//     });
// };

const topics = [
    {color: '#000000', topic:'Topic', selected:false},
    {color: '#FFFF00', topic:'Topic', selected:false},
    {color: '#00FFFF', topic:'Topic', selected:false},
    {color: '#00FF00', topic:'Topic', selected:false},
    {color: '#0000FF', topic:'Topic', selected:false},
    {color: '#FF00FF', topic:'Topic', selected:false},
    {color: '#F0F0F0', topic:'Topic', selected:false},
    {color: '#0F0F0F', topic:'Topic', selected:false},
]
</script>

<template>
    <Head><title>Post</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="forum-new-post" class="grid px-[10vw] my-[8vh]">
        <div class="pb-3 border-b-[2px] border-[#221F1C]/[.21] text-black text-2xl font-bold">
            Create a post
        </div>
        <form class="grid mt-[6vh] tracking-wide border-b-[2px] border-[#221F1C]/[.21]">
            <input
                id="post-title"
                type="text"
                class="rounded-3xl border-none bg-[#E9EFFD] w-[100%] px-4 text-lg text-black"
                placeholder="Add a title or question"
            />
            <textarea
                id="post-content"
                class="resize-none border-[#E9EFFD] w-[100%] h-[25vh] mt-[3vh] rounded-3xl py-2 px-4 text-lg text-black"
                placeholder="Add text"
            />
            <div class="mt-[3vh] pl-[2vw]">
                <div class="text-[#6D6D6D] text-lg">Choose one or more topics</div>
                <div id="topics-area" class="max-h-[25vh] overflow-auto">
                    <TopicButton v-for="(topic, index) in topics" :topic="topic" :index="index" v-on:click="clickTopic(index)"/>
                </div>
            </div>
            <button class="shadow-md shadow-black/[.25] justify-self-end mt-[3vh] mb-[10vh] bg-[#578AD6] px-20 py-3 text-xl text-white font-bold rounded-3xl ">
                Post
            </button>
        </form>
    </div>
    <div class="relative" style="z-index: 1">
        <Footer></Footer>
    </div>
</template>

<style>
#post-content::-webkit-scrollbar,
#topics-area::-webkit-scrollbar {
    width: 6px;
    border-radius: 50px;
}

/* Track */
#post-content::-webkit-scrollbar-track,
#topics-area::-webkit-scrollbar-track {
  background: none;
  border-radius: 10px;
  margin-top: 20px;
  margin-bottom:20px;
}

/* Handle */
#post-content::-webkit-scrollbar-thumb,
#topics-area::-webkit-scrollbar-thumb {
  background: #cbcbcb;
  border-radius: 10px;
}

/* Handle on hover */
#post-content::-webkit-scrollbar-thumb:hover,
#topics-area::-webkit-scrollbar-thumb:hover {
  background: rgb(154, 153, 153);
}
</style>
