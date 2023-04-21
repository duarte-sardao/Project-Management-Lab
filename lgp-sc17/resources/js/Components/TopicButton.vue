<script setup>
import { ref } from 'vue';
const componentKey = ref(0);

defineProps(['topic', 'index']);

const forceRender = () => {
    componentKey.value += 1;
}
</script>

<template>
    <div
        class="inline-block w-[21.25%] px-2 py-2 my-[2vh] bg-[#FFFFFF]/[.81] rounded-xl border-2 border-[#578AD6] text-lg text-left"
        :class="[(index % 4 !== 0) ? 'ml-[5%]':'', topic.selected ? 'opacity-100':'opacity-40']"
        :key="componentKey"
        v-on:click="forceRender()"
    >
        <div class="inline-block align-middle rounded-full border-1 w-[20px] h-[20px] mb-[3px] mr-2" :class="'bg-[#' + topic.color + ']'"></div>
        {{ topic.topic }}
    </div>
</template>

