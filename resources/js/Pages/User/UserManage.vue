<template>
    <Head title="Manage User" />
    <MainLayout title="User Manage">
        <div class="flex flex-col">
            <DxDataGrid ref="datagridRef" :data-source="dataSource" key-expr="user_id" :remote-operations="remoteOperations"
                :item-per-page="10" @selection-changed="onSelectionChanged" @exporting="onExporting">
                <DxFilterRow :visible="true" />
                <DxExport :enabled="true" />
                <DxSelection select-all-mode="page" show-check-boxes-mode="always" mode="multiple" />
                <DxColumnChooser :enabled="true" mode="select" />
                <DxHeaderFilter :visible="true" />
                <DxColumn data-field="npk" caption="NPK" :allowHeaderFiltering="false" />
                <DxColumn data-field="name" caption="Nama" :allowHeaderFiltering="false" />
                <DxColumn data-field="email" caption="Email" :allowHeaderFiltering="false" />
                <DxColumn data-field="is_active" caption="Status" cell-template="user-status" width="150" alignment="center"
                    :allowFiltering="false" :allowHeaderFiltering="true" :customizeText="statusText" />
                <template #user-status="{ data }">
                    <span v-if="data.data.is_active" class="px-4 py-2 rounded-md bg-success text-white">Aktif</span>
                    <span v-else class="px-4 py-2 rounded-md bg-danger text-white">Tidak Aktif</span>
                </template>
                <DxColumn cell-template="action" width="75" alignment="center" :allowExporting="false" />
                <template #action="{ data }">
                    <el-dropdown trigger="click" placement="bottom-end">
                        <span class="el-dropdown-link">
                            <BsIcon icon="ellipsis-vertical" />
                        </span>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item @click="editUserAction(data.data)">
                                    <BsIcon icon="pencil-square" class="mr-2" /> Edit User
                                </el-dropdown-item>
                                <el-dropdown-item v-if="!data.data.is_active" @click="switchUserStatus(data.data,true)">
                                    <BsIcon icon="arrow-path-rounded-square" class="mr-2" /> Enable User
                                </el-dropdown-item>
                                <el-dropdown-item v-else @click="switchUserStatus(data.data,false)">
                                    <BsIcon icon="arrow-path-rounded-square" class="mr-2" /> Disable User
                                </el-dropdown-item>
                                <el-dropdown-item @click="deleteUserAction(data.data)">
                                    <BsIcon icon="trash" class="mr-2" /> Delete User
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </template>
                <DxToolbar>
                    <DxItem location="before" template="buttonTemplate" />
                    <DxItem name="columnChooserButton" />
                    <DxItem name="exportButton" />
                </DxToolbar>
                <template #buttonTemplate>
                    <div class="flex flex-row w-full">
                        <Transition name="fade" mode="out-in" appear>
                            <div v-if="!itemSelected">
                                <BsButton type="primary" icon="plus" @click="addUserAction">Add User</BsButton>
                                <BsButton type="primary" icon="arrow-path" @click="refreshDatagrid">Refresh</BsButton>
                            </div>
                            <div v-else class="h-auto flex items-center px-4">
                                <BsIconButton icon="x-mark" class="mr-2" @click="clearSelection"/>
                                <span class="font-bold mr-4">{{ dataSelected.length }} dipilih</span>
                                <!-- <BsButton type="danger" icon="trash">Delete</BsButton> -->
                            </div>
                        </Transition>
                    </div>
                </template>
            </DxDataGrid>
        </div>
        <el-dialog v-model="dialogFormVisible" width="500px" :append-to-body="true" :destroy-on-close="true" class="!rounded-xl">
            <template #header>
                <span class="font-bold text-lg">{{ !editMode ? 'Tambah' : 'Edit' }} User</span>
            </template>
            <el-form ref="formUserRef" :model="formUser" label-width="200px" label-position="top"
                require-asterisk-position="right" autocomplete="off">
                <el-form-item prop="name" label="Nama" :required="true">
                    <el-input v-model="formUser.name" autocomplete="one-time-code" autocorrect="off" spellcheck="false" />
                </el-form-item>
                <el-form-item prop="npk" label="NPK" :required="true">
                    <el-input v-model="formUser.npk" autocomplete="one-time-code" autocorrect="off" spellcheck="false" />
                </el-form-item>
                <el-form-item prop="email" label="Email" :required="true">
                    <el-input type="email" v-model="formUser.email" autocomplete="one-time-code" autocorrect="off"
                        spellcheck="false" />
                </el-form-item>
                <el-form-item prop="password" label="Password" :required="true" v-if="!editMode">
                    <el-input type="password" v-model="formUser.password" autocomplete="one-time-code" autocorrect="off"
                        spellcheck="false" />
                </el-form-item>
            </el-form>
            <template #footer>
                <span class="dialog-footer flex">
                    <el-button class=" flex-grow" @click="closeDialog">Cancel</el-button>
                    <el-button class=" flex-grow" v-if="!editMode" type="primary" @click="addUserSubmitAction">Submit</el-button>
                    <el-button class=" flex-grow" v-if="editMode" type="primary" @click="editUserSubmitAction">Update</el-button>
                </span>
            </template>
        </el-dialog>
    </MainLayout>
