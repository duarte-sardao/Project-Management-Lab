<script setup>
import NavBarSimple from "@/Components/Navbar/NavBarSimple.vue";
import Footer from "@/Components/Footer.vue";

/*const props = defineProps({
    post: Object
});*/

const post = {
    title: "Shoes!",
    subtitle: "If a dog chews shoes whose shoes does he choose?",
    description: "If a dog chews shoes whose shoes does he choose?",
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
                <img class="max-h-full" :src="post.img_url === null ? '/svg_img/default-post.jpg' : post.img_url">
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
