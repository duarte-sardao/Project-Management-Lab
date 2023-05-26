<script setup>
import { ref } from 'vue';
const componentKey = ref(false);

defineProps(['topic', 'index']);

const forceRender = () => {
    componentKey.value = !componentKey.value;
}
</script>

<template>
    <div
        class="w-[21.25%] px-2 py-2 my-[2vh] basis-[21.25%] box-border break-all flex items-center bg-[#FFFFFF]/[.81] rounded-xl border-2 border-[#578AD6] text-lg text-left cursor-pointer"
        :class="[(index % 4 !== 0) ? 'ml-[5%]':'', topic.selected ? 'opacity-100 hover:opacity-50':'opacity-40 hover:opacity-70']"
        :key="componentKey"
        v-on:click="forceRender()"
    >
        <div class="inline-block align-middle rounded-full border-1 w-[20px] min-w-[20px] min-h-[20px] h-[20px] mb-[3px] mr-2" :style="'background:' + topic.color"></div>
        {{ topic.topic }}
    </div>
</template>

