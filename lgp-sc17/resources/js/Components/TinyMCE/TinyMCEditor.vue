<script setup>
import {ref, watch} from "vue";
import Editor from '@tinymce/tinymce-vue';

const props = defineProps({
    'content': {
        type: String,
        default: '',
    }
});

const emit = defineEmits(['update'])
let content = ref(props.content);
watch(content, () => emit('update', content.value));

function file_picker(callback, value, meta) {
    let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
    let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
    let cmsURL = '/laravel-filemanager?editor=' + meta.fieldname;
    if (meta.filetype === 'image') {
        cmsURL = cmsURL + "&type=Images";
    } else if (meta.filetype === 'media') {
        cmsURL = cmsURL + "&type=Medias";
    } else {
        cmsURL = cmsURL + "&type=Files";
    }

    tinyMCE.activeEditor.windowManager.openUrl({
        url : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no",
        onMessage: (api, message) => {
            callback(message.content);
        }
    });
}

</script>

<template>
    <Editor
        id="editor"
        tinymce-script-src="/tinymce/tinymce.min.js"
        :init="{
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontsize | forecolor backcolor | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                relative_urls: false,
                promotion: false,
                file_picker_types: 'file image media',
                file_picker_callback : file_picker
            }"
        v-model="content"
    />
</template>input
<script>
export default {
    name: "Editor"
}
</script>

<style scoped>

</style>
