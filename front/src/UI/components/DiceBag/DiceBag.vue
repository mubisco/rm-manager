<script setup lang="ts">
</script>
<template>
  <div class="pa-1 text-center">
    <h2 class="text-h5 mb-6">
      {{ $t('diceBag.title') }}
    </h2>
    <v-btn
      class="mb-6"
      variant="outlined"
      prepend-icon="mdi-dice-multiple"
    >
      {{ $t('diceBag.roll', { 'dice': '10d10 + 10' }) }}
    </v-btn>
    <v-text-field
      :label="$t('diceBag.manual-input')"
      density="compact"
      type="number"
      class="text-right"
    />
    <v-expansion-panels
      class="mb-6"
    >
      <v-expansion-panel
        :title="$t('diceBag.total', { total: '54' })"
      >
        <v-expansion-panel-text>
          <v-list
            density="compact"
            nav
          >
            <v-list-item
              prepend-icon="mdi-dice-d10"
              title="6"
            />
            <v-list-item
              prepend-icon="mdi-dice-d10"
              title="6"
            />
            <v-list-item
              prepend-icon="mdi-dice-d10"
              title="6"
            />
            <v-list-item
              prepend-icon="mdi-dice-d10"
              title="6"
            />
            <v-list-item
              prepend-icon="mdi-plus"
              title="10"
            />
            <v-list-item
              prepend-icon="mdi-minus"
              title="10"
            />
          </v-list>
        </v-expansion-panel-text>
      </v-expansion-panel>
    </v-expansion-panels>
    <v-btn
      block
      prepend-icon="mdi-check-bold"
    >
      {{ $t('diceBag.confirm') }}
    </v-btn>
  </div>
</template>
