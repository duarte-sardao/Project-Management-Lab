<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import { Link } from '@inertiajs/vue3';
import {ref} from "vue";

const props = defineProps({
    user: { required: true }
});

/**const profile_img_url = ref(props.user.profile_img_url);
if (profile_img_url.value == null) {
    profile_img_url.value = '/svg_icons/profile.svg';
}**/
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

        <div class="grid grid-cols-2">
            <img id="profile-img" class="rounded-full mx-auto mb-[7vh] h-fit w-[200px] h-[200px]" :src="'/svg_icons/profile.svg'" alt="profile image">
            <div>
                <p class="font-bold underline">{{$t('fullName')}}</p><p>Full Name</p>
                <p class="font-bold underline">Username</p><p>Username</p>
                <p class="font-bold underline">Email</p><p>Email</p>
                <p class="font-bold underline">{{$t('phoneNumber')}}</p><p>999999999</p>
                <div class="dropdown">
                    <label tabindex="0" class="btn m-1">{{ $t('setStatus') }}</label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a>Guest</a></li>
                        <li><a>{{ $t('user') }}</a></li>
                        <li><a>{{ $t('doctor') }}</a></li>
                    </ul>
                </div>
            </div>
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
