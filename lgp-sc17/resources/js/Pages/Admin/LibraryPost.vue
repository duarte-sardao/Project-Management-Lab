<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import { Link } from '@inertiajs/vue3';
import LibraryPostContent from "@/Components/Library/LibraryPostContent.vue";

defineProps({
    id: { required: true },
    title: { required: true },
    subtitle: { required: true },
    content: { required: true },
    public: { required: true }
});
</script>

<template>
    <AdministrationLayout page="library">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><Link :href="route('admin.library')">{{ $t('library') }}</Link></li>
                <li>{{ $t('libraryPost') }}</li>
            </ul>
        </div>

        <div class="pb-8 text-xl text-base-content">
            {{ $t('libraryPostEdit') }}
        </div>

        <LibraryPostContent
            :title="title"
            :subtitle="subtitle"
            :content="content"
            :public="public"
            route_name="admin.library.post"
            :route_id="id"/>
    </AdministrationLayout>
</template>

<script>
export default {
    name: "LibraryPost"
}
</script>

<style scoped>

</style>
