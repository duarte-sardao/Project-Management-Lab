<script setup>
defineProps(['value']);
</script>

<template>
    <label class="pl-4 block font-light text-lg text-gray-500">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
