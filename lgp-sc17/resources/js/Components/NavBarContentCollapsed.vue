<script setup>
import {Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";

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
    <div class="ml-auto gap-2">
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-mainBlue" width="30" height="30" viewBox="0 0 96 96" id="menu"><switch><g><path d="M12 28h72a4 4 0 0 0 0-8H12a4 4 0 0 0 0 8zm72 16H12a4 4 0 0 0 0 8h72a4 4 0 0 0 0-8zm0 24H12a4 4 0 0 0 0 8h72a4 4 0 0 0 0-8z"></path></g></switch></svg>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                <li class="my-2">
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('homepage')">Home</Link>
                </li>
                <li class="my-2">
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('library')">Library</Link>
                </li>
                <li class="my-2">
                    <Link class="btn btn-ghost text-gray-600 normal-case text-xl rounded-full" :href="route('about')">About Us</Link>
                </li>
                <li class="my-2">
                    <Link :href="route('login')" class="btn bg-lightBlue text-gray-600 hover:bg-mainBlue hover:text-gray-200 border-0 normal-case text-xl rounded-full">Log in</Link>
                </li>
                <li>
                    <form class="p-0 my-2" @submit.prevent="submit">
                        <div class="relative">
                            <TextInput
                                id="search"
                                type="search"
                                class="input block w-full text-sm text-gray-900 input-bordered border-mainBlue rounded-full"
                                v-model="form.search"
                                placeholder="Search"
                                required
                                autocomplete="search"
                            />
                            <button type="submit" class="text-white absolute right-2.5 bottom-3.5 font-medium "><svg aria-hidden="true" class="w-5 h-5 text-mainBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "NavBarContentCollapsed"
}
</script>

<style scoped>

</style>
