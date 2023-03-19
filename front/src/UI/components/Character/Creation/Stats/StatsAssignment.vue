<script setup lang="ts">
import { watch, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useDicebagStore } from '@/UI/stores/dicebag'
const dicebagStore = useDicebagStore()
const { totalRolled } = storeToRefs(dicebagStore)

watch(totalRolled, () => {
  rolledResults.value = dicebagStore.breakdown
})

defineProps<{ availablePoints: number, selectedMethod: string }>()
const statsCodes = ref(['ST', 'CO', 'AG', 'QU', 'SD', 'RE', 'IN', 'PR'])
const rolledResults = ref<number[]>([])
</script>
<template>
  <div>
    <p>{{ selectedMethod }} - {{ availablePoints }}</p>
    <v-row>
      <v-col cols="2">
        <div>
          <v-chip
            v-for="(roll, index) in rolledResults"
            :key="index"
            draggable
            variant="tonal"
            color="primary"
          >
            {{ roll }}
          </v-chip>
        </div>
        <v-btn
          block
          prepend-icon="mdi-dice-d10-outline"
          class="mr-4"
          @click="dicebagStore.requestRoll('8d100')"
        >
          Roll 8D100
        </v-btn>
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
