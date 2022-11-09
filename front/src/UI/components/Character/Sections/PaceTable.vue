<script setup lang="ts">
import { ref } from 'vue'

const basicMovement = ref(2.1)

</script>

<template>
  <v-card
    flat
    border
    :title="$t('character.sections.pace.title')"
  >
    <v-card-text>
      <v-table density="compact">
        <tbody>
          <tr>
            <th>{{ $t('character.sections.pace.walk') }}</th>
            <td class="text-right">
              {{ basicMovement }}
            </td>
          </tr>
          <tr>
            <th>{{ $t('character.sections.pace.run') }}</th>
            <td class="text-right">
              {{ (basicMovement * 2).toFixed(2) }}
            </td>
          </tr>
          <tr>
            <th>{{ $t('character.sections.pace.fastRun') }}</th>
            <td class="text-right">
              {{ (basicMovement * 3).toFixed(2) }}
            </td>
          </tr>
          <tr>
            <th>{{ $t('character.sections.pace.sprint') }}</th>
            <td class="text-right">
              {{ (basicMovement * 4).toFixed(2) }}
            </td>
          </tr>
          <tr>
            <th>{{ $t('character.sections.pace.dash') }}</th>
            <td class="text-right">
              {{ (basicMovement * 5).toFixed(2) }}
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-card-text>
  </v-card>
</template>
