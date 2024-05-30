<script setup lang="ts">
import { VNodeRenderer } from '@layouts/components/VNodeRenderer';
import { themeConfig } from '@themeConfig';

import crossIcon from '@images/icons/cross.png';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter()
const route = useRoute()
const isDataReady = ref(false)

definePage({
  meta: {
    layout: 'blank',
    notRequiredSubscription: true,
    action: 'manage',
    subject: 'member',
  },
})

const getData = async (token: string) => {
  try {
    const res = await $api(`/v1/subscriptions/token/${token}`, {
      method: 'GET',
      onResponseError({ response }) {
        const { status } = response

        if (status == 404) {
          router.replace('/404')
        }
      },
    })

    isDataReady.value = true
  }
  catch (err) {
    console.error(err)
  }
}

onMounted(() => {
  if (route.params.id) {
    getData(route.params.id)
  }
})

</script>

<template>
  <RouterLink to="/">
    <div class="auth-logo d-flex align-center gap-x-3">
      <VNodeRenderer :nodes="themeConfig.app.logo" />
    </div>
  </RouterLink>

  <VRow
    v-if="isDataReady"
    no-gutters
    class="auth-wrapper"
  >
    <VCol
      cols="12"
      class="auth-card-v2 d-flex align-center justify-center pa-10"
      style="background-color: rgb(var(--v-theme-surface));"
    >
      <VCard
        class="mt-12 mt-sm-10 text-center pa-10"
        style="max-inline-size: 681px; width: 100%;"
      >
        <img
          width="70"
          :src="crossIcon"
          color="high-emphasis"
          class="mb-2"
        />
        <h2 class="h2 mb-2">Your subscriptions has failed!</h2>
        <p class="mt-2 mb-8 mx-auto" style="width: 400px;">Hey there. Your subscription was unsuccessful. Please check your customer details or check your payment information.</p>

        <RouterLink
          :to="{ name: 'register' }"
          
        >
          <VBtn
            style="width: 200px;"
            type="submit"
          >
            Continue
          </VBtn>
        </RouterLink>
      </VCard>
    </VCol>
  </VRow>
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