</template>
<script setup>
import { ref, reactive } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import {
    DxColumn,
    DxColumnChooser,
    DxDataGrid,
    DxExport,
    DxHeaderFilter,
    DxFilterRow,
    DxItem,
    DxSelection,
    DxToolbar
} from 'devextreme-vue/data-grid';
import { exportDataGrid } from 'devextreme/excel_exporter';

import CustomStore from "devextreme/data/custom_store";
import axios from 'axios';
import { computed } from 'vue';
import BsButton from '@/Components/BsButton.vue';
import { ElMessage, ElMessageBox } from 'element-plus';
import { Workbook } from 'exceljs';
import { saveAs } from 'file-saver';
import BsIcon from '@/Components/BsIcon.vue';
import BsIconButton from '@/Components/BsIconButton.vue';

// DIALOG FORM
const formUserRef = ref();
const dialogFormVisible = ref(false);
const editMode = ref(false);
const formUser = reactive({
    user_id: '',
    name: '',
    npk: '',
    email: '',
    password: '',
});
function closeDialog() {
    dialogFormVisible.value = false;
}
function addUserAction() {
    editMode.value = false;
    dialogFormVisible.value = true;

    formUser.user_id = '';
    formUser.name = '';
    formUser.npk = '';
    formUser.email = '';
    formUser.password = '';
}
async function addUserSubmitAction() {
    await formUserRef.value.validate((valid, _) => {
        if (valid) {
            axios.post('/api/user', formUser)
                .then((response) => {
                    var responseData = response.data;
                    ElMessage({
                        message: responseData.msg,
                        type: 'success',
                    });
                    refreshDatagrid();
                })
                .catch((error) => {
                    var errorResponseData = error.response.data;
                    ElMessage({
                        message: errorResponseData.msg,
                        type: 'error',
                    });
                })
                .finally(() => {
                    dialogFormVisible.value = false;
                });
        }
    });
}
function editUserAction(dataUser) {
    editMode.value = true;
    dialogFormVisible.value = true;

    formUser.user_id = dataUser.user_id;
    formUser.name = dataUser.name;
    formUser.npk = dataUser.npk;
    formUser.email = dataUser.email;
    formUser.password = '';
}
async function editUserSubmitAction() {
    await formUserRef.value.validate(async (valid, _) => {
        if (valid) {
            axios.put('/api/user/'+formUser.user_id, formUser)
                .then((response) => {
                    var responseData = response.data;
                    ElMessage({
                        message: responseData.msg,
                        type: 'success',
                    });
                    refreshDatagrid();
                })
                .catch((error) => {
                    var errorResponseData = error.response.data;
                    ElMessage({
                        message: errorResponseData.msg,
                        type: 'error',
                    });
                })
                .finally(() => {
                    dialogFormVisible.value = false;
                });
        }
    });
}
function deleteUserAction(dataUser) {
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
            axios.delete('/api/user/'+dataUser.user_id)
                .then((response) => {
                    var responseData = response.data;
                    ElMessage({
                        message: responseData.msg,
                        type: 'success',
                    });
                    refreshDatagrid();
                })
                .catch((error) => {
                    var errorResponseData = error.response.data;
                    ElMessage({
                        message: errorResponseData.msg,
                        type: 'error',
                    });
                })
                .finally(() => {
                });
        })
        .catch(() => {
            ElMessage({
                type: 'info',
                message: 'Menghapus user dibatalkan',
            })
        })
}
function switchUserStatus(dataUser, status){
    axios.put('/api/user/'+dataUser.user_id+'/switch-status', {is_active:status})
        .then((response) => {
            var responseData = response.data;
            ElMessage({
                message: responseData.msg,
                type: 'success',
            });
            refreshDatagrid();
        })
        .catch((error) => {
            var errorResponseData = error.response.data;
            ElMessage({
                message: errorResponseData.msg,
                type: 'error',
            });
        })
        .finally(() => {
            dialogFormVisible.value = false;
        });
}

