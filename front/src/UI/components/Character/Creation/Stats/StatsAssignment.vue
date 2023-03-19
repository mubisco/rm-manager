<script setup lang="ts">
import { ref } from 'vue'

defineProps<{ availablePoints: number, selectedMethod: string }>()
const statsCodes = ref(['ST', 'CO', 'AG', 'QU', 'SD', 'RE', 'IN', 'PR'])
</script>
<template>
  <div>
    <p>{{ selectedMethod }} - {{ availablePoints }}</p>
    <v-row>
      <v-col cols="2">
      </v-col>
      <v-col cols="10">
        <v-table>
          <thead>
            <tr>
              <th>{{ $t('character.stats-step.stats-table.name') }}</th>
              <th>{{ $t('character.stats-step.stats-table.value') }}</th>
              <th>{{ $t('character.stats-step.stats-table.bonus') }}</th>
              <th>{{ $t('character.stats-step.stats-table.dp') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="code in statsCodes"
              :key="code"
            >
              <td>{{ $t('character.stats.' + code) }}</td>
              <td />
              <td />
              <td />
            </tr>
          </tbody>
        </v-table>
      </v-col>
    </v-row>
  </div>
</template>
