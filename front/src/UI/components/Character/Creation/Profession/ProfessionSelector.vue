<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { ProfessionNamesQueryHandlerProvider } from '@/Infrastructure/Character/Provider/ProfessionNamesQueryHandlerProvider'
import { ProfessionName } from '@/Application/Profession/Query/ProfessionName'
import { ProfessionCode } from '@/Domain/Character/Profession/ProfessionCode'

const professionNames = ref<ProfessionName[]>([])

const props = defineProps<{ modelValue: ProfessionCode | null }>()

const value = ref(props.modelValue ?? '')

const emit = defineEmits<{(eventName: 'update:modelValue', selectedProfession: string): ProfessionCode }>()

onMounted(async () => {
  const provider = new ProfessionNamesQueryHandlerProvider()
  const handler = provider.provide()
  professionNames.value = await handler.handle()
})

const onValueUpdated = (event: string) => {
  emit('update:modelValue', event as ProfessionCode)
}

</script>
<template>
  <v-select
    v-model="value"
    :label="$t('character.profession.select')"
    :items="professionNames"
    item-title="name"
    item-value="code"
    @update:model-value="onValueUpdated"
  />
</template>
