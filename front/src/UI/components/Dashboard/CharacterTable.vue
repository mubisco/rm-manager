<script setup lang="ts">
// code...
</script>

<template>
  <v-card
    title="My Characters"
  >
    <v-table v-cy:mypc-table>
      <thead>
        <tr>
          <th>Character name</th>
          <th>System</th>
          <th>Level</th>
          <th>Creation date</th>
          <th>Last update</th>
          <th>Status</th>
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
        </tr>
        <tr>
          <td>Chindasvinto II</td>
          <td>HARP</td>
          <td>2</td>
          <td>01-21-2021</td>
          <td>01-21-2021</td>
          <td>In a game</td>
        </tr>
      </tbody>
    </v-table>
  </v-card>
</template>
