<script setup>
import { TailwindPagination } from 'laravel-vue-pagination';
import NavBar from "@/Components/Navbar/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import LibrarySearch from "@/Components/Library/LibrarySearch.vue";
import PostCard from "@/Components/Common/PostCard.vue";
import {ref} from "vue";
import axios from "axios";

const props = defineProps(['posts']);

const results = ref(props.posts);
const search = ref('');
const getResults = async (page = 1) => {
    axios.get('/api/library?page=' + page + '&search=' + search.value)
        .then(response => {
            results.value = response.data;
        })
}

const title="Library"
const subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt ligula aliquet"
</script>

<template>
    <NavBar :title="title" :subtitle="subtitle">
        <template v-slot:content-right></template>
        <template v-slot:content-bottom></template>
    </NavBar>

    <LibrarySearch @submit="getResults" v-model="search"></LibrarySearch>

    <div class="px-[10%] pb-16 pt-5">
        <div id="posts" class="grid grid-cols-4 gap-6">
            <template v-for="(post, index) in results.data">
                <PostCard
                    :is_text_top="index % 2 === 1"
                    :title="post.title"
                    :subtitle="post.subtitle"
                    :img_url="post.img_url === '' ? '/svg_img/default-post.jpg' : post.img_url"
                    :url="'/library/' + post.id"
                />
            </template>
        </div>
        <div class="flex justify-center py-8">
            <TailwindPagination
                :data="results"
                @pagination-change-page="getResults"
            />
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
