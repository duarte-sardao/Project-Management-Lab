<script setup>
const props = defineProps({
    'is_text_top': {
        type: Boolean,
        required: true,
    },
    'img_url': {
        type: String,
        required: true
    },
    'title': {
        type: String,
        required: true
    },
    'subtitle': {
        type: String,
        required: true
    }
});

</script>

<template>
    <div v-if="is_text_top" class="card bg-base-100 rounded-3xl bg-white">
        <div id="post" class="bg-cover bg-center h-[24rem] w-full rounded-[30px]" :style="'background-image: url(' + img_url + ')'">
            <div class="card-body p-3 pt-10">
                <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%] bg-white">
                    <div>
                        <h2 class="card-title pl-4 pt-3 font-bold text-2xl ">{{ title }}</h2>
                        <p class="pl-4">{{ subtitle }}</p>
                    </div>
                    <div class="card-actions items-end pb-3 pl-2">
                        <button class="btn btn-circle bg-white hover:bg-mainBlue text-gray-400 hover:text-white text-xl font-thin border-none">❯</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="card bg-base-100 rounded-3xl bg-white">
        <div id="post" class="bg-cover bg-center h-[24rem] w-full rounded-[30px]" :style="'background-image: url(' + img_url + ')'">
            <div class="card-body p-3 absolute inset-x-0 bottom-10">
                <div class="card bg-base-100 rounded-3xl h-32 bg-opacity-20 backdrop-blur-md shadow-lg grid grid-cols-[70%_30%]">
                    <div>
                        <h2 class="card-title pl-4 pt-3 font-bold text-2xl dark:text-black">{{ title }}</h2>
                        <p class="pl-4">{{ subtitle }}</p>
                    </div>
                    <div class="card-actions items-end pb-3 pl-2">
                        <button class="btn btn-circle bg-white hover:bg-mainBlue text-gray-400 hover:text-white text-xl font-thin border-none">❯</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PostCard"
}
</script>

<style scoped>
@media all and (max-width: 1300px) {
    #post {
        max-height: 12rem;
    }
}
</style>
