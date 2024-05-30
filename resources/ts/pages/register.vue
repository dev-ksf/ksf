<script setup lang="ts">
import Registration from '@/views/pages/registration/access.vue';
import Membership from '@/views/pages/registration/membership.vue';

import { VNodeRenderer } from '@layouts/components/VNodeRenderer';
import { themeConfig } from '@themeConfig';

const isLoggedIn = ref(false)
const isMember = ref(false)

definePage({
  meta: {
    layout: 'blank'
  },
})

const checkUser = async () => {
  await nextTick(() => {
    isLoggedIn.value = !!(useCookie('userData').value && useCookie('accessToken').value)

    const userData: any = useCookie('userData').value

    isMember.value = !!(userData && userData.membership)
  })
}


onMounted(() => {
  checkUser()
})

</script>

<template>
  <RouterLink to="/">
    <div class="auth-logo d-flex align-center gap-x-3">
      <VNodeRenderer :nodes="themeConfig.app.logo" />
    </div>
  </RouterLink>
  <VRow
    no-gutters
    class="auth-wrapper"
  >
    <VCol
      cols="12"
      class="auth-card-v2 d-flex align-center justify-center pa-10"
      style="background-color: rgb(var(--v-theme-surface));"
    >
      <VCard
        flat
        class="mt-12 mt-sm-10 py-10"
        style="max-inline-size: 1000px; width: 100%;"
      >
        <Registration v-if="!isLoggedIn && !isMember" @onSuccess="checkUser()"/>
        <Membership v-else-if="isLoggedIn && !isMember"/>
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

.v-card {
  overflow: unset;
}
</style>
