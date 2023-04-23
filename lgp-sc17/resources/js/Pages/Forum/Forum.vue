<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import ForumPost from "@/Components/ForumPost.vue";

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
    title: 'Lorem ipsum dolor sit amet',
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
        img: 'default-user-image.png',
    },
    likes: 0,
    userLikes: false,
    answers: [
        {
            date:'3 days ago',
            user: {img: 'default-user-image.png', username: 'Name/Nickname', role:'MedicalStaff'},
            content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet magna aliquam eleifend. In eget sodales massa. Nulla bibendum, elit non ultricies vulputate, purus mauris molestie enim, ac dictum massa leo ultricies justo.',
            likes: 10,
            userLikes: false,
        },
        {
            date:'3 days ago',
            user: {img: 'default-user-image.png', username: 'Name/Nickname', role:'Patient'},
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

    <div id="forum-post" class="grid px-[7vw] mb-[20vh]">
        <div class="grid  grid-cols-2 mt-[8vh] mb-[12.5vh]">
            <button class="inline-block justify-self-start py-2 w-[45%] shadow-md bg-[#B9CEED] rounded-3xl text-lg font-black text-[#222222]">Latest First</button>
            <button class="inline-block justify-self-end py-2 w-[45%] shadow-md bg-[#578AD6] rounded-3xl text-lg font-black text-[#FFF]">Start a new discussion</button>
        </div>
        <div class="grid grid-cols-10">
            <div class="relative col-span-8">
                <ForumPost />
                <ForumPost />
                <ForumPost />
                <div class="h-[100%] border-[#221F1C]/[.42] border-2 rounded-3xl inline-block absolute right-0 top-0"></div>
            </div>
            <div class="col-span-2 pl-[4vw]">
                <div>
                    <button>
                        <img src="/svg_icons/all_discussions.svg" alt="All discussions" class="inline-block align-middle max-h-[2.5rem]"/>
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]">All discussions</div>  
                    </button>
                    <button class="mt-[2vh]">
                        <img src="/svg_icons/following_discussions.svg" alt="All discussions" class="inline-block align-middle max-h-[2rem]"/>
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]">Following</div>  
                    </button>
                    <button class="mt-[2vh]">
                        <img src="/svg_icons/my_discussions.svg" alt="All discussions" class="inline-block align-middle max-h-[2.5rem]"/>
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]">My discussions</div>  
                    </button>
                    <div class="mt-[6vh] border-2 border-[#221F1C]/[.42] w-[75%] mr-auto ml-auto"></div>
                </div>
            </div>
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