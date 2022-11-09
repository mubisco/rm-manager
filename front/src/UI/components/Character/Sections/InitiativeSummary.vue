<script setup lang="ts">
import { ref, computed } from 'vue'

const values = ref({
  quickness: 6,
  insight: 3,
  racial: 0,
  other: 5
})

const total = computed((): number => {
  return values.value.quickness + values.value.insight + values.value.racial + values.value.other
})

</script>

<template>
  <v-card
    flat
    border
    :title="$t('character.sections.initiative.title')"
  >
    <v-card-text>
      <v-table density="compact">
        <thead>
          <tr>
            <th>{{ $t('character.sections.initiative.headings.stat') }}</th>
            <th>{{ $t('character.sections.initiative.headings.racial') }}</th>
            <th>{{ $t('character.sections.initiative.headings.other') }}</th>
            <th>{{ $t('character.sections.initiative.headings.total') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ values.quickness + values.insight }}</td>
            <td>{{ values.racial }}</td>
            <td>{{ values.other }}</td>
            <td>{{ total }}</td>
          </tr>
        </tbody>
      </v-table>
    </v-card-text>
  </v-card>
</template>

