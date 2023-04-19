<script setup>
import InputError from '@/Components/InputError.vue';
import { onMounted, ref } from 'vue';
defineProps(['id', 'edit', 'inputType', 'text', 'isInput', 'modelValue', 'errors']);
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
                required
                class="pb-1 focus-visible:outline-none rounded-full border-2 bg-transparent border-[#B9CEED] h-12 leading-9 pt-1 px-5 w-[30vw] text-gray-800 text-xl"
            />
            <InputError class="mt-2" :message="errors" />
        </div>
        <div
            v-else
            id=id
            class="rounded-full border-2 border-[#B9CEED] h-12 leading-9 pt-1 px-5 w-[30vw] text-gray-800 text-xl" :class="edit && 'bg-slate-200/[.4]'"
        >
            {{ modelValue }}
        </div>
    </div>
</template>
