<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import ForumPost from "@/Components/ForumPost.vue";
import OrderPostsDropdown from "@/Components/OrderPostsDropdown.vue";
import Pagination from "@/Components/Pagination.vue";
import MessageToast from "@/Components/MessageToast.vue";

const props = defineProps({
    posts: Array,
    topics: Array,
    currentForum: Number,
    currentTopic: Number,
    order: String,
    lastPage: Number,
    currentPage: Number,
    search: {
        type: String,
        default: undefined,
    },
    message: {
        type: String,
        default: undefined,
    },
});

const displayToast = ref(false);
function cleanToast() {
    usePage().props.flash.success_message = null;
    usePage().props.flash.error_message = null;
    displayToast.value = false;
}
onMounted(() => {
    if (props.message != undefined) {
        displayToast.value = true;
        setTimeout(cleanToast, 3000);
    }
});

const form = useForm({
    search: props.search !== undefined ? props.search:'',
});

const submit = () => {
    form.get(route('forum.search'));
};

const onPageChange = ({ next_page = currentPage, order: order } = {}) => {
    let whichForum = '';
    const currentForm = useForm({
        page: next_page || props.currentPage,
        selected: order || props.order,
    });
    switch (props.currentForum) {
        case 1: whichForum = route('forum.search'); currentForm.search = form.search; break;
        case 0: whichForum = route('forum'); break;
        case 1: whichForum = route('forum-following'); break;
        case 1: whichForum = route('forum-my_discussions'); break;
        case undefined:
            if (props.curentTopic !== undefined) route('forum-topic_posts', { id: props.currentTopic });
    }
    currentForm.get(whichForum);
};

</script>

