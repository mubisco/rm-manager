<script setup lang="ts">
// code...
</script>

<template>
  <v-row>
    <v-col md="6">
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
    </v-col>
    <v-col md="6">
      <v-card
        title="My Games"
      >
        <v-table v-cy:mygames-table>
          <thead>
            <tr>
              <th>Game name</th>
              <th>Master</th>
              <th>Start date</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>HARP</td>
              <td>Perra master</td>
              <td>01-21-2021</td>
              <td>Active</td>
            </tr>
          </tbody>
        </v-table>
      </v-card>
    </v-col>
  </v-row>
</template>
