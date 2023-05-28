<script setup>
import TinyMCEditor from "@/Components/TinyMCE/TinyMCEditor.vue";
import {useForm, usePage} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import MessageToast from "@/Components/MessageToast.vue";
import {ref} from "vue";

const props = defineProps({
    title: { default: '' },
    subtitle: { default: '' },
    content: { default: '' },
    img_url: { default: '' },
    public: { default: true },
    route_name: { required: true },
    route_id: { default: null }
});

const form = useForm({
    title: props.title,
    subtitle: props.subtitle,
    body_content: props.content,
    public: props.public !== 0,
    img: null
});

const displayToast = ref(false);
function cleanToast() {
    displayToast.value = false;
    usePage().props.flash.success_message = undefined;
    usePage().props.flash.error_message = undefined;
}

const submit = () => {
    if (!props.route_id === null) {
        form.post(route(props.route_name), {
            onFinish () {
                displayToast.value = true;
                setTimeout(cleanToast, 3000);
            }
        });
    } else {
        form.post(route(props.route_name, { id:props.route_id }), {
            onFinish () {
                displayToast.value = true;
                setTimeout(cleanToast, 3000);
            }
        });
    }
};

const deleteForm = useForm({});
const deletePost = () => {
    if (props.route_id !== null) {
        deleteForm.delete(route(props.route_name, { id:props.route_id }));
    }
}

function inputFile(event) {
    form.img = event.target.files[0];
}

if (usePage().props.flash.success_message || usePage().props.flash.error_message) {
    displayToast.value = true;
    setTimeout(cleanToast, 3000);
}
</script>

<template>
    <MessageToast
        v-if="displayToast"
        :message="$page.props.flash.success_message === undefined ? undefined:$t(`${$page.props.flash.success_message}`)"
        :error="$page.props.flash.error_message === undefined ? undefined:$t(`${$page.props.flash.error_message}`)"
    ></MessageToast>

    <form @submit.prevent="submit">
        <div class="grid grid-cols-2">
            <div class="form-control w-full justify-center">
                <label class="label"><span class="label-text font-bold">{{ $t('postImage') }}</span></label>
                <input id="image-input" @change="inputFile" type="file" accept="image/*" class="file-input file-input-bordered w-full max-w-xs right-0 bottom-10" />
            </div>
            <div class="h-full flex justify-center items-center overflow-hidden">
                <img class="max-h-[150px]" :src="props.img_url === '' ? '/svg_img/default-post.jpg' : props.img_url" alt="Post image">
            </div>
        </div>

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
                        <input type="checkbox" v-model="form.public" :checked="form.public" class="checkbox checkbox-lg checkbox-success focus:ring-transparent hover:opacity-70" />
                    </label>
                </div>
            </div>
            <div class="flex justify-center pt-8">
                <button class="btn btn-success border-0 hover:opacity-70" type="submit">{{ $t('save') }}</button>
            </div>
            <form @submit.prevent="deletePost">
                <div id="end_opt" class="flex justify-end pt-8 hover:opacity-70">
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
