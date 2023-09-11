<template>
    <div class="py-4 px-6 text-xs text-gray-800">
        <div :class="[
            { 'md:pl-20': collapsed },
            { 'md:pl-64': !collapsed }
        ]">
            {{year}}&copy; <span class=" font-bold">PT. Pupuk Kalimantan Timur</span>
        </div>
    </div>
</template>

<script setup>
const prop = defineProps({
    collapsed: Boolean,
})
const year = new Date().getFullYear();
</script>