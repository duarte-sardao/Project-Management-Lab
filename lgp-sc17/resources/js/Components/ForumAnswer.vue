<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import DeleteModal from '@/Components/DeleteModal.vue';

const props = defineProps(['answer']);
const emit = defineEmits(['delete', 'clickHandler']);

let is_admin = (usePage().props.auth.user && usePage().props.auth.user.is_admin);

const componentKey = ref(props.answer.userLikes);

const forceRender = () => {
    componentKey.value = !componentKey.value;
};

const confirmingAnswerDeletion = ref(false);
const confirmAnswerDeletion = () => {
    confirmingAnswerDeletion.value = true;
};

const deleteAnswer = () => {
    confirmingAnswerDeletion.value = false;
    emit('delete')
};

let autorImage = props.answer.user.image;
if (autorImage == null) autorImage = '/svg_icons/profile.svg';

</script>

<template>
    <DeleteModal
        message="deleteAnswerModal"
        deleteButton="deleteAnswerButton"
        :close="confirmingAnswerDeletion"
        v-on:update:close="confirmingAnswerDeletion = $event"
        @deleteAction="deleteAnswer"
    />
    <div class="relative grid ml-[4vw] border-b-[1px] border-[#221F1C]/[.21]">
        <div class="grid grid-cols-6 max-h-[5rem] mt-[6vh] max-w-[30vw]">
            <img 
                id="author-image"
                :src="autorImage"
                alt="author image"
                class="rounded-full max-h-[5rem] max-w-[5rem] w-fit cols-span-1"
            />
            <div class="flex flex-col items-start justify-center col-span-5 px-5">
                <div class="text-xl font-bold text-[#221F1C]">
                    {{ answer.user.username }}
                    <img 
                        v-if="answer.user.role === 'MedicalStaff'" 
                        src="/svg_icons/medical_staff.svg"
                        alt="Medical staff"
                        class="inline max-h-[1rem] align-top pl-1"
                    />
                </div>
                <div class="text-xs font-bold text-[#767676]">
                    {{ $t(answer.elapsed_time.type, {quantity: answer.elapsed_time.quantity}) }}
                </div>
            </div>
        </div>
        <button
            :key="componentKey" @click="() =>{ emit('clickHandler', componentKey ? -1:1); forceRender(); }"
            class="absolute grid justify-items-center max-w-[4vw] w-[4vw] top-[10vh] right-[1.25vw] hover:font-bold hover:brightness-75"
        >
            <img :src="answer.userLikes ? '/svg_icons/unlike.svg':'/svg_icons/like.svg'" alt="Like" class="h-[2rem]"/>
            <div class="mt-2 text-[#E67A79] text-sm">{{ answer.likes }} {{ answer.likes === 1 ? 'Like' : 'Likes' }}</div>
        </button>
        <img
            v-if="answer.isAuthor || is_admin"
            alt="Delete answer"
            class="absolute max-w-[2.5vw] w-[2.5vw] min-w-[30px] top-[3vh] right-[2vw] transition duration-200 hover:scale-110 hover:cursor-pointer"
            src="/svg_icons/trash.svg"
            v-on:click="confirmAnswerDeletion"
        />
        <div class="text-[#222222] font-normal text-base mb-[10vh] mt-[3.25rem]">
            {{ answer.content }}
        </div>
    </div>
</template>
