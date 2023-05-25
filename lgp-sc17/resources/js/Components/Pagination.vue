<script setup lang="ts">
type Booleanish = boolean | 'true' | 'false';
type Page = {
    name: number;
    isDisabled: Booleanish;
};

const emit = defineEmits(['pageChanged']);
const props = defineProps({
    maxVisibleButtons: {
        type: Number,
        required: false,
        default: 3
    },
    totalPages: {
        type: Number,
        required: true
    },
    currentPage: {
        type: Number,
        required: true
    },
});

const isInFirstPage = props.currentPage === 1;
const isInLastPage = props.currentPage === props.totalPages;

// Set the start page
let startPage: number;
if (props.currentPage === 1) {
    startPage = 1; // When on the first page
}
else if (props.currentPage === props.totalPages) {
    startPage = Math.max(props.totalPages - (props.maxVisibleButtons - 1), 1); // When on the last page
}
else {
    startPage = props.currentPage - 1; // When inbetween
}

// Set the pages to display
const pages = [];
const maxRange = Math.min(startPage + props.maxVisibleButtons - 1, props.totalPages);
for (let i = startPage; i <= maxRange; i++) {
    pages.push({
        name: i,
        isDisabled: i === props.currentPage
    });
}

const onClickFirstPage = () => {
    emit('pageChanged', 1);
};
const onClickPreviousPage = () => {
    emit('pageChanged', props.currentPage - 1);
};
const onClickPage = (page: number) => {
    emit('pageChanged', page);
};
const onClickNextPage = () => {
    emit('pageChanged', props.currentPage + 1);
};
const onClickLastPage = () => {
    emit('pageChanged', props.totalPages);
};
const isPageActive = (page: number) => {
    return props.currentPage === page;
};

</script >

<template>
    <ul class="list-none text-[#606060] text-xl font-bold">
    <!-- Previous Page Button -->
        <li class="mr-4">
            <button
                type="button"
                class="align-middle"
                @click="onClickPreviousPage"
                :disabled="isInFirstPage"
                :class="[!isInFirstPage ? 'transition duration-150 hover:scale-125':'opacity-25']"
            >
                <img src="/svg_icons/pagination_arrow.svg" alt="Previous page" />
        </button>
        </li>

        <!-- First Page Button -->

        <li v-if="startPage != 1" class="ml-3" key="firstPage">
            <button type="button" @click="onClickFirstPage" class="inline-block transition duration-150 hover:scale-125">
                1
            </button>
            <div class="inline-block tracking-widest ml-3">...</div>
        </li>

        <!-- Pages Buttons -->
        <li
            v-for="page in (pages as Page[])"
            class="mx-2 px-1" :key="(page as Page).name"
            :class="{ 'border-b-[3px] border-[#578AD6]': isPageActive((page as Page).name) }"
        >
            <button
                type="button"
                @click="onClickPage((page as Page).name)"
                :disabled="(page as Page).isDisabled"
                :class="!(page as Page).isDisabled && 'transition duration-150 hover:scale-125'"
            >
                {{ (page as Page).name }}
            </button>
        </li>

        <!-- Last Page Button -->

        <li v-if="pages[pages.length - 1].name != totalPages" class="mr-3" key="lastPage">
            <div class="inline-block tracking-widest mr-3">...</div>
            <button type="button" @click="onClickLastPage" class="inline-block transition duration-150 hover:scale-125">
                {{ totalPages }}
            </button>
        </li>

        <!-- Next Page Button -->
        <li class="ml-4">
            <button
                type="button"
                class="align-middle"
                @click="onClickNextPage"
                :disabled="isInLastPage"
                :class="[!isInLastPage ? 'transition duration-150 hover:scale-125':'opacity-25']"
            >
                <img src="/svg_icons/pagination_arrow.svg" class="rotate-180" alt="Next page" />
            </button>
        </li>
    </ul>
</template>
