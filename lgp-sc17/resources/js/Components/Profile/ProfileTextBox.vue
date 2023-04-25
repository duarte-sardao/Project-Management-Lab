<script setup>
import InputError from '@/Components/InputError.vue';
import { onMounted, ref } from 'vue';
const props = defineProps({
    'edit': {
        type: Boolean,
        required: true
    },
    'inputType': {
        type: String,
        required: true,
    },
    'text': {
        type: String,
        required: true,
    },
    'isInput': {
        type: Boolean,
        required: true,
    },
    'modelValue': {
        type: String || Number,
        required: true,
    },
    'required': {
        type: Boolean,
        required: false,
        default: true,
    },
    'errors': {
        type: String,
        required: false,
        default: '',
    }
});
defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value != null && input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="mt-6">
        <label class="pl-5 text-lg text-black/[.57]">{{ text }}</label>
        <div v-if="isInput">
            <input
                :id="modelValue"
                :type="inputType"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                autofocus
                ref="input"
                :required="required"
                class="pb-1 focus-visible:outline-none rounded-full border-2 bg-transparent border-[#B9CEED] h-12 leading-9 pt-1 px-5 w-[30vw] text-gray-800 text-xl"
            />
        </div>
        <div
            v-else
            class="rounded-full border-2 border-[#B9CEED] h-12 leading-9 pt-1 px-5 w-[30vw] text-gray-800 text-xl" :class="edit && 'bg-slate-200/[.4]'"
        >
            {{ modelValue }}
        </div>
        <InputError class="mt-2" :message="errors" />
    </div>
</template>
