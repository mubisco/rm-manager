<script setup lang="ts">
import ItemsTable from './Inventory/ItemsTable.vue'
import ArmourItemsTable from './Inventory/ArmourItemsTable.vue'
import BagpackItemsTable from './Inventory/BagpackItemsTable.vue'
import MoneyTable from './Inventory/MoneyTable.vue'
</script>

<template>
  <v-row>
    <v-col cols="12">
      <MoneyTable />
    </v-col>
  </v-row>
  <v-row>
    <v-col cols="4">
      <ItemsTable />
    </v-col>
    <v-col cols="4">
      <BagpackItemsTable />
    </v-col>
    <v-col cols="4">
      <ArmourItemsTable />
    </v-col>
  </v-row>
</template>
