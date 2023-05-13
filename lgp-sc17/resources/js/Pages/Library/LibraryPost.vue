<script setup>
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import CarouselCard from "@/Components/Common/CarouselCard.vue";

const props = defineProps({
    post: { required: true },
    posts: {},
});
</script>

<template>
    <NavBarSimple/>

    <div class="py-20 px-[10%]">
        <div class="grid grid-cols-2 h-[20rem]">
            <div class="h-full flex flex-col justify-center items-center overflow-hidden">
                <div class="text-4xl font-extrabold pb-8">
                    {{ props.post.title }}
                </div>
                <div class="w-full flex justify-start font-bold text-xl">
                    {{ props.post.subtitle }}
                </div>
            </div>
            <div class="h-full flex justify-center items-center overflow-hidden">
                <img class="max-h-full" :src="props.post.img_url === '' ? '/svg_img/default-post.jpg' : props.post.img_url" alt="Post image">
            </div>
        </div>

        <div class="py-8"/>

        <div v-html="props.post.content"></div>

        <div class="py-8"/>

        <div class="carousel carousel-center p-6 space-x-16 bg-bgColor h-[28rem]">
            <div v-for="(post, index) in posts" class="carousel-item w-64">
                <CarouselCard
                    :is_text_top="index % 2 === 1"
                    :title="post.title"
                    :subtitle="post.subtitle"
                    :img_url="post.img_url === '' ? '/svg_img/default-post.jpg' : post.img_url"
                    :url="'/library/' + post.id"
                />
            </div>
        </div>
    </div>

    <Footer/>
</template>

<script>
export default {
    name: "LibraryPost"
}
</script>

<style scoped>

</style>
