<script setup>
import TinyMCEditor from "@/Components/TinyMCE/TinyMCEditor.vue";
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    title: { default: 'asd' },
    subtitle: { default: 'asd' },
    content: { default: 'asd' },
    public: { default: false },
    route_name: { required: true }
});

const form = useForm({
    title: props.title,
    subtitle: props.subtitle,
    content: props.content,
    public: props.public,
});

const submit = () => {
    form.post(route(props.route_name), {});
};

function ola(value) {
    console.log(value) // someValue
}
</script>

<template>
    <form @submit.prevent="submit">
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-bold">{{ $t('title') }}</span></label>
            <input v-model="form.title" type="text" placeholder="Add title" class="input input-bordered w-full max-w" />
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text font-bold">{{ $t('subtitle') }}</span></label>
            <textarea v-model="form.subtitle" class="textarea textarea-bordered" placeholder="Add subtitle"></textarea>
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text font-bold">{{ $t('body') }}</span></label>
            <TinyMCEditor :content="form.content" @update="(newContent) => form.content = newContent"/>
        </div>

        <div class="grid grid-cols-2 pt-4 px-4">
            <div class="form-control">
                <label class="label cursor-pointer justify-start w-fit">
                    <span class="label-text font-bold">{{ $t('public') }}&nbsp;&nbsp;</span>
                    <input type="checkbox" :checked="form.public" class="checkbox checkbox-lg checkbox-success focus:ring-transparent" />
                </label>
            </div>
            <div class="flex justify-end">
                <button class="btn btn-success border-0" type="submit">{{ $t('save') }}</button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "AdminPostContent"
}
</script>

<style scoped>

</style>
