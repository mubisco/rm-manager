<script setup lang="ts">
import { CultureName } from '@/Application/Culture/Query/CultureName'
import { FetchAllCultureNamesQueryHandler } from '@/Application/Culture/Query/FetchAllCultureNamesQueryHandler'
import { CultureCode } from '@/Domain/Character/Culture/CultureCode'
import { FileCultureReadModel } from '@/Infrastructure/Character/Culture/ReadModel/File/FileCultureReadModel'
import { ref, onMounted } from 'vue'

const props = defineProps<{ modelValue: CultureCode | null }>()
const emit = defineEmits<{(eventName: 'update:modelValue', selectedRace: CultureCode): void }>()

const value = ref(props.modelValue ?? '')
const cultureNames = ref<CultureName[]>([])

onMounted(async () => {
  const handler = new FetchAllCultureNamesQueryHandler(new FileCultureReadModel())
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
