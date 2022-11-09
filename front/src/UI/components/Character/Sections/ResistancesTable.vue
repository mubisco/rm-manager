<script setup lang="ts">
import { ref } from 'vue'

const values = ref({
  stamina: 20,
  will: 10,
  magic: 0
})

</script>

<template>
  <v-card
    flat
    border
    :title="$t('character.sections.resistances.title')"
  >
    <v-card-text>
      <v-table density="compact">
        <thead>
          <tr>
            <th>{{ $t('character.sections.resistances.headings.stamina') }}</th>
            <th>{{ $t('character.sections.resistances.headings.will') }}</th>
            <th>{{ $t('character.sections.resistances.headings.magic') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ values.stamina }}</td>
            <td>{{ values.will }}</td>
            <td>{{ values.magic }}</td>
          </tr>
        </tbody>
      </v-table>
    </v-card-text>
  </v-card>
</template>
