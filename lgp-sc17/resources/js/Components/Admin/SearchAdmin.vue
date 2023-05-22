<script setup>
import {onMounted, ref} from "vue";

defineProps(['modelValue']);
defineEmits(['update:modelValue', 'submit']);

const input = ref(null);
onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="flex justify-center">
        <div id="library-search" class="relative w-[80%]">
            <input
                id="search"
                type="text"
                class="input inline-block w-full text-sm text-gray-900 input-bordered border-mainBlue rounded-full bg-transparent"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                :placeholder="$t('search')"
                ref="input"
            />
            <button @click="$emit('submit')" class="text-white absolute right-2.5 bottom-3.5 font-medium "><svg aria-hidden="true" class="w-5 h-5 text-mainBlue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Search"
}
</script>

<style scoped>

</style>
