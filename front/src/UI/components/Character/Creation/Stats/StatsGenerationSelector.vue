<script setup lang="ts">
import { ref, defineProps, computed, defineEmits } from 'vue'

const props = defineProps<{ method: string, points: number }>()

const selectedMethod = ref(props.method ?? '')
const availablePoints = ref(props.points ?? 0)

const emit = defineEmits<{(eventName: 'update:method', selectedOption: string): string,
  (eventName: 'update:points', selectedOption: number): number
}>()

const manualPointsUpdate = (points: number): void => {
  availablePoints.value = points
  updatePoints(points)
}

const updateMethod = (event: string) => {
  if (event === 'ROLL') {
    manualPointsUpdate(0)
  }
  if (event === 'POINTS_FIXED') {
    manualPointsUpdate(50)
  }
  if (event === 'POINTS_WITH_ROLL') {
    manualPointsUpdate(0)
  }
  emit('update:method', event)
}
const updatePoints = (event: number) => {
  emit('update:points', event)
}

const randomAvailable = computed((): boolean => {
  return selectedMethod.value === 'POINTS_WITH_ROLL'
})

const rollPoints = (): void => {
  let total = 0
  for (let i = 0; i < 10; i++) {
    total += rollDice()
  }
  manualPointsUpdate(total)
}

const rollDice = (): number => {
  return Math.floor(Math.random() * (10 - 1 + 1) + 1)
}
</script>
<template>
  <div class="d-flex">
    <div class="flex-grow-1">
      <v-radio-group
        v-model="selectedMethod"
        inline
        @update:model-value="updateMethod"
      >
        <v-radio
          :label="$t('character.stats-step.method.roll')"
          color="primary"
          value="ROLL"
        />
        <v-radio
          :label="$t('character.stats-step.method.points-fixed')"
          color="primary"
          value="POINTS_FIXED"
        />
        <v-radio
          :label="$t('character.stats-step.method.points-rolled')"
          color="primary"
          value="POINTS_WITH_ROLL"
        />
      </v-radio-group>
    </div>
    <div
      v-show="randomAvailable"
    >
      <div class="d-flex">
        <v-btn
          prepend-icon="mdi-dice-d10-outline"
          class="mr-4"
          @click="rollPoints"
        >
          {{ $t('character.stats-step.roll-action') }}
        </v-btn>
        <v-text-field
          v-model="availablePoints"
          density="compact"
          type="number"
          class="text-right"
          @update:model-value="updatePoints"
        />
      </div>
      <p class="text-caption m0">
        <v-icon
          icon="mdi-information-outline"
          size="x-small"
        />
        {{ $t('character.stats-step.roll-info') }}
      </p>
    </div>
  </div>
</template>