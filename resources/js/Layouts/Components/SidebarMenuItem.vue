<template>
    <li :key="key" class="flex flex-col transition-colors duration-300 cursor-pointer pl-4" :class="[
        { 'rounded-md gap-4': !collapsed },
        { 'rounded-full w-10': collapsed },
        { 'mb-4':!hasSubmenu||collapsed},
        { '': $page.url.startsWith(menuItem.href) },
    ]" @click="() => expanded = !expanded">
        <Link 
            :href="menuItem.href" 
            class="group"
            v-if="!hasSubmenu"
        >
            <div class="flex justify-between">
                <div class="flex gap-2 align-middle items-center">
                    <div v-if="menuItem.icon != null">
                        <bs-icon 
                            :icon="menuItem.icon" 
                            class="group-hover:text-primary mr-1"
                            :class="[
                                { 'text-primary': $page.url.startsWith(menuItem.href) },
                                { 'text-gray-900': !$page.url.startsWith(menuItem.href) },
                            ]"
                        ></bs-icon>
                    </div>
                    <div v-else>
                        <div class="h-1 w-1 rounded-full bg-gray-900 mr-1 group-hover:bg-primary"></div>
                    </div>
                    <span 
                        v-if="!collapsed" 
                        class="group-hover:text-primary font-bold text-sm"
                        :class="[
                            { 'text-primary': $page.url.startsWith(menuItem.href) },
                            { 'text-gray-900': !$page.url.startsWith(menuItem.href) },
                        ]"
                    >
                        {{ menuItem.label }}
                    </span>
                </div>
            </div>
        </Link>
        <div v-else class="group">
            <div class="flex justify-between">
                <div class="flex gap-2 align-middle items-center">
                    <div v-if="menuItem.icon != null">
                        <bs-icon 
                            :icon="menuItem.icon" 
                            class="group-hover:text-primary mr-1"
                            :class="[
                                { 'text-primary': $page.url.startsWith(menuItem.href) },
                                { 'text-gray-900': !$page.url.startsWith(menuItem.href) },
                            ]"
                        ></bs-icon>
                    </div>
                    <div v-else>
                        <div class="h-1 w-1 rounded-full bg-gray-900 mr-1 group-hover:bg-primary"></div>
                    </div>
                    <span 
                        v-if="!collapsed" 
                        class="group-hover:text-primary font-bold text-sm"
                        :class="[
                            { 'text-primary': $page.url.startsWith(menuItem.href) },
                            { 'text-gray-900': !$page.url.startsWith(menuItem.href) },
                        ]"
                    >
                        {{ menuItem.label }}
                    </span>
                </div>
                <bs-icon class="group-hover:text-primary transition-transform duration-300" :class="[
                    { '-rotate-180': expanded },
                    { 'rotate-0': !expanded },
                ]" icon="chevron-down" v-if="!collapsed">
                </bs-icon>
            </div>
        </div>
        <div v-if="hasSubmenu && !collapsed" class="ml-1 transition-[max-height] duration-300 overflow-hidden ease-in-out" :class="[
            { 'max-h-0': !expanded },
            { 'max-h-[2048px]': expanded },
        ]">
            <ul>
                <sidebar-menu-item 
                    v-for="childMenuItem, index in menuItem.submenu" 
                    :menu-item="childMenuItem" 
                    :key="index"
                    :collapsed="collapsed" 
                    :is-submenu="true"
                >
                </sidebar-menu-item>
            </ul>
        </div>
    </li>
</template>

<script setup>
import { ref, computed } from 'vue';
import BsIcon from '@/Components/BsIcon.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    key: Number,
    menuItem: Object,
    collapsed: Boolean,
    isSubmenu: {
        type: Boolean,
        default: false,
    },
})
const expanded = ref(false);
const hasSubmenu = computed(() => {
    return props.menuItem.submenu != null && props.menuItem.submenu.length > 0;
});
</script>