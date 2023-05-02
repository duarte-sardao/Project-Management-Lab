<script setup>
defineProps(['text', 'value']);
</script>

<template>
    <div class="my-5 text-xl">
        <label class="text-[#578AD6] pr-1">{{ text }}:</label>
        <span class="text-[#000]">{{ value }}</span>
    </div>
</template>
