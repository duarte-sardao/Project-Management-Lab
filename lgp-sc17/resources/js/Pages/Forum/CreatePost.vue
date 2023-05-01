<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import TopicButton from "@/Components/TopicButton.vue";
import InputError from "@/Components/InputError.vue";

const topicsSelected = ref(0);
const topicsError = ref('');

const clickTopic = (index) => {
    const selected = topics[index].selected;
    if (topicsSelected.value < 4 || selected) {
        topicsSelected.value += (selected) ? -1 : 1;
        topics[index].selected = !topics[index].selected;
        if (topicsError.value) topicsError.value = '';
    } else if (!topicsError.value) {
        topicsError.value = 'A post can only have up to 4 topics associated. Please remove any additional topics before trying to add a new one.';
    }
}

defineProps({
    canResetPassword: Boolean,
    status: String,
});


const form = useForm({
    title: '',
    content: '',
    topics: [],
})

const submit = () => {
    form.topics = topics.filter(t => t.selected);
    form.post(route('forum.create'));
};

const topics = [
    { color: '#000000', topic: 'Topic1', selected: false },
    { color: '#FFFF00', topic: 'Topic2', selected: false },
    { color: '#00FFFF', topic: 'Topic3', selected: false },
    { color: '#00FF00', topic: 'Topic4', selected: false },
    { color: '#0000FF', topic: 'Topic5', selected: false },
    { color: '#FF00FF', topic: 'Topic6', selected: false },
    { color: '#F0F0F0', topic: 'Topic7', selected: false },
    { color: '#0F0F0F', topic: 'Topic8', selected: false },
];

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
        <form @submit.prevent="submit" class="grid mt-[6vh] tracking-wide border-b-[2px] border-[#221F1C]/[.21]">
            <input
                id="post-title"
                type="text"
                class="rounded-3xl border-none bg-[#E9EFFD] w-[100%] px-4 text-lg text-black"
                placeholder="Add a title or question"
                v-model="form.title"
            />
            <textarea
                id="post-content"
                class="resize-none border-[#E9EFFD] w-[100%] h-[25vh] mt-[3vh] rounded-3xl py-2 px-4 text-lg text-black"
                placeholder="Add text"
                v-model="form.content"
            />
            <div class="mt-[3vh] pl-[2vw] h-[30vh]">
                <div :key="topicsSelected" class="text-[#6D6D6D] text-lg">
                    Choose one or more topics ({{topicsSelected}}/4)
                </div>
                <div id="topics-area" class="max-h-[25vh] overflow-auto">
                    <TopicButton v-for="(topic, index) in topics" :topic="topic" :index="index" v-on:click="clickTopic(index)"/>
                </div>
                <InputError :message="topicsError" />
            </div>
            <button type="submit" class="shadow-md shadow-black/[.25] justify-self-end mt-[3vh] mb-[10vh] bg-[#578AD6] px-20 py-3 text-xl text-white font-bold rounded-3xl hover:brightness-90">
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
