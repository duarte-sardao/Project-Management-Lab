<script setup>
import { TailwindPagination } from 'laravel-vue-pagination';
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import SearchAdmin from "@/Components/Admin/SearchAdmin.vue";
import { Link, Head } from '@inertiajs/vue3';
import {ref} from "vue";
import axios from "axios";

const props = defineProps(['users'])

const results = ref(props.users);
const search = ref('');
const getResults = async (page = 1) => {
    axios.get('/api/admin/users?page=' + page + '&search=' + search.value)
        .then(response => {
            results.value = response.data;
        })
}
getResults();
</script>

<template>
    <Head><title>{{ $t('adminUsersManagement') }}</title></Head>
    <AdministrationLayout page="users">
        <div class="grid grid-cols-2">
            <div class="pb-16 text-xl text-gray-400">
                <div class="text-4xl text-black">{{ $t('usersList') }}</div>
                {{ $t('usersListHint') }}
            </div>
            <div>
                <SearchAdmin v-model="search" @submit="getResults"></SearchAdmin>
            </div>
        </div>

        <div v-if="results.data.length" class="overflow-x-auto">
            <table class="table w-full my-8">
                <thead>
                    <tr>
                        <th class="p-0"></th>
                        <th class="w-5/12">Username</th>
                        <th class="w-4/12">{{ $t('fullName') }}</th>
                        <th class="w-2/12 text-center">{{ $t('accType') }}</th>
                        <th class="w-1/12 text-center">{{ $t('edit') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in results.data">
                        <td class="p-0"></td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.name}}</td>
                        <td class="text-center">{{ user.status == undefined ? '':$t(user.status.toLowerCase()) }}</td>
                        <td class="text-center">
                            <Link class="flex justify-center transition duration-200 hover:scale-125" :href="route('admin.users.info', {id: user.id})">
                                <img src="/svg_icons/pencil.svg" alt="edit">
                            </Link>
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
        <div v-else class="my-[10vh] text-center text-gray-400 text-lg">
            {{ $t("noUsersToDisplay") }}
        </div>
    </AdministrationLayout>
</template>

<script>
export default {
    name: "Users"
}
</script>

<style scoped>

</style>
