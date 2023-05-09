<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    search: '',
});
const submit = () => {
    /* form.post(route('search'), {
        onFinish: () => {},
    }); */
};
</script>

<template>
    <form class="p-0 my-2" @submit.prevent="submit">
        <div class="flex justify-center">
            <div id="library-search" class="relative w-[80%]">
                <input
                    id="search"
                    type="text"
                    class="input inline-block w-full text-sm text-gray-900 input-bordered border-mainBlue rounded-full"
                    v-model="form.search"
                    :placeholder="$t('search')"
                    required
                />
                <button type="submit" class="text-white absolute right-2.5 bottom-3.5 font-medium "><svg aria-hidden="true" class="w-5 h-5 text-mainBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "Search"
}
</script>

<style scoped>

</style>
