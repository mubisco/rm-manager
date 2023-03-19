<script setup lang="ts">
import { ProfessionKey } from './ProfessionKey'
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

interface TranslatedProfession {
  title: string,
  value: string
}

const { t } = useI18n()

const props = defineProps<{ options: ProfessionKey[], modelValue: ProfessionKey | null }>()

const value = ref(props.modelValue ?? '')

const emit = defineEmits<{(eventName: 'update:modelValue', selectedProfession: string): ProfessionKey }>()

const parsedOptions = computed((): TranslatedProfession[] => {
  const translatedProfessions: TranslatedProfession[] = []
  for (const option of props.options) {
    translatedProfessions.push(
      {
        value: option,
        title: t('character.profession.names.' + option)
      }
    )
  }
  return translatedProfessions.sort(
    (a: TranslatedProfession, b: TranslatedProfession): number => a.title < b.title ? -1 : 1
  )
})

const updateValue = (event: string) => {
  emit('update:modelValue', event)
}

</script>
<template>
  <v-select
    v-model="value"
    :label="$t('character.profession.select')"
    :items="parsedOptions"
    item-title="title"
    item-value="value"
    @update:model-value="updateValue"
  />
</template>
