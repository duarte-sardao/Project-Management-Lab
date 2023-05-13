<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import { Link } from '@inertiajs/vue3';
import LibraryPostContent from "@/Components/Library/LibraryPostContent.vue";
</script>

<template>
    <AdministrationLayout page="library">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><Link :href="route('admin.library')">{{ $t('library') }}</Link></li>
                <li>{{ $t('libraryButtonCreate') }}</li>
            </ul>
        </div>

        <div class="pb-8 text-xl text-base-content">
            {{ $t('libraryCreate') }}
        </div>

        <LibraryPostContent route_name="admin.library.new"></LibraryPostContent>
    </AdministrationLayout>
</template>

<script>

export default {
    name: "LibraryNewPost",
}
</script>

<style scoped>

</style>
