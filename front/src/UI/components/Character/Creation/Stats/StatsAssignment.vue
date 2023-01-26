<script setup lang="ts">
import { defineProps } from 'vue'

defineProps<{ availablePoints: number, selectedMethod: string }>()
</script>
<template>
  <div>
    <p>{{ selectedMethod }} - {{ availablePoints }}</p>
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
        <tr>
          <td>{{ $t('character.stats.ST') }}</td>
          <td>
            <div class="d-flex">
              <v-btn
                prepend-icon="mdi-dice-d10-outline"
                class="mr-4"
              >
                {{ $t('character.stats-step.roll-action') }}
              </v-btn>
              <v-text-field
                density="compact"
                type="number"
                class="text-right"
              />
            </div>
          </td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>{{ $t('character.stats.CO') }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>{{ $t('character.stats.AG') }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>{{ $t('character.stats.QU') }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>{{ $t('character.stats.SD') }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>{{ $t('character.stats.RE') }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>{{ $t('character.stats.IN') }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>{{ $t('character.stats.PR') }}</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>
