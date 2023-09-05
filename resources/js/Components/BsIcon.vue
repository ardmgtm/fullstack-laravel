<template>
    <div class="h-5 w-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" v-html="Icon">
        </svg>
    </div>
</template>

<script setup>
import { heroIcons } from "@/Core/Icons/hero-icons";
import { ref } from "vue";

const props = defineProps({
    icon:{
        type: String
    }
});

const Icon = ref(null);
Icon.value = heroIcons(props.icon);
</script>