<script setup lang="ts">
import { ref, computed } from 'vue'
const valid = ref(false)
const email = ref('')
const password = ref('')
const canLogin = computed(() => email.value != '' && password.value !== '')
</script>

<template>
  <v-card width="550">
    <v-card-header>
      <v-card-header-text>
        <v-card-title class="text-primary">
          Login
        </v-card-title>
      </v-card-header-text>
    </v-card-header>
    <v-card-text>
      <v-form v-model="valid">
        <div>
          <v-text-field
            v-model="email"
            label="E-mail"
            variant="outlined"
            color="primary"
            required
          />
        </div>
        <div>
          <v-text-field
            v-model="password"
            label="Password"
            variant="outlined"
            color="primary"
            type="password"
            required
          />
        </div>
        <p class="text-right">
          Forgot your password?
        </p>
      </v-form>
    </v-card-text>
    <v-card-actions class="d-flex justify-end">
      <v-btn
        color="primary"
        :disabled="!canLogin"
      >
        Login
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
