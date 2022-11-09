<script setup lang="ts">
import { ref, computed } from 'vue'

const values = ref({
  armor: 'Retales',
  bd: 46,
  quickness: 0,
  magic: 0,
  chiDefense: 0,
  shield: 25,
  other: 5
})
const total = computed((): number => {
  return values.value.bd + values.value.quickness + values.value.magic + values.value.chiDefense + values.value.shield + values.value.other
})

</script>

<template>
  <v-card
    flat
    border
    :title="$t('character.sections.defense.title')"
  >
    <v-card-text>
      <v-table density="compact">
        <thead>
          <tr>
            <th>{{ $t('character.sections.defense.headings.armor') }}</th>
            <th>{{ $t('character.sections.defense.headings.bd') }}</th>
            <th>{{ $t('character.sections.defense.headings.quickness') }}</th>
            <th>{{ $t('character.sections.defense.headings.magic') }}</th>
            <th>{{ $t('character.sections.defense.headings.chiDefense') }}</th>
            <th>{{ $t('character.sections.defense.headings.shield') }}</th>
            <th>{{ $t('character.sections.defense.headings.other') }}</th>
            <th>{{ $t('character.sections.defense.headings.total') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ values.armor }}</td>
            <td>{{ values.bd }}</td>
            <td>{{ values.quickness }}</td>
            <td>{{ values.magic }}</td>
            <td>{{ values.chiDefense }}</td>
            <td>{{ values.shield }}</td>
            <td>{{ values.other }}</td>
            <td>{{ total }}</td>
          </tr>
        </tbody>
      </v-table>
    </v-card-text>
  </v-card>
</template>
