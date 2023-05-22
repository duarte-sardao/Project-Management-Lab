<script setup>
defineProps({
    message: String,
    error: String
});
</script>

<template>
    <div v-if="message">
        <div class="toast toast-end mr-4" style="z-index: 99">
            <div class="alert alert-success text-white">
                <span>{{ message }}</span>
            </div>
        </div>
    </div>
    <div v-if="error">
        <div class="toast toast-end mr-4" style="z-index: 99">
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
