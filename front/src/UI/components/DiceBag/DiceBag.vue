<script setup lang="ts">
import { DiceBag } from '@/Domain/DiceBag/DiceBag'
import { RollResultDto } from '@/Domain/DiceBag/RollResultDto'
import { computed, watch, defineEmits, ref } from 'vue'
import RollBreakdown from './RollBreakdown.vue'

const diceBag = ref<DiceBag>(DiceBag.fromString('1D10'))
const rolledResult = ref<RollResultDto | null>(null)
const manualTotal = ref(null)

const emit = defineEmits<{(eventName: 'dicebag:rolled', totalValue: RollResultDto): number }>()
const props = defineProps<{ diceBagDefinition: string }>()

watch(() => props.diceBagDefinition, () => {
  diceBag.value = DiceBag.fromString('10d10+10')
  manualTotal.value = null
  rolledResult.value = null
})

const rollWasMade = computed((): boolean => {
  return rolledResult.value !== null
})

const rollDice = () => {
  rolledResult.value = diceBag.value.roll()
  manualTotal.value = null
}

const confirmRoll = () => {
  if (rolledResult.value !== null) {
    emit('dicebag:rolled', rolledResult.value)
    return
  }
  emit(
    'dicebag:rolled',
    { total: manualTotal.value ?? 0, rollBreakdown: [], modifier: 0 }
  )
}
</script>
<template>
  <div class="pa-1 text-center">
    <h2 class="text-h5 mb-6">
      {{ $t('diceBag.title') }}
    </h2>
    <v-btn
      class="mb-6"
      variant="outlined"
      prepend-icon="mdi-dice-multiple"
      :disabled="rollWasMade"
      @click="rollDice"
    >
      {{ $t('diceBag.roll', { 'dice': diceBag.toString() }) }}
    </v-btn>
    <v-text-field
      v-if="!rollWasMade"
      v-model="manualTotal"
      :label="$t('diceBag.manual-input')"
      density="compact"
      type="number"
    />
    <RollBreakdown
      v-if="rollWasMade"
      :roll-breakdown="rolledResult?.rollBreakdown ?? []"
      :total-rolled="rolledResult?.total ?? 0"
      :modifier="rolledResult?.modifier ?? 0"
    />
    <div
      v-if="manualTotal || rollWasMade"
    >
      <v-btn
        block
        prepend-icon="mdi-check-bold"
        @click="confirmRoll"
      >
        {{ $t('diceBag.confirm') }}
      </v-btn>
    </div>
  </div>
</template>
