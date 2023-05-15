<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import { Link } from '@inertiajs/vue3';

defineProps({
    post: { required: true }
});
</script>

<template>
    <AdministrationLayout page="users">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><Link :href="route('admin.users')">{{ $t('users') }}</Link></li>
                <li>{{ $t('userInfo') }}</li>
            </ul>
        </div>

        <div class="pb-8 text-xl text-base-content">
            {{ $t('userInfoEdit') }}
        </div>
    </AdministrationLayout>
</template>

<script>
export default {
    name: "UserInfo"
}
</script>

<style scoped>

</style>
