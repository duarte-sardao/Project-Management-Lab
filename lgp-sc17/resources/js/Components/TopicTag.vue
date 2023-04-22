<script setup>
defineProps(['topic', 'index']);
</script>

<template>
    <div 
        class="bg-[#FFF] w-[21.25%] border-[1px] border-[#578AD6] rounded-2xl py-3 px-4 inline-block relative"
        :class="[index !== 0 ? 'ml-[-5%]':'', topic.selected ? 'z-50 border-t-4 border-t-indigo-400':``]"
        :style="`z-index:${index+1}*10`"
    >
        <div class="inline-block align-middle rounded-full border-1 w-[20px] h-[20px] mb-[3px] mr-2" :style="`background:${topic.color}`"></div>
        <span class="text-[#6D6D6D] text-md font-normal">{{ topic.topic }}</span>
    </div>
</template>

