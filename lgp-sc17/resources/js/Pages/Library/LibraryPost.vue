<script setup>
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";
import PostCard from "@/Components/Common/PostCard.vue";
import CarouselCard from "@/Components/Common/CarouselCard.vue";

/*const props = defineProps({
    post: Object
});*/

const posts = [
    {
        title: "Shoes!",
        subtitle: "If a dog chews shoes whose shoes does he choose?",
        img_url: null
    },
    {
        title: "Shoes!",
        subtitle: "If a dog chews shoes whose shoes does he choose?",
        img_url: null
    },
    {
        title: "Shoes!",
        subtitle: "If a dog chews shoes whose shoes does he choose?",
        img_url: null
    },
    {
        title: "Shoes!",
        subtitle: "If a dog chews shoes whose shoes does he choose?",
        img_url: null
    },
    {
        title: "Shoes!",
        subtitle: "If a dog chews shoes whose shoes does he choose?",
        img_url: null
    },
    {
        title: "Shoes!",
        subtitle: "If a dog chews shoes whose shoes does he choose?",
        img_url: null
    },
];

const post = {
    title: "Shoes!",
    subtitle: "If a dog chews shoes whose shoes does he choose?",
    description: "<h2 class='text-2xl text-red-600 font-bold'>If a dog chews shoes whose shoes does he choose?</h2>",
    img_url: null
};

const title="Title of an Article"
</script>

<template>
    <NavBarSimple/>

    <div class="py-20 px-[10%]">
        <div class="grid grid-cols-2 h-[20rem]">
            <div class="h-full flex flex-col justify-center items-center overflow-hidden">
                <div class="text-4xl font-extrabold pb-8">
                    {{ post.title }}
                </div>
                <div class="w-full flex justify-start font-bold text-xl">
                    {{ post.subtitle }}
                </div>
            </div>
            <div class="h-full flex justify-center items-center overflow-hidden">
                <img class="max-h-full" :src="post.img_url === null ? '/svg_img/default-post.jpg' : post.img_url" alt="Post image">
            </div>
        </div>

        <div class="py-8"/>

        <div v-html="post.description"></div>

        <div class="py-8"/>

        <div class="carousel carousel-center p-6 space-x-16 bg-bgColor h-[28rem]">
            <div v-for="(post, index) in posts" class="carousel-item w-64">
                <CarouselCard
                    :is_text_top="index % 2 === 1"
                    :title="post.title"
                    :subtitle="post.subtitle"
                    :img_url="post.img_url === null ? '/svg_img/default-post.jpg' : post.img_url"/>
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
