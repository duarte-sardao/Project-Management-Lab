<script setup>
import AdministrationLayout from "@/Layouts/AdministrationLayout.vue";
import Search from "@/Components/Common/Search.vue";
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <AdministrationLayout page="library">
        <div class="grid grid-cols-2">
            <div class="pb-16 text-xl text-gray-400">
                <div class="text-4xl text-black">{{ $t('libraryContent') }}</div>
                {{ $t('libraryContentHint') }}
            </div>
            <div>
                <Search></Search>
            </div>
        </div>
        <div class="pb-4 flex justify-center">
            <Link :href="route('admin.library.new')" class="btn btn-wide hover:bg-lightBlue bg-mainBlue text-white border-0 rounded-full">Create New</Link>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <!-- head -->
                <thead>
                <tr>
                    <th class="w-5/12">{{ $t('title') }}</th>
                    <th class="w-3/12">{{ $t('date') }}</th>
                    <th class="w-2/12 text-center">{{ $t('state') }}</th>
                    <th class="w-1/12 text-center">{{ $t('edit') }}</th>
                    <th class="w-1/12 text-center">{{ $t('delete') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Cy Ganderton</td>
                    <td>Quality Control Specialist</td>
                    <td class="text-center">{{ $t('public') }}</td>
                    <td class="text-center"><Link class="flex justify-center"><img src="/svg_icons/pencil.svg" alt="our vision"></Link></td>
                    <td class="text-center"><Link class="flex justify-center"><img src="/svg_icons/trash.svg" alt="our vision"></Link></td>
                </tr>
                <tr>
                    <td>Hart Hagerty</td>
                    <td>Desktop Support Technician</td>
                    <td class="text-center">{{ $t('private') }}</td>
                    <td class="text-center"><Link class="flex justify-center"><img src="/svg_icons/pencil.svg" alt="our vision"></Link></td>
                    <td class="text-center"><Link class="flex justify-center"><img src="/svg_icons/trash.svg" alt="our vision"></Link></td>
                </tr>
                <tr>
                    <td>Brice Swyre</td>
                    <td>Tax Accountant</td>
                    <td class="text-center">{{ $t('public') }}</td>
                    <td class="text-center"><Link class="flex justify-center"><img src="/svg_icons/pencil.svg" alt="our vision"></Link></td>
                    <td class="text-center"><Link class="flex justify-center"><img src="/svg_icons/trash.svg" alt="our vision"></Link></td>
                </tr>
                </tbody>
            </table>
        </div>
    </AdministrationLayout>
</template>

<script>
export default {
    name: "Library"
}
</script>

<style scoped>

</style>
