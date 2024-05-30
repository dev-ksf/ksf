<script setup lang="ts">

import logoWhite from '@images/white-logo.png';

interface Menu {
  name: string
  to: any
  isNew?: boolean
}
</script>

<template>
  <div class="footer">
    <VContainer>
      <div
        class="footer-row py-10 mt-5"
        style="border-block-end: 0.2px solid #ececec81;"
      >
        <VRow>
          <VCol cols="12" md="6">
            <img
              :src="logoWhite"
              alt="ksfinancialsph"
              width="134"
            >
          </VCol>
          <VCol cols="12" md="6" class="text-right">
            <a
              href="\"
              target="_blank"
              class="footer-title"
            >Contact us</a>

            <a
              href="\"
              target="_blank"
              class="footer-title"
            >
              Privacy Policy</a>

            <a
              href="\"
              target="_blank"
              class="footer-title"
            >
              Terms & Conditions
            </a>
          </VCol>
        </VRow>
      </div>
      <div class="footer-line w-100 py-10">
        <a style="color: #ececec81; font-size: 16px; font-weight: 300; margin-block-start: 2rem;">Copyright © ksfinancialsph, {{ new Date().getFullYear() }}. All Rights Reserved</a>
      </div>
    
    </VContainer>
  </div>
</template>

<style scoped lang="scss">
.footer {
  background-color: #3e7dc0;
}

.footer-row {
  display: flex;
  flex-direction: row;
  align-items: center;
  block-size: 50%;
  inline-size: 100%;
  a {
    font-size: 16px !important;
    font-weight: 300;
  }
}

.footer-title {
  block-size: fit-content;
  color: #ececec81;
  font-size: small;
  margin-inline-start: 2rem;
}

@media (max-width: 700px) {
  .footer-row {
    padding-top: 0px !important;
  }
  .footer-line {
    padding: 10px 0px !important;
  }
}
</style>
