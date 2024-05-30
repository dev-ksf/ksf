<script setup lang="ts">
import { VNodeRenderer } from '@layouts/components/VNodeRenderer';
import { themeConfig } from '@themeConfig';

import { useCookie } from '@/@core/composable/useCookie';
import checkIcon from '@images/icons/check.png';
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';


definePage({
  meta: {
    layout: 'blank',
    notRequiredSubscription: true,
    action: 'manage',
    subject: 'member',
  },
})

const router = useRouter()
const route = useRoute()
const isDataReady = ref(false)

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

    const { userData } =  res

    useCookie('userData').value = userData
    isDataReady.value = true
  }
  catch (err) {
    console.error(err)
  }
}

onMounted(() => {
  localStorage.removeItem('selectedPlan')
  if (route.params.token) {
    getData(route.params.token)
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
          :src="checkIcon"
          color="high-emphasis"
          class="mb-2"
        />
        <h2 class="h2 mb-2">Subscriptions Successfull!</h2>
        <p class="mt-2 mb-8 mx-auto" style="width: 400px;">You have successfully registered to KS Financials and now have access to KSF Member’s Portal.</p>
        <RouterLink
          :to="{ name: 'login' }"
          
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

function definePage(arg0: { meta: { layout: "blank"; notRequiredSubscription: boolean; action: string; subject: string; }; }) {
  throw new Error('Function not implemented.');
}

function definePage(arg0: { meta: { layout: "blank"; notRequiredSubscription: boolean; action: string; subject: string; }; }) {
  throw new Error('Function not implemented.');
}
