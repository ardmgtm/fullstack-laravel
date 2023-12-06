<template>
    <Head title="Role & Permission" />
    <MainLayout title="Role & Permission">
        <div class="flex">
            <div class="w-96 mr-4 flex-flex-col flex-grow-0 flex-shrink-0">
                <div class="flex justify-end mb-4">
                    <el-input placeholder="Search" v-model="search">
                        <template #prefix>
                            <BsIcon icon="magnifying-glass"></BsIcon>
                        </template>
                    </el-input>
                    <BsIconButton icon="plus" @click="addUserRoleAction"></BsIconButton>
                </div>
                <div class="h-[500px] overflow-y-scroll scroll pr-2">
                    <div v-if="isRolesEmpty" class="h-full w-full flex items-center justify-center">
                        <span class="text-gray-700 italic">
                            No Data
                        </span>
                    </div>
                    <div v-else>
                        <button
                            class="group bg-white p-4 rounded-xl border border-gray-400  w-full mb-2 hover:bg-primary-surface focus:bg-primary focus:text-white"
                            v-for="role in filteredRoles" :key="role.id">
                            <div class="flex flex-row justify-between items-center">
                                <div class="flex flex-row items-center">
                                    <div class="flex flex-col items-start">
                                        <span class="font-bold">{{ role.name }}</span>
                                        <span class="text-sm text-gray-700 group-focus:text-white">{{ role.users.length }} Users | {{ role.permissions.length }} permission granted</span>
                                    </div>
                                </div>
                                <div>
                                    <el-dropdown trigger="click" placement="bottom-end">
                                        <span class="el-dropdown-link">
                                            <BsIcon icon="ellipsis-vertical" class="group-focus:text-white" />
                                        </span>
                                        <template #dropdown>
                                            <el-dropdown-menu>
                                                <el-dropdown-item @click="editUserRoleAction(role)">
                                                    <BsIcon icon="pencil-square" class="mr-2"/> Rename
                                                </el-dropdown-item>
                                                <el-dropdown-item @click="deleteUserRoleAction(role)">
                                                    <BsIcon icon="trash" class="mr-2"/> Delete
                                                </el-dropdown-item>
                                            </el-dropdown-menu>
                                        </template>
                                    </el-dropdown>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="grow">
                <div class="col-span-12 lg:col-span-4 p-4 flex-1 bg-primary-surface rounded-xl">
                    <div class="h-[500px] w-full flex items-center justify-center flex-col" v-if="false">
                        <BsIcon icon="exclamation-triangle" size="48" class=" text-secondary"></BsIcon>
                        <h4 class="text-xl font-bold mb-2">No User Role Selected</h4>
                        <span class="w-56 text-center text-gray-700">
                            Select a role from the left to view or edit the user roles.
                        </span>
                    </div>
                    <div v-else>
                        <div class="flex flex-col">
                            <div class="flex flex-row justify-between items-center mb-4">
                                <h3 class="text-xl font-bold">Superadmin</h3>
                                <div>
                                    <BsButton icon="pencil">Rename</BsButton>
                                    <BsButton type="danger" icon="trash">Delete</BsButton>
                                </div>
                            </div>
                            <el-tabs v-model="activeTab" class="demo-tabs" @tab-click="handleClick">
                                <el-tab-pane label="Permission" name="permission">
                                    <div class="bg-white rounded-lg p-4">
                                        <h5 class="text-md font-bold mb-2">Permission Group</h5>
                                        <hr/>
                                        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 mt-2">
                                            <div class="flex flex-row justify-between items-center px-4 py-2" v-for="i in [...Array(6).keys()]">
                                                <span class="text-gray-800">Permission {{ i+1 }}</span>
                                                <el-switch/>
                                            </div>
                                        </div>
                                    </div>
                                </el-tab-pane>
                                <el-tab-pane label="User" name="user">User</el-tab-pane>
                            </el-tabs>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <el-dialog v-model="dialogFormRoleVisible" width="500px" :append-to-body="true" :destroy-on-close="true"
            class="!rounded-xl">
            <template #header>
                <span class="font-bold text-lg">{{ !editMode ? 'Tambah' : 'Edit' }} User Role</span>
            </template>
            <el-form ref="formUserRoleRef" :model="formUserRole" label-width="200px" label-position="top"
                require-asterisk-position="right" autocomplete="off">
                <el-form-item prop="name" label="Nama" :required="true">
                    <el-input v-model="formUserRole.name" autocomplete="one-time-code" autocorrect="off"
                        spellcheck="false" />
                </el-form-item>
            </el-form>
            <template #footer>
                <span class="dialog-footer flex">
                    <el-button class=" flex-grow" @click="closeDialog">Cancel</el-button>
                    <el-button class=" flex-grow" v-if="!editMode" type="primary"
                        @click="addUserRoleSubmitAction">Submit</el-button>
                    <el-button class=" flex-grow" v-if="editMode" type="primary"
                        @click="editUserRoleSubmitAction">Update</el-button>
                </span>
            </template>
        </el-dialog>
    </MainLayout>
