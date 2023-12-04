<template>
    <button class=" hover:bg-primary-surface p-2 rounded-full">
        <BsIcon :icon="icon"/>
    </button>
</template>
<script setup>
import BsIcon from '@/Components/BsIcon.vue';

const props = defineProps({
    type:{
        type: String,
        default:"primary"
    },
    icon:{
        type: String,
        required: true
    }
});
</script>