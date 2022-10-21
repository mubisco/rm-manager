<script setup lang="ts">
import LoadingButton from '@/UI/components/Shared/LoadingButton.vue'
import { ref, computed, defineEmits, defineProps } from 'vue'

defineProps<{ loading: boolean }>()
defineEmits<{ (eventName: 'send-password-clicked', newPassword: string): Promise<void> }>()
const newPassword = ref('')
const confirmNewPassword = ref('')
const errorOnConfirmPassword = computed(():boolean => {
  return confirmNewPassword.value !== '' && newPassword.value !== confirmNewPassword.value
})
const canResetPassword = computed(():boolean => {
  return confirmNewPassword.value !== '' && newPassword.value !== '' && !errorOnConfirmPassword.value
})
</script>

<template>
  <v-card width="550">
    <v-card-header>
      <v-card-header-text>
        <v-card-title class="text-primary">
          {{ $t('changePassword.title') }}
        </v-card-title>
      </v-card-header-text>
    </v-card-header>
    <v-card-text>
      <v-form
        v-cy:change-password-form
      >
        <v-text-field
          v-model="newPassword"
          v-cy:new-password
          :label="$t('changePassword.newPassword')"
          variant="outlined"
          color="primary"
          type="password"
          required
        />
        <v-text-field
          v-model="confirmNewPassword"
          v-cy:confirm-new-password
          :label="$t('changePassword.confirmPassword')"
          variant="outlined"
          color="primary"
          type="password"
          :error="errorOnConfirmPassword"
          required
        />
      </v-form>
    </v-card-text>
    <v-card-actions class="d-flex justify-end">
      <loading-button
        v-cy:send-new-password
        :button-label="$t('changePassword.send')"
        :enabled="canResetPassword"
        :loading="false"
        @button-clicked="$emit('send-password-clicked', newPassword)"
      />
    </v-card-actions>
  </v-card>
</template>
