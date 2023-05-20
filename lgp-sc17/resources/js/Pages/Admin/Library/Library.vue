<script setup>
import moment from "moment";
import { TailwindPagination } from 'laravel-vue-pagination';
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import SearchAdmin from "@/Components/Admin/SearchAdmin.vue";
import {Link, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import axios from "axios";

const props = defineProps(['posts'])

const deleteForm = useForm({});
const deletePost = (id) => {
    deleteForm.delete(route('admin.library.post', { id:id }));
}

const results = ref(props.posts);
const search = ref('');
const getResults = async (page = 1) => {
    axios.get('/api/admin/library?page=' + page + '&search=' + search.value)
        .then(response => {
            results.value = response.data;
        })
}
</script>

<template>
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
            <Link :href="route('admin.library.new')" class="btn btn-wide hover:bg-lightBlue bg-mainBlue text-white border-0 rounded-full">
                {{ $t('libraryButtonCreate') }}</Link>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full my-8">
                <thead>
                    <tr>
                        <th class="w-5/12">{{ $t('title') }}</th>
                        <th class="w-3/12">{{ $t('date') }}</th>
                        <th class="w-2/12 text-center">{{ $t('state') }}</th>
                        <th class="w-1/12 text-center">{{ $t('edit') }}</th>
                        <th class="w-1/12 text-center">{{ $t('delete') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in results.data">
                        <td>{{ post.title }}</td>
                        <td>{{ moment(post.created_at).format('DD-MM-YYYY HH:mm:ss') }}</td>
                        <td class="text-center">{{ post.public ? $t('public') : $t('private') }}</td>
                        <td class="text-center">
                            <Link class="flex justify-center" :href="route('admin.library.post', {id: post.id})">
                                <img src="/svg_icons/pencil.svg" alt="our vision">
                            </Link>
                        </td>
                        <td class="text-center">
                            <form @submit.prevent="deletePost(post.id)">
                                <div id="end_opt" class="flex justify-center">
                                    <button class="" type="submit">
                                        <img src="/svg_icons/trash.svg" alt="our vision">
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
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
