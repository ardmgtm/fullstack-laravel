<template>
    <Head title="Daily Report" />
    <MainLayout title="Role & Permission">
        <div class="flex">
            <div class="w-96 mr-4 flex-flex-col">
                <div class="flex justify-end mb-4">
                    <el-input placeholder="Search">
                        <template #prefix>
                            <BsIcon icon="magnifying-glass"></BsIcon>
                        </template>
                    </el-input>
                    <BsIconButton icon="plus"></BsIconButton>
                </div>
                <div class="h-[500px] overflow-y-scroll scroll">
                    <button
                        class="bg-white p-4 rounded-xl border border-gray-400  w-full mb-2 hover:bg-primary-surface focus:bg-primary focus:text-white"
                        v-for="x in [...Array(10).keys()]">
                        <div class="flex flex-row justify-between items-center">
                            <div class="flex flex-row items-center">
                                <div class="flex flex-col items-start">
                                    <span class="font-bold">Superadmin</span>
                                    <span>1 Users | 14 permission granted</span>
                                </div>
                            </div>
                            <div>
                                <el-dropdown trigger="click" placement="bottom-end">
                                    <span class="el-dropdown-link">
                                        <BsIcon icon="ellipsis-vertical" />
                                    </span>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item>
                                                <BsIcon icon="pencil-square" class="mr-2" /> Rename
                                            </el-dropdown-item>
                                            <el-dropdown-item>
                                                <BsIcon icon="trash" class="mr-2" /> Delete
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div class="grow">
                <div class="col-span-12 lg:col-span-4 p-4 rounded-xl flex-1 bg-primary-surface">
                    <div class="h-80 w-full flex items-center justify-center flex-col">
                        <BsIcon icon="exclamation-triangle" size="48" class=" text-secondary"></BsIcon>
                        <h4 class="text-xl font-bold mb-2">No User Role Selected</h4>
                        <span class="w-48 text-center text-gray-700">Select a role from the left to view or edit the user
                            roles.</span>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
<script setup>
import BsIconButton from '@/Components/BsIconButton.vue';
import BsIcon from '@/Components/BsIcon.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';


</script>