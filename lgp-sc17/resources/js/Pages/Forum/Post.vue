<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import ForumAnswer from "@/Components/ForumAnswer.vue";
import TopicTag from "@/Components/TopicTag.vue";
import OrderAnswersDropdown from '@/Components/OrderAnswersDropdown.vue';
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    post: Object,
    currentTopic: Number,
    order: String,
});

const form = useForm({
    content: '',
});

const answerError = ref(false);
const submit = () => {
    if (form.content == '') {
        answerError.value = true;
        return;
    }
    form.post(route('forum.answer', {id:props.post.id}), {
        onFinish () {
            form.content = '';
            if (answerError.value) answerError.value = false;
        }
    });
};

const changeLikeButton = ref(props.post.userLikes);
const likeHandler = () => {
    axios.post(route('forum.like-post', { id: props.post.id }), form)
        .then((res) => {
            props.post.userLikes = res.data.action == "like";
            props.post.likes = res.data.likes;
            changeLikeButton.value = res.data.action == "like";
        })
        .catch((err) => console.error(err));
}

const likeAnswer = (index) => {
    axios.post(route('forum.like-answer', { id: props.post.answers[index].id }), form)
        .then((res) => {
            props.post.answers[index].userLikes = res.data.action == "like";
            props.post.answers[index].likes = res.data.likes;
            changeLikeButton.value = res.data.action == "like";
        })
        .catch((err) => console.error(err));
}

const currentTopic = ref((props.currentTopic !== null ? props.currentTopic : 0));
const topicTagHandler = (index) => {
    props.post.topics[currentTopic.value].selected = false;
    currentTopic.value = index;
    props.post.topics[currentTopic.value].selected = true;
}

const changeFollowButton = ref(false);
const followHandler = () => {
    console.log(props.post.topics[currentTopic.value]);
    axios.post(route('forum.follow', { id: props.post.topics[currentTopic.value].topic_id }))
        .then((res) => {
            console.log(res.data.action);
            props.post.topics[currentTopic.value].userFollows = res.data.action == "follow";;
            changeFollowButton.value = !changeFollowButton.value;
        })
        .catch((err) => console.error(err));
};

</script>

<template>
    <Head><title>Post</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="forum-post" class="grid mx-[10vw] mb-[20vh]">
        <div class="grid mt-[4vh]">
            <Link :href="route('forum')" class="justify-self-end py-2 px-14 shadow-md border-[#244D89] rounded-3xl border-2 text-lg font-black text-[#244D89] hover:bg-gray-200">
                {{ $t("backToForum") }}
            </Link>
        </div>
        <div id="post-grid" class="relative bg-[#E9EFFD] shadow-md px-[5vw] mt-[8vh] mb-[10vh] max-w-[78.5vw]" style="border-radius: 2.5rem">
            <div v-if="props.post.topics.length > 0" class="absolute w-[70vw] top-[-4vh]">
                <TopicTag v-on:click="topicTagHandler(index)" :key="currentTopic" v-for="(item, index) in props.post.topics" :topic="item" :index="index"/>
            </div>
            <div id="post-title" class="mt-[7vh] text-[#1E1B18] font-bold text-4xl text-center">
                {{ props.post.title }}
            </div>
            <div class="grid grid-cols-6 max-h-[5rem] my-[4vh] max-w-[30vw]">
                <img 
                    id="author-image"
                    :src="props.post.author.image"
                    alt="author image"
                    class="rounded-full mix-blend-luminosity max-h-[5rem] cols-span-1"
                />
                <div class="flex flex-col items-start justify-center col-span-5 px-5">
                    <div class="text-xl font-bold text-[#221F1C]">{{ props.post.author.username }}</div>
                    <div class="text-xs font-bold text-[#767676]">
                        {{ $t(props.post.elspsed_time.type, {quantity: props.post.elspsed_time.quantity}) }}
                    </div>
                </div>
            </div>
            <div class="text-[#222222] py-[3vh] mb-[10vh] text-lg font-medium break-words">
                {{ props.post.content }}
            </div>
            <div class="grid grid-cols-2 w-[50%] mb-[5vh]">
                <div>
                    <button :key="changeLikeButton" v-on:click="likeHandler" class="flex items-center text-[#E67A79] font-bold hover:brightness-75">
                        <img
                            :src="props.post.userLikes ? '/svg_icons/unlike.svg':'/svg_icons/like.svg'"
                            alt="favorite"
                            class="inline-block mr-2 max-h-[90%]"
                        />
                        {{ props.post.likes }} Like{{ props.post.likes === 1 ? '':'s' }}
                    </button>
                </div>
                <div :key="currentTopic" v-if="props.post.topics.length > 0">
                    <button :key="changeFollowButton" v-on:click="followHandler" class="flex items-center text-[#C49960] font-bold hover:brightness-75">
                        <img
                            :src="props.post.topics[currentTopic].userFollows ? '/svg_icons/unfollow.svg':'/svg_icons/follow.svg'"
                            alt="favorite"
                            class="inline-block mr-2 max-h-[90%]"
                        />
                        {{props.post.topics[currentTopic].userFollows ? $t('unfollowTopic'):$t('followTopic')}}
                    </button>
                </div>
            </div>
        </div>
        <form @submit.prevent="submit" class="grid">
            <div class="pl-[2vw] text-xl font-bold text-[#222222] mb-4">{{ $t("writeAnswer") }}</div>
            <textarea
                type="text"
                id="answer-textarea"
                class="rounded-3xl border-[#E9EFFD] h-[20vh] w-[100%] break-words resize-none py-3 px-4"
                v-model="form.content"
            />
            <InputError class=" mt-2 pl-[2vw]" :message="answerError ? $t('answerError'):''" />
            <button class="justify-self-end	mt-[4vh] py-2 px-12 bg-[#578AD6] rounded-3xl text-white font-bold text-lg hover:brightness-90" type="submit">
                {{ $t("submit") }}
            </button>
        </form>
        <div class="mt-[8vh]">
            <div class="grid grid-flow-col border-b-[1px] border-[#221F1C]/[.21] pl-[4vw] pb-2 text-black font-bold text-xl">
                <span class="self-center justify-self-start">{{ props.post.answers.length }} {{ `${$t("answers")}${props.post.answers.length === 1 ? '':'s'}` }}</span>
                <OrderAnswersDropdown :selected="order" :post_id="post.id" class="justify-self-end"></OrderAnswersDropdown>
            </div>
            <ForumAnswer v-if="props.post.answers.length" v-for="(answer, index) in props.post.answers" @clickHandler="(n) => likeAnswer(index, n)" :answer="answer" />
            <div v-else class="h-[25vh] flex items-center justify-center text-2xl">{{ $t("noAnswers") }}</div>
        </div>
    </div>
    <div class="relative" style="z-index: 1">
        <Footer></Footer>
    </div>
</template>

<style>
#answer-textarea::-webkit-scrollbar {
    width: 6px;
    border-radius: 50px;
}

/* Track */
#answer-textarea::-webkit-scrollbar-track {
  background: none;
  border-radius: 10px;
  margin-top: 10px;
  margin-bottom:10px;
}

/* Handle */
#answer-textarea::-webkit-scrollbar-thumb {
  background: #cbcbcb;
  border-radius: 10px;
}

/* Handle on hover */
#answer-textarea::-webkit-scrollbar-thumb:hover {
  background: rgb(154, 153, 153);
}
</style>