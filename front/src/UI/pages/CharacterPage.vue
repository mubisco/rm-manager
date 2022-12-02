<script setup lang="ts">
import { ref } from 'vue'
import SummaryTab from '@/UI/components/Character/SummaryTab.vue'
import SkillsTab from '@/UI/components/Character/SkillsTab.vue'
import InventoryTab from '@/UI/components/Character/InventoryTab.vue'
import NotesTab from '@/UI/components/Character/NotesTab.vue'
import CombatTab from '@/UI/components/Character/CombatTab.vue'
const characterTabs = ref([
  { tag: 'summary', icon: 'mdi-chart-box' },
  { tag: 'skills', icon: 'mdi-dice-d10' },
  { tag: 'inventory', icon: 'mdi-bag-personal' },
  { tag: 'notes', icon: 'mdi-note-edit' },
  { tag: 'combat', icon: 'mdi-sword-cross' }
])
const tab = ref('one')
</script>

<template>
  <v-card
    color="primary"
    class="mb-2"
  >
    <template #title>
      <div class="d-flex justify-space-between">
        Samthilasian "Sam"
        <v-chip>
          In Game
        </v-chip>
      </div>
    </template>
  </v-card>
  <v-card>
    <v-tabs
      v-model="tab"
      v-cy:character-tab-menu
    >
      <v-tab
        v-for="(characterTab, index) in characterTabs"
        :key="index"
        v-cy:character-tab-option
        :value="characterTab.tag"
      >
        <v-icon class="mr-1">
          {{ characterTab.icon }}
        </v-icon>
        {{ $t('character.tabs.' + characterTab.tag) }}
      </v-tab>
    </v-tabs>

    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="summary">
          <SummaryTab />
        </v-window-item>
        <v-window-item value="skills">
          <SkillsTab />
        </v-window-item>
        <v-window-item value="inventory">
          <InventoryTab />
        </v-window-item>
        <v-window-item value="notes">
          <NotesTab />
        </v-window-item>
        <v-window-item value="combat">
          <CombatTab />
        </v-window-item>
      </v-window>
    </v-card-text>
    <v-card-actions>
      <v-btn
        variant="text"
        :to="{ name: 'Dashboard' }"
      >
        Volver
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
