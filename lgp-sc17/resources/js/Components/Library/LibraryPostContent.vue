<script setup>
import Editor from '@tinymce/tinymce-vue'
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
        <Editor
            tinymce-script-src="/tinymce/tinymce.min.js"
            :init="{
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontsize | forecolor backcolor | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                promotion: false,
                image_title: true,
                automatic_uploads: true,
                images_upload_url: route('admin.upload.image'),
            }"
        />
    </div>
</template>

<script>
export default {
    name: "AdminPostContent"
}
</script>

<style scoped>

</style>
