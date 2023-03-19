<script setup lang="ts">
defineProps<{ rollBreakdown: number[], totalRolled: number, modifier: number }>()
</script>
<template>
  <v-expansion-panels
    class="mb-6"
  >
    <v-expansion-panel
      :title="$t('diceBag.total', { total: totalRolled })"
    >
      <v-expansion-panel-text>
        <v-list
          density="compact"
        >
          <v-list-item
            v-for="(result, index) in rollBreakdown"
            :key="index"
            prepend-icon="mdi-dice-d10"
            :title="result"
          />
          <v-list-item
            v-if="modifier !== 0"
            :prepend-icon="modifier > 0 ? 'mdi-plus' : 'mdi-minus'"
            :title="modifier"
          />
        </v-list>
      </v-expansion-panel-text>
    </v-expansion-panel>
  </v-expansion-panels>
</template>
