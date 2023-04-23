<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import ForumAnswer from "@/Components/ForumAnswer.vue";
import TopicTag from "@/Components/TopicTag.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    credential: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const post = {
    title: 'Lorem ipsum dolor sitndum, elit non ultricies',
    content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.',
    topics: [
        { topic: 'Topic1', color: '#FF0000', selected:true, follows:false },
        { topic: 'Topic2', color: '#00FF00', selected:false, follows:true },
        { topic: 'Topic3', color: '#0000FF', selected:false, follows:false },
        { topic: 'Topic4', color: '#FF00FF', selected:false, follows:false },
    ],
    date: '5 days ago',
    user: {
        name: 'Name/Nickname',
        img: '/default-user-image.png',
    },
    likes: 0,
    userLikes: false,
    answers: [
        {
            date:'3 days ago',
            user: {img: '/default-user-image.png', username: 'Name/Nickname', role:'MedicalStaff'},
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.',
            likes: 10,
            userLikes: false,
        },
        {
            date:'3 days ago',
            user: {img: '/default-user-image.png', username: 'Name/Nickname', role:'Patient'},
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.',
            likes: 10,
            userLikes: true,
        },
    ],
};

const currentTopic = ref(0);
const topicTagHandler = (index) => {
    post.topics[currentTopic.value].selected = false;
    currentTopic.value = index;
    post.topics[currentTopic.value].selected = true;
}

const changeFollowButton = ref(false);
const followHandler = () => {
    post.topics[currentTopic.value].follows = !post.topics[currentTopic.value].follows;
    changeFollowButton.value = !changeFollowButton.value;
}

const changeLikeButton = ref(post.userLikes);
const likeHandler = () => {
    if (post.userLikes) {
        post.likes -= 1;
        post.userLikes = false;
        changeLikeButton.value = false;
        return;
    }
    post.likes += 1;
    post.userLikes = true;
    changeLikeButton.value = true;
}


const likeAnswer = (index, n) => {
    console.log("here");
    post.answers[index].likes += n;
    post.answers[index].userLikes = !post.answers[index].userLikes;
}

</script>

<template>
    <Head><title>Post</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="forum-post" class="grid px-[10vw] mb-[20vh]">
        <div class="grid mt-[4vh]">
            <button class="justify-self-end py-2 px-14 shadow-md border-[#244D89] rounded-3xl border-2 text-lg font-black text-[#244D89]">Back to forum</button>
        </div>
        <div id="post-grid" class="relative bg-[#E9EFFD] shadow-md px-[5vw] mt-[8vh] mb-[10vh]" style="border-radius: 2.5rem">
            <div class="absolute w-[70vw] top-[-4vh]">
                <TopicTag v-on:click="topicTagHandler(index)" :key="currentTopic" v-for="(item, index) in post.topics" :topic="item" :index="index"/>
            </div>
            <div id="post-title" class="mt-[7vh] text-[#1E1B18] font-bold text-4xl text-center">
                {{ post.title }}
            </div>
            <div class="grid grid-cols-6 max-h-[5rem] my-[4vh] max-w-[30vw]">
                <img 
                    id="author-image"
                    :src="post.user.img"
                    alt="author image"
                    class="rounded-full mix-blend-luminosity max-h-[5rem] cols-span-1"
                />
                <div class="flex flex-col items-start justify-center col-span-5 px-5">
                    <div class="text-xl font-bold text-[#221F1C]">{{ post.user.name }}</div>
                    <div class="text-xs font-bold text-[#767676]">{{ post.date }}</div>
                </div>
            </div>
            <div class="text-[#222222] py-[3vh] mb-[10vh] text-lg font-medium">
                {{ post.content }}
            </div>
            <div class="grid grid-cols-2 w-[50%] mb-[5vh]">
                <div>
                    <button :key="changeLikeButton" v-on:click="likeHandler" class="flex items-center text-[#E67A79] font-bold">
                        <img
                            :src="post.userLikes ? '/svg_icons/unlike.svg':'/svg_icons/like.svg'"
                            alt="favorite"
                            class="inline-block mr-2 max-h-[90%]"
                        />
                        {{ post.likes }} like{{ post.likes === 1 ? '':'s' }}
                    </button>
                </div>
                <div :key="currentTopic">
                    <button :key="changeFollowButton" v-on:click="followHandler" class="flex items-center text-[#C49960] font-bold">
                        <img
                            :src="post.topics[currentTopic].follows ? '/svg_icons/unfollow.svg':'/svg_icons/follow.svg'"
                            alt="favorite"
                            class="inline-block mr-2 max-h-[90%]"
                        />
                        {{post.topics[currentTopic].follows ? 'Unfollow the topic':'Follow the topic'}}
                    </button>
                </div>
            </div>
        </div>
        <div class="grid">
            <div class="pl-[2vw] text-xl font-bold text-[#222222] mb-4">Write an answer</div>
            <textarea
                type="text"
                id="answer-textarea"
                class="rounded-3xl border-[#E9EFFD] h-[20vh] w-[100%] break-words resize-none py-3 px-4"
            />
            <button class="justify-self-end	mt-[4vh] py-2 px-12 bg-[#578AD6] rounded-3xl text-white font-bold text-lg">Submit</button>
        </div>
        <div class="mt-[8vh]">
            <div class="border-b-[1px] border-[#221F1C]/[.21] pl-[4vw] pb-2 text-black font-bold text-xl">
                {{ post.answers.length }} {{ post.answers.length === 1 ? 'answer':'answers' }}
            </div>
            <ForumAnswer v-for="(answer, index) in post.answers" @clickHandler="(n) => likeAnswer(index, n)" :answer="answer" />
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