<template>
    <Head title="Dashboard" />
    <MainLayout>
        <p class="text-xl font-bold mb-5">Dashboard</p>
        <div class="grid grid-cols-3 grid-flow-row-dense gap-4">
            <div class="col-span-1 p-4 rounded-xl border border-gray-400 flex-1">
                <div class="flex flex-row justify-between mb-4">
                    <div>
                        <div class="font-bold">Monthly Production</div>
                        <div class="font-thin text-gray-700 text-sm">Agustus 2023</div>
                    </div>
                    <div>
                    </div>
                </div>
                <div ref="chartdiv" class="h-80 w-full"></div>
            </div>
            <div class="col-span-2 p-4 rounded-xl border border-gray-400">
                <div class="flex flex-row justify-between mb-4">
                    <div>
                        <div class="font-bold">Monthly Production</div>
                        <div class="font-thin text-gray-700 text-sm">Agustus 2023</div>
                    </div>
                    <div>
                    </div>
                </div>
                <DxDataGrid
                    :data-source="dataSource"
                    key-expr="product_id"
                    @cell-prepared="onCellPrepared"
                >
                    <DxFilterRow
                        :visible="true"
                    />
                    <DxSelection
                        select-all-mode="page"
                        show-check-boxes-mode="always"
                        mode="multiple"
                    />
                    <DxColumn
                        data-field="product"
                        caption="Product"
                    />
                    <DxColumn
                        data-field="quantity"
                        caption="Quantity"
                    >
                        <DxFormat
                            type="fixedPoint"
                            :precision="0"
                        />
                    </DxColumn>
                    <DxColumn
                        data-field="target"
                        caption="Target"
                    >
                        <DxFormat
                            type="fixedPoint"
                            :precision="0"
                        />
                    </DxColumn>
                    <DxColumn
                        caption="Capaian"
                        cell-template="percentage-cell-template"
                        alignment="center"
                    />
                    <template #percentage-cell-template="{data}">
                        <div class="p-2 rounded-md text-white" :class="[
                            {'bg-primary':data.data.quantity >= data.data.target},
                            {'bg-secondary':data.data.quantity < data.data.target},
                        ]">
                            {{ Math.round(parseInt(data.data.quantity)/parseInt(data.data.target) * 100) }} %
                        </div>
                    </template>
                </DxDataGrid>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';

import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import am4themes_pkt_themes from "@/Core/Config/am4themes_pkt_themes";

import {
    DxDataGrid,
    DxColumn,
    DxFormat,
    DxFilterRow,
    DxSelection,
} from 'devextreme-vue/data-grid';

const dataSource = [{
        "product_id":1,
        "product": "Ammonia",
        "quantity": 62567,
        "target": 60000,
    }, {
        "product_id":2,
        "product": "Urea",
        "quantity": 85293,
        "target": 90000
    }, {
        "product_id":3,
        "product": "NPK",
        "quantity": 40568,
        "target": 50000
    }, {
        "product_id":4,
        "product": "Other",
        "quantity": 32476,
        "target": 50000
    }];

// Devextreme
const columns = ['product', 'quantity', 'target'];
const onCellPrepared = (e) => {
    if (e.rowType === 'header' && e.column.dataType != 'boolean') {
        e.cellElement.style.textAlign = 'left';
    }
}


// Amchart
const chartdiv = ref(null);
onMounted(() => {
    am4core.addLicense("CH283435101");
    am4core.useTheme(am4themes_animated);
    am4core.useTheme(am4themes_pkt_themes);

    var chart = am4core.create(chartdiv.value, am4charts.PieChart);

    chart.data = dataSource;

    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "quantity";
    pieSeries.dataFields.category = "product";
    pieSeries.dataFields.hidden = "hidden";

    chart.innerRadius = am4core.percent(40);

    pieSeries.labels.template.disabled = true;
    pieSeries.ticks.template.disabled = true;

    pieSeries.slices.template.tooltipText = "";

    chart.legend = new am4charts.Legend();
    chart.legend.position = "bottom";
    chart.legend.fontSize = 10;

    var markerTemplate = chart.legend.markers.template;
    markerTemplate.width = 15;
    markerTemplate.height = 15;
});

</script>