<script setup>
import NavBar from "@/Components/Navbar/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import LibrarySearch from "@/Components/Library/LibrarySearch.vue";
import PostCard from "@/Components/Common/PostCard.vue";

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
            <PostCard :is_text_top="false"></PostCard>
            <PostCard :is_text_top="true"></PostCard>
            <PostCard :is_text_top="false"></PostCard>
            <PostCard :is_text_top="true"></PostCard>
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
