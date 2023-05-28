<script setup>
import { ref, onMounted } from 'vue';
import DeleteModal from '@/Components/DeleteModal.vue';
import MessageToast from "@/Components/MessageToast.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
import SearchAdmin from "@/Components/Admin/SearchAdmin.vue";
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";

const props = defineProps({
    topics: Array,
    posts: Object,
    message: {
        type: String,
        default: undefined,
    },
});

onMounted(() => {
    if (props.message != undefined) {
        displayToastAction();
    }
});

const isDeletePost = ref(undefined);
const confirmingPostDeletion = ref(false);
const currentDeletion = ref(undefined);
const confirmPostDeletion = (post_id) => {
    isDeletePost.value = true;
    currentDeletion.value = post_id;
    confirmingPostDeletion.value = true;
};

const confirmTopicDeletion = (topic_id) => {
    isDeletePost.value = false;
    currentDeletion.value = topic_id;
    confirmingPostDeletion.value = true;
};

const closeModal = () => {
    isDeletePost.value = undefined;
    confirmingPostDeletion.value = false;
    currentDeletion.value = undefined;
};

const displayToast = ref(false);
const messageToast = ref(null);
const toastError = ref(null);
function cleanToast() {
    usePage().props.flash.success_message = null;
    usePage().props.flash.error_message = null;
    displayToast.value = false;
    toastError.value = null;
    messageToast.value = null;
}
const displayToastAction = () => {
    if (toastError.value == null)
        messageToast.value = props.message;
    displayToast.value = true;
    setTimeout(cleanToast, 3000);
};

let postsToDisplay = ref(props.posts);

const deletePost = () => {
    const form = useForm({});
    form.delete(route('forum.post.delete', { id: currentDeletion.value }), {
        onFinish: () => {
            closeModal();
            displayToastAction();
            postsToDisplay = ref(props.posts);
        }
    });
};

const deleteTopic = () => {
    const form = useForm({});
    form.delete(route('topic.delete', { id: currentDeletion.value }), {
        onFinish: () => {
            closeModal();
            displayToastAction();
        },
    });
};

const search = ref('');
const getResults = async (page = 1) => {
    axios.get(route('admin.forum.search', { page: page, search: search.value }))
        .then(response => {
            postsToDisplay.value = response.data;
        })
        .catch((_error) => {
            toastError.value = "errorOccurred";
            displayToastAction();
        })
};

</script>

<template>
    <Head><title>{{ $t('forumAdministrationTitle') }}</title></Head>
    <AdministrationLayout page="forum">
        <MessageToast
            v-if="displayToast"
            :message="messageToast == null ? '':$t(`${messageToast}`)"
            :error="toastError == null ? '':$t(`${toastError}`)"
        />

        <DeleteModal
            :message="isDeletePost ? 'deletePostModal':'deleteTopicModal'"
            :deleteButton="isDeletePost ? 'deletePostButton':'deleteTopicButton'"
            :close="confirmingPostDeletion"
            v-on:update:close="confirmingPostDeletion = $event"
            @deleteAction="isDeletePost ? deletePost() : deleteTopic()"
        />
        <div class="grid grid-cols-12">
            <div class="col-span-9 mr-3">
                <div class="grid grid-cols-2">
                    <div class="text-xl text-gray-400">
                        <div class="text-4xl text-black mb-2">{{ $t('forumContent') }}</div>
                        {{ $t('forumContentHint') }}
                    </div>
                    <div>
                        <SearchAdmin v-model="search" @submit="getResults"></SearchAdmin>
                    </div>
                </div>

                <div v-if="postsToDisplay.data.length" class="overflow-x-auto">
                    <table class="table w-full my-10">
                        <thead>
                            <tr>
                                <th class="p-0 m-0"></th>
                                <th class="w-6/12 bg-transparent text-black text-sm">{{ $t('title') }}</th>
                                <th class="w-4/12 bg-transparent text-black text-sm">{{ $t('adminForumDateAdded') }}</th>
                                <th class="w-2/12 bg-transparent text-black text-sm text-center">{{ $t('adminForumDelete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in postsToDisplay.data" class="border-b-2 border-[#F2F2F2]">
                                <td class="p-0"></td>
                                <td class="bg-transparent text-[#808080]">{{ post.title }}</td>
                                <td class="bg-transparent text-[#808080] text-left">
                                    {{ post.date }}
                                </td>
                                <td class="bg-transparent text-[#808080] text-center">
                                    <form @submit.prevent="confirmPostDeletion(post.id)">
                                        <div id="end_opt" class="flex justify-center">
                                            <button class="transition duration-200 hover:scale-125" type="submit">
                                                <img src="/svg_icons/trash.svg" alt="Delete post">
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-center overflow-auto">
                        <TailwindPagination
                            :limit="1"
                            :data="postsToDisplay"
                            @pagination-change-page="getResults"
                        />
                    </div>
                </div>
                <div v-else class="my-[10vh] text-center text-lg">
                    {{ $t("noForumPostsToDisplay") }}
                </div>
            </div>
            <div class="ml-3 col-span-3">
                <div class="bg-[#F6F9FD] rounded-xl pt-[4vh]">
                    <div class="text-center text-4xl text-[#4C4C4C] font-bold">Topics</div>
                    <div class="overflow-x-auto">
                        <table v-if="topics.length" class="table w-full my-8 bg-transparent">
                            <tbody>
                                <tr v-for="topic in topics" class="border-b-2">
                                    <td class="w-6/12 bg-transparent text-center text-[#4C4C4C] text-lg whitespace-pre-wrap">{{ topic.topic }}</td>
                                    <td class="w-4/12 text-center bg-transparent">
                                        <div class="inline-block align-middle rounded-full border-1 w-[20px] h-[20px] mb-[3px] mr-2" :style="`background:${topic.color}`"></div>
                                    </td>
                                    <td class="w-1/12 text-center bg-transparent">
                                        <Link class="flex justify-center transition duration-200 hover:scale-125" :href="route('topic.edit', {id: topic.id})">
                                            <img class="min-w-[30px] max-h-[30px] h-[30px]" src="/svg_icons/pencil.svg" alt="edit">
                                        </Link>
                                    </td>
                                    <td class="w-1/12 text-center bg-transparent">
                                        <form @submit.prevent="confirmTopicDeletion(topic.id)">
                                            <div id="end_opt" class="flex justify-center">
                                                <button class="transition duration-200 hover:scale-125" type="submit">
                                                    <img src="/svg_icons/trash.svg" alt="Delete topic" class="min-w-[30px] max-h-[30px] h-[30px]">
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="my-8 text-center text-lg">
                            {{ $t("adminNoTopicsToDisplay") }}
                        </div>
                        <div class="pb-4 flex justify-center">
                            <Link :href="route('topic.new')" class="text-center px-6 py-3 text-lg bg-mainBlue text-white border-0 rounded-xl hover:bg-lightBlue">
                                {{ $t('adminTopicCreate') }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdministrationLayout>
</template>
