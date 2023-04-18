<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center rounded-full px-6 py-2 bg-mainBlue font-bold text-md text-white tracking-widest hover:bg-highlightBlue transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
