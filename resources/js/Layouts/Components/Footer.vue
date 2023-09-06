<template>
    <footer class="text-xs text-gray-800 p-4" :class="[
        { 'pl-20': collapsed },
        { 'pl-64': !collapsed }
    ]">
        {{year}}&copy; <span class=" font-bold">PT. Pupuk Kalimantan Timur</span>
    </footer>
</template>

<script setup>
const year = new Date().getFullYear();
</script>