// DEVEXTREME DATAGRID
const datagridRef = ref();
const allMode = ref("page");
const dataGridAction = ref("index");
const btnEditVisible = ref(false);
const btnDeleteVisible = ref(false);
const dataSelected = ref([]);

var itemSelected = computed(()=> dataSelected.value.length > 0);
var dataProcessingUrl = computed(() => usePage().props.dataProcessingUrl);

const remoteOperations = ref({
    paging: true,
    filtering: true,
    sorting: true,
});

function isNotEmpty(value) {
    return value !== undefined && value !== null && value !== "";
};

const dataSource = new CustomStore({
    key: "user_id",
    load: function (loadOptions) {
        let params = "?";
        ["skip", "take", "requireTotalCount", "sort", "filter"].forEach(
            function (i) {
                if (i in loadOptions && isNotEmpty(loadOptions[i])) {
                    params += `${i}=${JSON.stringify(loadOptions[i])}&`;
                }
            }
        );
        params = params.slice(0, -1);

        if (dataGridAction.value == "select.all") {
            if (allMode.value == "allPages") {
                return axios.get(dataProcessingUrl.value, { params: params })
                    .then((response) => {
                        dataGridAction.value = "index";
                        data = response.data;
                    })
                    .catch((error) => { });
            } else {
                dataGridAction.value = "index";
            }
        } else {
            return axios.get(dataProcessingUrl.value + params)
                .then((response) => {
                    dataGridAction.value = "index";
                    return response.data;
                })
                .catch((error) => { });
        }
    }.bind(this),
});

function refreshDatagrid() {
    datagridRef.value.instance.refresh();
};

function onSelectionChanged(data) {
    dataSelected.value = data.selectedRowsData;

    if (data.selectedRowKeys.length < 1) {
        btnEditVisible.value = false;
        btnDeleteVisible.value = false;
    } else if (data.selectedRowKeys.length == 1) {
        btnEditVisible.value = true;
        btnDeleteVisible.value = true;
    } else {
        btnEditVisible.value = false;
        btnDeleteVisible.value = false;
    }
};

function onExporting(e) {
    const workbook = new Workbook();
    const worksheet = workbook.addWorksheet('Employees');
    var fileName = "data-users"

    exportDataGrid({
        component: e.component,
        worksheet,
        autoFilterEnabled: true,
    }).then(() => {
        workbook.xlsx.writeBuffer().then((buffer) => {
            saveAs(new Blob([buffer], { type: 'application/octet-stream' }), fileName + '.xlsx');
        });
    });

    e.cancel = true;
};

function statusText(data) {
    return data.value == 0 ? 'Tidak Aktif' : 'Aktif';
}

function clearSelection(){
    const dataGrid = datagridRef.value.instance;
    dataGrid.clearSelection();
    dataSelected.value = [];
}

</script>

<style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.2s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
</style>