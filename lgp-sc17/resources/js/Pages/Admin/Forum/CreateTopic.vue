<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import InputLabel from '@/Components/InputLabel.vue';
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    topic: {
        type: Object,
        default: null,
    }
});

const edit = ref(props.topic != null);

const form = useForm({
    topic: edit.value ? props.topic.topic:'',
    color: edit.value ? props.topic.color:'#6590D5',
});

const topicError = ref(false);
let topicErrorString = 'topicError';
const colorError = ref(false);
const submit = () => {
    if (form.topic.trim() == '') {
        topicError.value = true;
        topicErrorString = 'topicError';
        return;
    } else if (topicError.value) {
        topicError.value = false;
    }

    const errorFuntion = (err) => {
        if (err.topic) {
            topicError.value = true;
            topicErrorString = err.topic;
        } else {
            colorError.value = true;
        }
    };

    if (edit.value) {
        form.put(route('topic.update', { id: props.topic.id }), {
            onError: errorFuntion,
        })
    } else {
        form.post(route('topic.create'), {
            onError: errorFuntion,
        });
    }
};

</script>

<template>
    <Head><title>{{ $t(edit ? 'editTopicTitle':'newTopicTitle') }}</title></Head>
    <div class="relative" style="z-index: 1">
        <NavBarSimple></NavBarSimple>
    </div>

    <div id="forum-new-post" class="grid px-[10vw] mt-[4vh] mb-[8vh]">
        <div class="grid grid-flow-col pb-3 border-b-[2px] border-[#221F1C]/[.21] text-black text-2xl font-bold">
            <span class="inline-block self-center">{{ $t(edit ? 'editTopic':'createTopic') }}</span>
            <Link :href="route('admin.forum')" class="inline-block justify-self-end py-2 px-14 shadow-md border-[#244D89] rounded-3xl border-2 text-lg font-black text-[#244D89] hover:bg-gray-200">
                {{ $t("goBack") }}
            </Link>
        </div>
        <form @submit.prevent="submit" class="relative grid mt-[6vh] tracking-wide border-b-[2px] border-[#221F1C]/[.21]">
            <input
                id="topic"
                type="text"
                class="rounded-3xl border-none bg-[#E9EFFD] w-[100%] px-4 text-lg text-black"
                :placeholder="$t('addTopicName')"
                v-model="form.topic"
            />
            <div class="absolute right-[10px] top-[10px]" :class="form.topic.length > 32 && 'text-red-600'">
                ({{ form.topic.length }}/32)
            </div>
            <InputError :message="topicError ?  $t(topicErrorString):''" />

            <div class="mt-[3vh]">
                <div class="flex">
                    <InputLabel class="inline" for="color" :value="$t('pickColor')" />
                    <input type="color" id="color" v-model="form.color" class="bg-transparent ml-[1vw] self-center hover:cursor-pointer"/>
                </div>
                <InputError :message="colorError ?  $t('colorError'):''" />
            </div>
            <button type="submit" class="shadow-md shadow-black/[.25] justify-self-end mt-[2vh] mb-[6vh] bg-[#578AD6] px-20 py-3 text-xl text-white font-bold rounded-3xl hover:brightness-90">
                {{ $t(edit ? 'edit':'submitTopic') }}
            </button>
        </form>
    </div>
    <div class="relative" style="z-index: 1">
        <Footer></Footer>
    </div>
</template>
