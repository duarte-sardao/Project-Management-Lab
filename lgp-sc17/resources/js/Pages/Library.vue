<script setup>
import NavBar from "@/Components/Navbar/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import LibrarySearch from "@/Components/Library/LibrarySearch.vue";
import PostCard from "@/Components/Common/PostCard.vue";

/*const props = defineProps({
    posts: Array
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
];

const title="Library"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>

    <LibrarySearch></LibrarySearch>

    <div class="px-[10%] pb-16 pt-5">
        <div id="posts" class="grid grid-cols-4 gap-6">
            <template v-for="(post, index) in posts">
                <PostCard
                    :is_text_top="index % 2 === 1"
                    :title="post.title"
                    :subtitle="post.subtitle"
                    :img_url="post.img_url === null ? '/svg_img/default-post.jpg' : post.img_url"/>
            </template>
        </div>
    </div>

    <Footer></Footer>
</template>

<script>
export default {
    name: "Library"
}
</script>

<style scoped>
@media all and (max-width: 1300px) {
    #posts {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media all and (max-width: 750px) {
    #posts {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}
</style>
