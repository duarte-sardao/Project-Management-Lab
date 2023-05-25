<script setup>
defineProps({
    message: String,
    error: String
});
</script>

<template>
    <div v-if="message !== 'null'">
        <div class="toast toast-end" style="z-index: 99">
            <div class="alert alert-success text-white">
                <span>{{ message }}</span>
            </div>
        </div>
    </div>
    <div v-else-if="error !== 'null'">
        <div class="toast toast-end" style="z-index: 99">
            <div class="alert alert-error text-white">
                <span>{{ error }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MessageToast"
}
</script>

<style scoped>

</style>
