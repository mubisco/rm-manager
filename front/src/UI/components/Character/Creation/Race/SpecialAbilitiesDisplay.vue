<script setup lang="ts">
import { SpecialAbilityDescription } from '@/Domain/Character/Profession/Race/SpecialAbilityDescription'

defineProps<{
  abilities: { [key: string]: SpecialAbilityDescription },
  optionalAbilities: { [key: string]: SpecialAbilityDescription } | null
}>()
</script>
<template>
  <p class="text-subtitle-2">
    Habilidades Especiales
  </p>
  <p
    v-for="(ability, key) in abilities"
    :key="key"
  >
    <span class="text-caption">
      {{ ability.name }}:
    </span>
    {{ ability.description }}
  </p>
  <div
    v-if="Object.keys(optionalAbilities).length > 0"
  >
    <v-divider />
    <v-alert
      type="info"
      variant="tonal"
      density="compact"
      class="mb-2"
    >
      El personaje tendrá tres habilidades especiales. Las dos indicadas más arriba y UNA de las dos opciones indicadas aquí abajo. Antes de proseguir con la creación de su personaje, el jugador deberá escoger una.
    </v-alert>
    <p
      v-for="(ability, key) in optionalAbilities"
      :key="key"
    >
      <span class="text-caption">
        {{ ability.name }}:
      </span>
      {{ ability.description }}
    </p>
    <v-divider />
  </div>
</template>
