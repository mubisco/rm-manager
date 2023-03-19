<script setup lang="ts">
import { watch, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useDicebagStore } from '@/UI/stores/dicebag'
import { v4 as uuidv4 } from 'uuid'

const props = defineProps<{ method: string, points: number }>()

const rollKey = ref(uuidv4())
const selectedMethod = ref(props.method ?? '')
const availablePoints = ref(props.points ?? 0)
const dicebagStore = useDicebagStore()
const { totalRolled } = storeToRefs(dicebagStore)

watch(totalRolled, () => {
  if (dicebagStore.rollKey === rollKey.value) {
    manualPointsUpdate(totalRolled.value)
  }
})

const emit = defineEmits<{(eventName: 'update:method', selectedOption: string): string,
  (eventName: 'update:points', selectedOption: number): number
}>()

const manualPointsUpdate = (points: number): void => {
  availablePoints.value = points
  emit('update:points', points)
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
      v-show="selectedMethod === 'POINTS_WITH_ROLL'"
    >
      <div class="d-flex">
        <v-btn
          prepend-icon="mdi-dice-d10-outline"
          class="mr-4"
          @click="dicebagStore.requestRoll(rollKey, '10d10')"
        >
          {{ $t('character.stats-step.roll-action') }}
        </v-btn>
        <div class="text-field-wrapper">
          <v-text-field
            v-model="availablePoints"
            density="compact"
            readonly
            type="number"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.text-field-wrapper {
  width: 100px;
}
</style>
