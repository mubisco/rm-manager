<script setup lang="ts">

defineProps<{ availablePoints: number }>()
</script>
<template>
  <div class="d-flex justify-space-between align-center mt-3">
    {{ $t('character.stats-step.available-points') }}
    <v-chip
      color="primary"
      class="ml-2"
      label
    >
      {{ availablePoints }}
    </v-chip>
  </div>
  <v-table class="mt-4">
    <thead>
      <tr>
        <th>{{ $t('character.stats-step.dp-costs.range') }}</th>
        <th>{{ $t('character.stats-step.dp-costs.cost') }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1 - 90</td>
        <td>1</td>
      </tr>
      <tr>
        <td>91 - 95</td>
        <td>2</td>
      </tr>
      <tr>
        <td>96 - 100</td>
        <td>3</td>
      </tr>
      <tr>
        <td>101 - 105</td>
        <td>10</td>
      </tr>
    </tbody>
  </v-table>
</template>
