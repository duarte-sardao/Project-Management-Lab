<script setup>
import TinyMCEditor from "@/Components/TinyMCE/TinyMCEditor.vue";
import { useForm } from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    title: { default: '' },
    subtitle: { default: '' },
    content: { default: '' },
    public: { default: true },
    route_name: { required: true },
    route_id: { default: null }
});

const form = useForm({
    title: props.title,
    subtitle: props.subtitle,
    body_content: props.content,
    public: props.public !== 0,
});

const submit = () => {
    if (!props.route_id === null) {
        form.post(route(props.route_name));
    } else {
        form.post(route(props.route_name, { id:props.route_id }));
    }
};

const deleteForm = useForm({});
const deletePost = () => {
    if (props.route_id !== null) {
        console.log("asd");
        deleteForm.delete(route(props.route_name, { id:props.route_id }));
    }
}

</script>

<template>
    <form @submit.prevent="submit">
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-bold">{{ $t('title') }}</span></label>
            <input v-model="form.title" type="text" placeholder="Add title" class="input input-bordered w-full max-w" />
            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text font-bold">{{ $t('subtitle') }}</span></label>
            <textarea v-model="form.subtitle" class="textarea textarea-bordered" placeholder="Add subtitle"></textarea>
            <InputError class="mt-2" :message="form.errors.subtitle" />
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text font-bold">{{ $t('body') }}</span></label>
            <TinyMCEditor :content="form.body_content" @update="(newContent) => form.body_content = newContent"/>
            <InputError class="mt-2" :message="form.errors.body_content" />
        </div>

        <div v-if="route_id === null" id="options" class="grid grid-cols-2 px-4">
            <div id="start_opt" class="flex justify-start">
                <div  class="form-control pt-8 w-fit">
                    <label class="label cursor-pointer">
                        <span class="label-text font-bold">{{ $t('public') }}&nbsp;&nbsp;</span>
                        <input type="checkbox" v-model="form.public" :checked="form.public" class="checkbox checkbox-lg checkbox-success focus:ring-transparent" />
                    </label>
                </div>
            </div>
            <div id="end_opt" class="flex justify-end pt-8">
                <button class="btn btn-success border-0" type="submit">{{ $t('save') }}</button>
            </div>
        </div>
        <div v-else id="options" class="grid grid-cols-3 px-4">
            <div id="start_opt" class="flex justify-start">
                <div  class="form-control pt-8 w-fit">
                    <label class="label cursor-pointer">
                        <span class="label-text font-bold">{{ $t('public') }}&nbsp;&nbsp;</span>
                        <input type="checkbox" v-model="form.public" :checked="form.public" class="checkbox checkbox-lg checkbox-success focus:ring-transparent" />
                    </label>
                </div>
            </div>
            <div class="flex justify-center pt-8">
                <button class="btn btn-success border-0" type="submit">{{ $t('save') }}</button>
            </div>
            <form @submit.prevent="deletePost">
                <div id="end_opt" class="flex justify-end pt-8">
                    <button class="btn btn-error border-0" type="submit">{{ $t('delete') }}</button>
                </div>
            </form>
        </div>
    </form>
</template>

<script>
export default {
    name: "AdminPostContent"
}
</script>

<style scoped>
@media all and (max-width: 500px) {
    #options {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
    #start_opt {
        justify-content: center;
    }
    #end_opt {
        justify-content: center;
    }
}
</style>
