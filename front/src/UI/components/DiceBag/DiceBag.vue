<script setup lang="ts">
import { DiceBag } from '@/Domain/DiceBag/DiceBag'
import { watch, defineEmits, ref } from 'vue'
import RollBreakdown from './RollBreakdown.vue'

const diceBag = ref<DiceBag>(DiceBag.fromString('1D10'))
const rolledTotal = ref(0)
const manualTotal = ref(null)
const breakDown = ref<number[]>([])
const modifier = ref(0)

const emit = defineEmits<{(eventName: 'dicebag:rolled', totalValue: number): number }>()
const props = defineProps<{ diceBagDefinition: string }>()

watch(() => props.diceBagDefinition, () => {
  diceBag.value = DiceBag.fromString('10d10+10')
  rolledTotal.value = 0
  manualTotal.value = null
  breakDown.value = []
  modifier.value = 0
})

const rollDice = () => {
  const result = diceBag.value.roll()
  manualTotal.value = null
  rolledTotal.value = result.total
  breakDown.value = result.rollBreakdown
  modifier.value = result.modifier
}

const confirmRoll = () => {
  const total = manualTotal.value ? manualTotal.value : rolledTotal.value
  emit('dicebag:rolled', total)
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
      :disabled="breakDown.length > 0"
      @click="rollDice"
    >
      {{ $t('diceBag.roll', { 'dice': diceBag.toString() }) }}
    </v-btn>
    <v-text-field
      v-if="breakDown.length === 0"
      v-model="manualTotal"
      :label="$t('diceBag.manual-input')"
      density="compact"
      type="number"
    />
    <RollBreakdown
      v-if="breakDown.length > 0"
      :roll-breakdown="breakDown"
      :total-rolled="rolledTotal"
      :modifier="modifier"
    />
    <div
      v-if="manualTotal || breakDown.length > 0"
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
