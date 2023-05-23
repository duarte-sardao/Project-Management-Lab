<script setup>
import moment from "moment";
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import SearchAdmin from "@/Components/Admin/SearchAdmin.vue";
import {ref} from "vue";
import MessageToast from "@/Components/MessageToast.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import axios from "axios";
import InputError from "@/Components/InputError.vue";
import { TailwindPagination } from 'laravel-vue-pagination';

const props = defineProps({
    hospitals: { default: null }
});

const displayToast = ref(false);
function cleanToast() {
    usePage().props.flash.success_message = null;
    usePage().props.flash.error_message = null;
    displayToast.value = false;
}
let results = ref(props.hospitals);

const search = ref('');
const getResults = async (page = 1) => {
    axios.get('/api/admin/hospitals?page=' + page + '&search=' + search.value)
        .then(response => {
            results.value = response.data;
        })
}

const deleteForm = useForm({});
const deleteHospital = (id) => {
    deleteForm.delete(route('admin.hospitals.delete', { id:id }), {
        onFinish () {
            results.value = null;
            results = ref(props.hospitals);
            displayToast.value = true;
            setTimeout(cleanToast, 3000);
        }
    });
}

const createForm = useForm({
    name: ''
});
const createHospital = (id) => {
    createForm.post(route('admin.hospitals.create', { id:id }), {
        onFinish () {
            results.value = null;
            results = ref(props.hospitals);
            displayToast.value = true;
            setTimeout(cleanToast, 3000);
        }
    });
}
</script>

<template>
    <AdministrationLayout page="hospitals">
        <MessageToast
            v-if="displayToast"
            :message="$page.props.flash.success_message === undefined ? '':$t(`${$page.props.flash.success_message}`)"
            :error="$page.props.flash.error_message === undefined ? '':$t(`${$page.props.flash.error_message}`)"
        ></MessageToast>

        <!--DeleteModal
            :message="isDeletePost ? 'deletePostModal':'deleteTopicModal'"
            :deleteButton="isDeletePost ? 'deletePostButton':'deleteTopicButton'"
            :close="confirmingPostDeletion"
            v-on:update:close="confirmingPostDeletion = $event"
            @deleteAction="isDeletePost ? deletePost() : deleteTopic()"
        /-->

        <div class="grid grid-cols-12">
            <div class="col-span-8 mr-3">
                <div class="grid grid-cols-2">
                    <div class="text-xl text-gray-400">
                        <div class="text-4xl text-black mb-2">{{ $t('hospitalsContent') }}</div>
                        {{ $t('hospitalsContentHint') }}
                    </div>
                    <div>
                        <SearchAdmin v-model="search" @submit="getResults"></SearchAdmin>
                    </div>
                </div>

                <div v-if="hospitals" class="overflow-x-auto">
                    <table class="table w-full my-10">
                        <thead>
                        <tr>
                            <th class="p-0"></th>
                            <th class="w-5/12 bg-transparent text-black text-sm">{{ $t('name') }}</th>
                            <th class="w-4/12 bg-transparent text-black text-sm text-center">{{ $t('date') }}</th>
                            <th class="w-3/12 bg-transparent text-black text-sm text-center">{{ $t('delete') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="hospital in results.data" class="border-b-2 border-[#F2F2F2]">
                            <td class="p-0"></td>
                            <td class="bg-transparent text-[#808080]">{{ hospital.name }}</td>
                            <td class="bg-transparent text-[#808080] text-center">
                                {{ moment(hospital.created_at).format('DD-MM-YYYY HH:mm:ss') }}
                            </td>
                            <td class="bg-transparent text-[#808080] text-center">
                                <form @submit.prevent="deleteHospital(hospital.id)">
                                    <div id="end_opt" class="flex justify-center">
                                        <button class="" type="submit">
                                            <img src="/svg_icons/trash.svg" alt="delete">
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
                            :data="results"
                            @pagination-change-page="getResults"
                        />
                    </div>
                </div>
                <div v-else class="my-[10vh] text-center text-lg">
                    {{ $t("noForumPostsToDisplay") }}
                </div>
            </div>
            <div class="ml-3 col-span-4">
                <div class="bg-[#F6F9FD] rounded-xl pt-[4vh] px-4">
                    <div class="text-center text-4xl text-[#4C4C4C] font-bold">Hospital</div>
                    <form @submit.prevent="createHospital">
                        <div class="form-control w-full pt-6">
                            <label class="label"><span class="label-text font-bold">{{ $t('name') }}</span></label>
                            <input v-model="createForm.name" type="text" placeholder="Add title" class="input input-bordered w-full max-w" />
                            <InputError class="mt-2" :message="createForm.errors.name" />
                        </div>

                        <div class="pb-4 flex justify-center pt-6">
                            <button type="submit" class="text-center px-6 py-3 text-lg bg-mainBlue text-white border-0 rounded-xl">{{ $t('hospitalCreate') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdministrationLayout>
</template>
