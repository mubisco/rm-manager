<script setup lang="ts">
</script>

<template>
  <v-card
    title="My Characters"
  >
    <v-card-text>
      <v-table v-cy:mypc-table>
        <thead>
          <tr>
            <th>Character name</th>
            <th>System</th>
            <th>Level</th>
            <th>Creation date</th>
            <th>Last update</th>
            <th>Status</th>
            <th />
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Chindasvinto</td>
            <td>HARP</td>
            <td>2</td>
            <td>01-21-2021</td>
            <td>01-21-2021</td>
            <td>Free</td>
            <td>
              <v-btn
                v-cy:character-details-btn
                icon="mdi-eye"
                size="sm"
                variant="text"
                :to="{ name: 'Character', params: { characterId: 'e77590e9-96f4-434d-9071-afe87c290329' }}"
              />
            </td>
          </tr>
          <tr>
            <td>Chindasvinto II</td>
            <td>HARP</td>
            <td>2</td>
            <td>01-21-2021</td>
            <td>01-21-2021</td>
            <td>In a game</td>
            <td>
              <v-btn
                icon="mdi-eye"
                size="sm"
                variant="text"
              />
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-card-text>
    <v-card-actions class="justify-end">
      <v-btn
        append-icon="mdi-plus-circle-outline"
        variant="elevated"
        :to="{ name: 'CreateCharacter' }"
      >
        Crear
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
