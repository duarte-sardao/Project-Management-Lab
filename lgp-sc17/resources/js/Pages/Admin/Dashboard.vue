<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import {Link} from '@inertiajs/vue3';
import moment from "moment";

const props = defineProps({
    users: {
        default: []
    },
    library_posts: {
        default: []
    },
    forum_posts: {
        default: []
    },
});
</script>

<template>
    <AdministrationLayout page="dashboard">
        <div class="py-6 bg-[#E9EFFD] w-full flex flex-col mb-6">
            <div class="flex justify-center text-4xl font-bold py-4">{{ $t('users') }}</div>
            <div class="overflow-x-auto mx-8">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th class="w-5/12">{{ $t('users') }}</th>
                        <th class="w-2/12">{{ $t('status') }}</th>
                        <th class="w-2/12 text-center">{{ $t('confirmation') }}</th>
                        <th class="w-2/12 text-center">{{ $t('blockUser') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--tr v-for="post in results.data">
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
                    </tr-->
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center pt-6">
                <Link :href="route('admin.users')" class="btn btn-wide hover:bg-lightBlue bg-mainBlue text-white border-0 rounded-full">
                    {{ $t('seeMore') }}</Link>
            </div>
        </div>
        <div id="grid" class="w-full grid grid-cols-2">
            <div id="library-posts" class="flex py-6 flex-col mr-4 justify-center bg-[#E9EFFD] w-full">
                <div class="flex justify-center text-4xl font-bold py-4">{{ $t('library') }}</div>
                <div class="overflow-x-auto mx-8">
                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th class="p-0"></th>
                            <th class="w-8/12">{{ $t('title') }}</th>
                            <th class="w-4/12 text-center">{{ $t('date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="library_post in library_posts">
                            <td class="p-0"></td>
                            <td class="w-[20px] break-words">{{ library_post.title }}</td>
                            <td class="text-center">{{ moment(library_post.created_at).format('DD-MM-YYYY HH:mm:ss') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center pt-6">
                    <Link :href="route('admin.library')" class="btn btn-wide hover:bg-lightBlue bg-mainBlue text-white border-0 rounded-full">
                        {{ $t('seeMore') }}</Link>
                </div>
            </div>
            <div id="forum-posts" class="flex py-6 flex-col ml-4 bg-[#E9EFFD]">
                <div class="flex justify-center text-4xl font-bold py-4">Forum</div>
                <div class="overflow-x-auto mx-8">
                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th class="p-0"></th>
                            <th class="w-8/12">{{ $t('title') }}</th>
                            <th class="w-4/12 text-center">{{ $t('date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="forum_post in forum_posts">
                            <td class="p-0"></td>
                            <td class="w-[20px] break-words">{{ forum_post.title }}</td>
                            <td class="text-center">{{ moment(forum_post.created_at).format('DD-MM-YYYY HH:mm:ss') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center pt-6">
                    <Link :href="route('admin.forum')" class="btn btn-wide hover:bg-lightBlue bg-mainBlue text-white border-0 rounded-full">
                        {{ $t('seeMore') }}</Link>
                </div>
            </div>
        </div>
    </AdministrationLayout>
</template>

<style scoped>
@media all and (max-width: 1300px) {
    #grid{
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
    #library-posts {
        margin: 0 0 1.5rem 0;
    }
    #forum-posts {
        margin: 0 0 1.5rem 0;
    }
}
</style>
