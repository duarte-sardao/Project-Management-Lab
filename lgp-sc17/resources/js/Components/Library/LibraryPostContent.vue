<script setup>

</script>

<template>
    <div class="form-control w-full">
        <label class="label"><span class="label-text font-bold">Title</span></label>
        <input type="text" placeholder="Add title" class="input input-bordered w-full max-w" />
    </div>

    <div class="form-control">
        <label class="label"><span class="label-text font-bold">Subtitle</span></label>
        <textarea class="textarea textarea-bordered" placeholder="Add subtitle"></textarea>
    </div>

    <div class="form-control">
        <label class="label"><span class="label-text font-bold">Body Content</span></label>
        <textarea class="textarea textarea-bordered" placeholder="Add subtitle"></textarea>
    </div>
</template>

<script>
export default {
    name: "AdminPostContent"
}
</script>

<style scoped>

</style>
