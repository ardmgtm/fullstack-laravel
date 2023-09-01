<script setup>
import BsButton from '@/Components/BsButton.vue';

</script>
<template>
    <div class="container mx-auto bg-white rounded-xl p-6">
        <div class="flex">
            <BsButton icon="cloud-arrow-down" type="primary">Download</BsButton>
            <BsButton icon="cloud-arrow-up" type="primary-outline">Upload</BsButton>
            <BsButton type="secondary">Download</BsButton>
            <BsButton type="secondary-outline">Download</BsButton>
            <BsButton icon="trash" type="danger">Delete</BsButton>
            <BsButton icon="trash" type="danger-outline">Delete</BsButton>
        </div>
    </div>
</template>