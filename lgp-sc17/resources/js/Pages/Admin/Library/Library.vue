<script setup>
import moment from "moment";
import { TailwindPagination } from 'laravel-vue-pagination';
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import SearchAdmin from "@/Components/Admin/SearchAdmin.vue";
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {ref} from "vue";
import axios from "axios";
import MessageToast from "@/Components/MessageToast.vue";
import DeleteModal from "@/Components/DeleteModal.vue";

const props = defineProps(['posts'])
let results = ref(props.posts);

const deleteForm = useForm({});
const deletePost = (id) => {
    deleteForm.delete(route('admin.library.post', { id:confirmingPostDeletion.id }), {
        onFinish () {
            // force update of results
            results.value = null;
            results = ref(props.posts);
            confirmingPostDeletion.value = false;
            displayToast.value = true;
            setTimeout(cleanToast, 3000);
        }
    });
}

const search = ref('');
const getResults = async (page = 1) => {
    axios.get('/api/admin/library?page=' + page + '&search=' + search.value)
        .then(response => {
            results.value = response.data;
        })
}

const displayToast = ref(false);
function cleanToast() {
    displayToast.value = false;
    usePage().props.flash.success_message = undefined;
    usePage().props.flash.error_message = undefined;
}

if (usePage().props.flash.success_message || usePage().props.flash.error_message) {
    displayToast.value = true;
    setTimeout(cleanToast, 3000);
}

const confirmingPostDeletion = ref(false);
const confirmPostDeletion = (id) => {
    confirmingPostDeletion.value = true;
    confirmingPostDeletion.id = id;
};
</script>

<template>
    <MessageToast
        v-if="displayToast"
        :message="$page.props.flash.success_message === undefined ? undefined:$t(`${$page.props.flash.success_message}`)"
        :error="$page.props.flash.error_message === undefined ? undefined:$t(`${$page.props.flash.error_message}`)"
    ></MessageToast>

    <DeleteModal
        message="deleteLibraryPost"
        deleteButton="deleteLibraryPostButton"
        :close="confirmingPostDeletion"
        v-on:update:close="confirmingPostDeletion = $event"
        @deleteAction="deletePost"
    />

    <AdministrationLayout page="library">
        <div class="grid grid-cols-2">
            <div class="pb-16 text-xl text-gray-400">
                <div class="text-4xl text-black">{{ $t('libraryContent') }}</div>
                {{ $t('libraryContentHint') }}
            </div>
            <div>
                <SearchAdmin v-model="search" @submit="getResults"></SearchAdmin>
            </div>
        </div>
        <div class="pb-4 flex justify-center">
            <Link :href="route('admin.library.create')" class="btn btn-wide hover:bg-lightBlue bg-mainBlue text-white border-0 rounded-full">
                {{ $t('libraryButtonCreate') }}</Link>
        </div>

        <div class="overflow-x-auto">
            <table v-if="results.data.length" class="table w-full my-8">
                <thead>
                    <tr>
                        <th class="p-0"></th>
                        <th class="w-5/12">{{ $t('title') }}</th>
                        <th class="w-3/12">{{ $t('date') }}</th>
                        <th class="w-2/12 text-center">{{ $t('state') }}</th>
                        <th class="w-1/12 text-center">{{ $t('edit') }}</th>
                        <th class="w-1/12 text-center">{{ $t('delete') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in results.data">
                        <td class="p-0"></td>
                        <td>{{ post.title }}</td>
                        <td>{{ moment(post.created_at).format('DD-MM-YYYY HH:mm:ss') }}</td>
                        <td class="text-center">{{ post.public ? $t('public') : $t('private') }}</td>
                        <td class="text-center">
                            <Link class="flex justify-center" :href="route('admin.library.post', {id: post.id})">
                                <img src="/svg_icons/pencil.svg" alt="our vision">
                            </Link>
                        </td>
                        <td class="text-center">
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
            <div v-else class="my-[10vh] text-center text-gray-400 text-lg">
                {{ $t("noLibraryPostsToDisplay") }}
            </div>
            <div class="flex justify-center">
                <TailwindPagination
                    :data="results"
                    @pagination-change-page="getResults"
                />
            </div>
        </div>
    </AdministrationLayout>
</template>

<script>
export default {
    name: "Library"
}
</script>

<style scoped>

</style>