<template>
    <Head><title>{{ $t("forumTitle") }}</title></Head>
    <div class="relative h-[80vh]" style="z-index: 1">
        <div class="absolute top-0 left-0 h-[80vh] w-[100%] z-0" style="background: linear-gradient(243.54deg, #578AD6 -2.66%, rgba(87, 138, 214, 0) 112.25%);"></div>
        <div class="relative">
            <img src="/svg_img/forum-polygons.svg" class="absolute top-0 left-0 z-0 max-h-[90vh]">
            <NavBarSimple class="z-0" :background="false"></NavBarSimple>
            <div class="z-10 ml-[35%]">
                <div class="mt-[15vh] text-[#221F1C] text-black text-6xl font-bold">{{ $t("forumTitle") }}</div>
                <div class="mt-[2vh] text-[#221F1C]/[.9] w-[30vw] font-bold text-xl">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet
                </div>
                <form @submit.prevent="submit" class="relative mt-[3vh]">
                    <input
                        id="forum_search"
                        class="relative z-10 py-[1vh] pl-6 pr-[4vw] bg-[#FFF]/[.63] border-2 border-[#244D89] rounded-3xl w-[40vw] text-[#000]/[.57] text-lg focus-visible:outline-none"
                        :placeholder="$t('forumSearchPlaceholder')"
                        v-model="form.search"
                    />
                    <div class="absolute top-0 left-[36.5vw] z-30 h-[100%]  border-[1px] border-[#244D89]"></div>
                    <button type="submit" class="absolute top-[.85vh] left-[37vw] z-20 hover:scale-125 transition duration-300"><img src="/svg_icons/search.svg" /></button>
                </form>
            </div>
        </div>
    </div>

    <MessageToast
        v-if="displayToast"
        :message="$page.props.flash.success_message == undefined ? '':$t(`${$page.props.flash.success_message}`)"
        :error="$page.props.flash.error_message == undefined ? '':$t(`${$page.props.flash.error_message}`)"
    ></MessageToast>

    <div id="forum-post" class="grid pl-[7vw] pr-[4vw] mb-[20vh]">
        <div class="grid grid-cols-2 mt-[8vh] mb-[12.5vh]">
            <OrderPostsDropdown
                v-if="posts.length"
                :selected="order"
                :currentForum="currentForum"
                :currentTopic="currentTopic"
                @orderChanged="(value) => onPageChange({next_page:currentPage, order:value})"
            />
            <Link
                :href="route('forum.create')"
                class="inline-block justify-self-end py-3 w-[45%] shadow-md bg-[#578AD6] rounded-3xl text-lg font-black text-[#FFF] text-center hover:brightness-90"
                :class="!posts.length && 'col-span-2 w-[22.5%]'"
            >
                {{ $t("startNewDiscussionButton") }}
            </Link>
        </div>
        <div class="grid grid-cols-10">
            <div class="relative col-span-8">
                <Link
                    v-if="posts.length"
                    v-for="post in posts"
                    :data="(currentTopic == null) ? {}:{'currentTopic':currentTopic}"
                    :href="route('forum.post', {id: post.id})"
                >
                    <ForumPost :data="post"/>
                </Link>
                <div v-else class="h-[100%] flex justify-center items-center text-2xl">{{ $t("noForumPostsToDisplay") }}</div>
                <Pagination
                    v-if="posts.length"
                    class="flex w-[100%] justify-center mt-[10vh] pr-[7vw]"
                    :totalPages="lastPage"
                    :currentPage="currentPage"
                    @pageChanged="(value) => onPageChange({next_page:value, order:order})"
                />
                <div class="h-[100%] border-[#221F1C]/[.42] border-2 rounded-3xl inline-block absolute right-0 top-0"></div>
            </div>
            <div class="col-span-2 pl-[2vw]">
                <div class="px-[1vw]">
                    <Link :href="route('forum')" class="block hover:font-bold">
                        <img
                            :src="currentForum === 0 ? `/svg_icons/all_discussions_selected.svg`:`/svg_icons/all_discussions.svg`"
                            alt="All discussions"
                            class="inline-block align-middle max-h-[2.5rem]"
                        />
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]" :class="currentForum === 0 ? 'text-[#578AD6]': 'text-[#6D6D6D]'">
                            {{ $t("allDiscussions") }}
                        </div>
                    </Link>
                    <Link :href="route('forum-following')" class="block mt-[4vh] hover:font-bold">
                        <img
                            :src="currentForum === 1 ? '/svg_icons/following_discussions_selected.svg':'/svg_icons/following_discussions.svg'"
                            alt="Following discussions"
                            class="inline-block align-middle max-h-[2rem]"
                        />
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]" :class="currentForum === 1 ? 'text-[#578AD6]': 'text-[#6D6D6D]'">
                            {{ $t("followingDiscussions") }}
                        </div>
                    </Link>
                    <Link :href="route('forum-my_discussions')" class="block mt-[4vh] hover:font-bold ">
                        <img
                            :src="currentForum === 2 ? '/svg_icons/my_discussions_selected.svg':'/svg_icons/my_discussions.svg'"
                            alt="My discussions"
                            class="inline-block align-middle max-h-[2.5rem]"
                        />
                        <div class="inline-block text-xl text-[#578AD6] ml-[1vw]" :class="currentForum === 2 ? 'text-[#578AD6]': 'text-[#6D6D6D]'">
                            {{ $t("myDiscussions") }}
                        </div>
                    </Link>
                </div>
                <div class="mt-[6vh] border-2 border-[#221F1C]/[.42] w-[100%] rounded-3xl"></div>
                <div class="mt-[3vh] h-[100%] overflow-auto">
                    <Link v-for="topic in topics" :href="route('forum-topic_posts', {id:topic.id})" class="flex items-center mt-[3vh] ml-2 hover:pl-2">
                        <div
                            class="inline-block align-middle rounded-full w-[25px] min-w-[25px] h-[25px] min-h-[25px] mb-[3px] mr-2"
                            :style="`background: ${topic.color}; outline: 2px dashed ${currentTopic && (currentTopic == topic.id) ? '#578AD6':'transparent'};`">
                        </div>
                        <span class="ml-[1.25vw] text-lg font-bold" :class="(currentTopic && (currentTopic == topic.id)) ? 'text-[#578AD6]': 'text-[#6D6D6D]'">{{ topic.topic }}</span>
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
