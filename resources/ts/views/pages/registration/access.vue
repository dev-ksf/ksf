<script setup lang="ts">

import { useToast } from "vue-toastification";
import { VForm } from 'vuetify/components/VForm';

const toast = useToast();


const ability = useAbility()

const emit = defineEmits(['onSuccess'])

const isPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)
const isFormSubmitted = ref(false)
const refForm1 = ref<VForm>()


const errors = ref<Record<string, string | undefined>>({
  email: undefined,
  password: undefined,
  confirmPassword: undefined,
})

const form = ref({
  email: '',
  password: '',
  confirmPassword: '',
})

const onSubmit = async () => {
  
  const { valid } = await refForm1.value?.validate()
  
  if (valid) {
    isFormSubmitted.value = true
    try {
      const res = await $api('/v1/register', {
        method: 'POST',
        body: {
          ...form.value
        },
        onResponseError({ response }) {
          errors.value = response._data.errors

          toast.error(response._data.message, {
            position: "top-right",
            timeout: 4851,
            closeOnClick: true,
            pauseOnFocusLoss: true,
            pauseOnHover: true,
            draggable: true,
            draggablePercent: 1.01,
            showCloseButtonOnHover: true,
            hideProgressBar: false,
            closeButton: false,
            icon: true,
            rtl: false
          });

          isFormSubmitted.value = false
        },
      })

      await nextTick(() => {
        const { accessToken, userData, userAbilityRules } = res

        useCookie('userAbilityRules').value = userAbilityRules
        ability.update(userAbilityRules)

        useCookie('userData').value = userData
        useCookie('accessToken').value = accessToken

        emit('onSuccess')
      })
    }
    catch (err) {
      isFormSubmitted.value = false
      console.error(err)
    }
  }
}

</script>

<template>
  <div style="margin: 0 auto; width: 600px;">
    <h4 class="text-h4">
        Create a account to start your membership
    </h4>
    <p class="text-body-1 mb-6">
        Just a few more steps and you're done!
    </p>
    <VForm
        ref="refForm1"
        @submit.prevent="onSubmit"
    >
        <VRow>
            <VCol
            cols="12"
            md="12"
            >
            <AppTextField
                v-model="form.email"
                label="Email"
                placeholder="johndoe@email.com"
                :rules="[requiredValidator, emailValidator]"
                :error-messages="errors ? errors.email : ''"
            />
            </VCol>

            <VCol
            cols="12"
            md="6"
            >
            <AppTextField
                v-model="form.password"
                label="Password"
                placeholder="············"
                :rules="[requiredValidator]"
                :error-messages="errors.password"
                :type="isPasswordVisible ? 'text' : 'password'"
                hint="At least 8 characters"
                :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
            />
            </VCol>

            <VCol
            cols="12"
            md="6"
            >
            <AppTextField
                v-model="form.confirmPassword"
                label="Confirm Password"
                placeholder="············"
                :rules="[requiredValidator, confirmedValidator(form.password, form.confirmPassword)]"
                :error-messages="errors.confirmPassword"
                :type="isConfirmPasswordVisible ? 'text' : 'password'"
                hint="At least 8 characters"
                :append-inner-icon="isConfirmPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
            />
            </VCol>
            <VCol
                cols="12"
                class="d-flex justify-center"
            >
                <VBtn
                    v-if="!isFormSubmitted"
                    block
                    type="submit"
                >
                    NEXT
                </VBtn>
                <VProgressCircular
                    v-else
                    indeterminate
                    color="primary"
                />
            </VCol>
        </VRow>
    </VForm>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";

.illustration-image {
  block-size: 550px;
  inline-size: 248px;
}

.bg-image {
  inset-block-end: 0;
}
</style>
