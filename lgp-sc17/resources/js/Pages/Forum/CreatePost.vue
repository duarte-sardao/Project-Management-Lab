<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import TopicButton from "@/Components/TopicButton.vue";
import InputError from "@/Components/InputError.vue";

const topicsSelected = ref(0);
const topicsError = ref(false);

const props = defineProps({
    topics: Array
});

const clickTopic = (index) => {
    const selected = props.topics[index].selected;
    if (topicsSelected.value < 4 || selected) {
        topicsSelected.value += (selected) ? -1 : 1;
        props.topics[index].selected = !props.topics[index].selected;
        if (topicsError.value) topicsError.value = false;
    } else if (!topicsError.value) {
        topicsError.value = true;
    }
}

const form = useForm({
    title: '',
    content: '',
    topics: [],
})

const titleError = ref(false);
const contentError = ref(false);
const submit = () => {
    if (form.title.trim() == '') {
        titleError.value = true;
        contentError.value = false;
        return;
    } else if (titleError.value) {
        titleError.value = false;
    }

    if (form.content.trim() == '') {
        contentError.value = true;
        return;
    } else if (contentError.value) {
        contentError.value = false;
    }

    form.topics = topics.filter(t => t.selected);
    form.post(route('forum.create'));
};

</script>

<template>
    <Head><title>{{ $t("newPostTitle") }}</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="forum-new-post" class="grid px-[10vw] mt-[4vh] mb-[8vh]">
        <div class="grid grid-flow-col pb-3 border-b-[2px] border-[#221F1C]/[.21] text-black text-2xl font-bold">
            <span class="inline-block self-center">{{ $t("createAPost") }}</span>
            <Link :href="route('forum')" class="inline-block justify-self-end py-2 px-14 shadow-md border-[#244D89] rounded-3xl border-2 text-lg font-black text-[#244D89] hover:bg-gray-200">
                {{ $t("backToForum") }}
            </Link>
        </div>
        <form @submit.prevent="submit" class="grid mt-[6vh] tracking-wide border-b-[2px] border-[#221F1C]/[.21]">
            <input
                id="post-title"
                type="text"
                class="rounded-3xl border-none bg-[#E9EFFD] w-[100%] px-4 text-lg text-black"
                :placeholder="$t('addTitleOrQuestion')"
                v-model="form.title"
            />
            <InputError :message="titleError ?  $t('titleError'):''" />
            <textarea
                id="post-content"
                class="resize-none border-[#E9EFFD] w-[100%] h-[25vh] mt-[3vh] rounded-3xl py-2 px-4 text-lg text-black"
                :placeholder="$t('addText')"
                v-model="form.content"
            />
            <InputError :message="contentError ?  $t('contentError'):''" />
            <div class="mt-[3vh] pl-[2vw] h-[30vh]">
                <div :key="topicsSelected" class="text-[#6D6D6D] text-lg">
                    {{ $t("chooseTopics") }} ({{topicsSelected}}/4)
                </div>
                <div id="topics-area" class="max-h-[25vh] overflow-auto">
                    <TopicButton v-for="(topic, index) in topics" :topic="topic" :index="index" v-on:click="clickTopic(index)"/>
                </div>
                <InputError :message="topicsError ?  $t('numberOfTopicsError'):''" />
            </div>
            <button type="submit" class="shadow-md shadow-black/[.25] justify-self-end mt-[2vh] mb-[10vh] bg-[#578AD6] px-20 py-3 text-xl text-white font-bold rounded-3xl hover:brightness-90">
                {{ $t("submitPost") }}
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
