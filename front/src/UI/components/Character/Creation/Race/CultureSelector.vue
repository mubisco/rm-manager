<script setup lang="ts">
import { CultureName } from '@/Domain/Character/Culture/CultureName'
import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { FetchAllCultureNamesQueryHandler } from '@/Application/Culture/Query/FetchAllCultureNamesQuery'
import { FileCultureRepository } from '@/Infrastructure/Character/Culture/Persistance/File/FileCultureRepository'
import { ref, onMounted } from 'vue'

const props = defineProps<{ modelValue: CultureCode | null }>()
const emit = defineEmits<{(eventName: 'update:modelValue', selectedRace: CultureCode): void }>()

const value = ref(props.modelValue ?? '')
const cultureNames = ref<CultureName[]>([])

onMounted(async () => {
  const handler = new FetchAllCultureNamesQueryHandler(new FileCultureRepository())
  cultureNames.value = await handler.handle()
})

const onValueUpdated = (event: string) => {
  emit('update:modelValue', event as CultureCode)
}

</script>
<template>
  <v-select
    v-model="value"
    :label="$t('character.culture.select-culture')"
    :items="cultureNames"
    item-title="name"
    item-value="code"
    @update:model-value="onValueUpdated"
  />
</template>