</template>
<script setup>
import BsButton from '@/Components/BsButton.vue';
import BsIconButton from '@/Components/BsIconButton.vue';
import BsIcon from '@/Components/BsIcon.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, computed, reactive } from 'vue';

// CRUD user role
const dialogFormRoleVisible = ref(false);
const editMode = ref(false);
const formUserRoleRef = ref();
const search = ref('');
const formUserRole = reactive({
    id: '',
    name: '',
});
const roles = computed(() => usePage().props.roles);
const filteredRoles = computed(()=>{
    return roles.value.filter(role => role.name.toLowerCase().includes(search.value.toLowerCase()));
});
const isRolesEmpty = computed(() => filteredRoles.value.length < 1);

function closeDialog() {
    dialogFormRoleVisible.value = false;
}

function addUserRoleAction() {
    dialogFormRoleVisible.value = true;
    editMode.value = false;

    formUserRole.id = null;
    formUserRole.name = '';
}
async function addUserRoleSubmitAction() {
    await formUserRoleRef.value.validate((valid, _) => {
        if (valid) {
            dialogFormRoleVisible.value = false;
            axios.post('/api/role', formUserRole)
                .then((response) => {
                    var responseData = response.data;
                    ElMessage({
                        message: responseData.msg,
                        type: 'success',
                    });
                    router.reload({ only: ['roles'] });
                })
                .catch((error) => {
                    var errorResponseData = error.response.data;
                    ElMessage({
                        message: errorResponseData.msg,
                        type: 'error',
                    });
                });
        }
    });
}
function editUserRoleAction(dataRole) {
    dialogFormRoleVisible.value = true;
    editMode.value = true;

    formUserRole.id = dataRole.id;
    formUserRole.name = dataRole.name;
}
async function editUserRoleSubmitAction() {
    await formUserRoleRef.value.validate(async (valid, _) => {
        if (valid) {
            dialogFormRoleVisible.value = false;
            axios.put('/api/role/' + formUserRole.id, formUserRole)
                .then((response) => {
                    var responseData = response.data;
                    ElMessage({
                        message: responseData.msg,
                        type: 'success',
                    });
                    router.reload({ only: ['roles'] });
                })
                .catch((error) => {
                    var errorResponseData = error.response.data;
                    ElMessage({
                        message: errorResponseData.msg,
                        type: 'error',
                    });
                });
        }
    });
}
function deleteUserRoleAction(dataRole) {
    ElMessageBox.confirm(
        'Apakah anda yakin untuk mengahapus user ini ?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
        .then(() => {
            axios.delete('/api/role/'+dataRole.id)
                .then((response) => {
                    var responseData = response.data;
                    ElMessage({
                        message: responseData.msg,
                        type: 'success',
                    });
                    router.reload({ only: ['roles'] });
                })
                .catch((error) => {
                    var errorResponseData = error.response.data;
                    ElMessage({
                        message: errorResponseData.msg,
                        type: 'error',
                    });
                });
        })
        .catch(() => {
            ElMessage({
                type: 'info',
                message: 'Menghapus role dibatalkan',
            })
        });
}

// Role permission & User
const activeTab = ref('permission');

</script>