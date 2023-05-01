<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import ForumPost from "@/Components/ForumPost.vue";

const props = defineProps({
    posts: Array,
    topics: Array,
    currentForum: Number,
    currentTopic: Number,
});

const form = useForm({
    search: '',
});

const submit = () => {
    form.get(route('forum.search'));
};

</script>

<template>
    <Head><title>Post</title></Head>
    <div class="relative h-[80vh]" style="z-index: 1">
        <div class="absolute top-0 left-0 h-[80vh] w-[100%] z-0" style="background: linear-gradient(243.54deg, #578AD6 -2.66%, rgba(87, 138, 214, 0) 112.25%);">
        </div>
        <img src="/svg_img/forum-polygons.svg" class="absolute top-0 left-0 z-0 max-h-[90vh]">
        <NavBarSimple class="relative z-10" style="background: transparent !important"></NavBarSimple>
        <div class="relative z-10 ml-[35%]">
            <div class="mt-[15vh] text-[#221F1C] text-6xl font-bold">Forum</div>
            <div class="mt-[2vh] text-[#221F1C]/[.9] w-[30vw] font-bold text-xl">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet
            </div>
            <form @submit.prevent="submit" class="relative mt-[3vh]">
                <input
                    id="forum_search"
                    class="relative z-10 py-[1vh] pl-6 pr-[4vw] bg-[#FFF]/[.63] border-2 border-[#244D89] rounded-3xl w-[40vw] text-[#000]/[.57] text-lg focus-visible:outline-none"
                    placeholder="Search in the forum"
                    v-model="form.search"
                />
                <div class="absolute top-0 left-[36.5vw] z-30 h-[100%]  border-[1px] border-[#244D89]"></div>
                <button type="submit" class="absolute top-[.85vh] left-[37vw] z-20 hover:scale-125 transition duration-300"><img src="/svg_icons/search.svg" /></button>
            </form>
        </div>
    </div>
    <div id="forum-post" class="grid pl-[7vw] pr-[4vw] mb-[20vh]">
        <div class="grid  grid-cols-2 mt-[8vh] mb-[12.5vh]">
            <button class="inline-block justify-self-start py-2 w-[45%] shadow-md bg-[#B9CEED] rounded-3xl text-lg font-black text-[#222222]">Latest First</button>
            <Link
                :href="route('forum.create')"
                class="inline-block justify-self-end py-2 w-[45%] shadow-md bg-[#578AD6] rounded-3xl text-lg font-black text-[#FFF] text-center hover:brightness-90"
            >
                Start a new discussion
            </Link>
        </div>
        <div class="grid grid-cols-10">
            <div class="relative col-span-8">
                <Link
                    v-if="props.posts.length"
                    v-for="post in props.posts"
                    :data="(props.currentTopic == null) ? {}:{'currentTopic':props.currentTopic}"
                    :href="route('forum.post', {id: post.id})"
                >
                    <ForumPost :data="post"/>
                </Link>
                <div v-else class="h-[100%] flex justify-center items-center text-2xl">There are no posts to display.</div>
                <div class="h-[100%] border-[#221F1C]/[.42] border-2 rounded-3xl inline-block absolute right-0 top-0"></div>
            </div>
            <div class="col-span-2 pl-[2vw]">
                <div class="px-[1vw]">
                    <Link :href="route('forum')" class="block hover:font-bold">
                        <img 
                            :src="props.currentForum === 0 ? `/svg_icons/all_discussions_selected.svg`:`/svg_icons/all_discussions.svg`"
                            alt="All discussions"
                            class="inline-block align-middle max-h-[2.5rem]"
                        />
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]" :class="props.currentForum === 0 ? 'text-[#578AD6]': 'text-[#6D6D6D]'">
                            All discussions
                        </div>  
                    </Link>
                    <Link :href="route('forum-following')" class="block mt-[4vh] hover:font-bold">
                        <img 
                            :src="props.currentForum === 1 ? '/svg_icons/following_discussions_selected.svg':'/svg_icons/following_discussions.svg'"
                            alt="Following discussions"
                            class="inline-block align-middle max-h-[2rem]"
                        />
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]" :class="props.currentForum === 1 ? 'text-[#578AD6]': 'text-[#6D6D6D]'">
                            Following
                        </div>  
                    </Link>
                    <Link :href="route('forum-my_discussions')" class="block mt-[4vh] hover:font-bold ">
                        <img
                            :src="props.currentForum === 2 ? '/svg_icons/my_discussions_selected.svg':'/svg_icons/my_discussions.svg'"
                            alt="My discussions"
                            class="inline-block align-middle max-h-[2.5rem]"
                        />
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]" :class="props.currentForum === 2 ? 'text-[#578AD6]': 'text-[#6D6D6D]'">
                            My discussions
                        </div>  
                    </Link>
                </div>
                <div class="mt-[6vh] border-2 border-[#221F1C]/[.42] w-[100%] rounded-3xl"></div>
                <div class="mt-[6vh] h-[100%] overflow-auto">
                    <Link v-for="topic in props.topics" :href="route('forum-topic_posts', {id:topic.id})" class="block mt-[3vh] ml-2 hover:pl-2">
                        <div
                            class="inline-block align-middle rounded-full w-[25px] h-[25px] mb-[3px] mr-2"
                            :style="`background: ${topic.color}; outline: 2px dashed ${props.currentTopic && (props.currentTopic == topic.id) ? '#578AD6':'transparent'};`">
                        </div>
                        <span class="ml-[1.25vw] text-lg font-bold" :class="(props.currentTopic && (props.currentTopic == topic.id)) ? 'text-[#578AD6]': 'text-[#6D6D6D]'">{{ topic.topic }}</span>
                    </Link>
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