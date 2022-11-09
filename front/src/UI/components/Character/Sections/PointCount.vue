<script setup lang="ts">
import { defineProps } from 'vue'

defineProps<{
  title: string,
  max: number,
  current: number
}>()
</script>

<template>
  <v-row>
    <v-col cols="5">
      <span
        class="text-overline"
      >
        {{ title }}
      </span>
    </v-col>
    <v-col cols="2">
      <v-sheet
        border
        rounded
        class="pa-2"
      >
        {{ max }}
      </v-sheet>
    </v-col>
    <v-col cols="5">
      <v-sheet
        border
        rounded
        class="pa-2"
      >
        {{ current }}
      </v-sheet>
    </v-col>
  </v-row>
</template>
