<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <AdministrationLayout page="library">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><Link :href="route('admin.library')">{{ $t('library') }}</Link></li>
                <li>{{ $t('libraryButtonCreate') }}</li>
            </ul>
        </div>

        <div class="pb-16 text-xl text-base-content">
            {{ $t('libraryCreate') }}
        </div>
    </AdministrationLayout>
</template>

<script>

export default {
    name: "LibraryNewPost",
}
</script>

<style scoped>

</style>
