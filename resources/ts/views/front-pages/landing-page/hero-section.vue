<script setup lang="ts">
import { useGenerateImageVariant } from '@/@core/composable/useGenerateImageVariant'
import heroDashboardImgDark from '@images/front-pages/landing-page/hero-dashboard-dark.png'
import heroDashboardImgLight from '@images/front-pages/landing-page/hero-dashboard-light.png'
import { useTheme } from 'vuetify'

import heroElementsImgDark from '@images/front-pages/landing-page/hero-elements-dark.png'
import heroElementsImgLight from '@images/front-pages/landing-page/hero-elements-light.png'

const theme = useTheme()

const heroElementsImg = useGenerateImageVariant(heroElementsImgLight, heroElementsImgDark)
const heroDashboardImg = useGenerateImageVariant(heroDashboardImgLight, heroDashboardImgDark)
</script>

<template>
  <div
    id="home"
    :style="{ background: 'white' }"
  >
    <div id="landingHero">
      <div
        class="landing-hero"
        :class="theme.current.value.light ? 'landing-hero-light-bg' : 'landing-hero-light-bg'"
      >
        <VContainer>
          <div class="hero-text-box text-center px-2">
            <h1 class="hero-title mt-16 mb-2">
              The first Insurtech Company
            </h1>
            <h2 class="mb-2 text-h2">
              that offers a Membership Program that has
            </h2>
          </div>
        </VContainer>
      </div>
    </div>

    <VContainer class="py-16">
      <VRow>
        <VCol
          cols="12"
          md="6"
        >
          <div class="card-1 container">
            <h2
              style="color: black;
              font-weight: 500;
              margin-block: 2.5rem 1rem;
              margin-inline-start: 1rem;"
            >
              HMO with fixed annual membership fee
            </h2>
            <div class="image-container">
              <img
                src="@images/front-pages/landing-page/lite.png"
                alt="lite"
                style="
                  border-radius: 5%;
                  block-size: 460px;
                  inline-size: 455px;
                  object-fit: fill;
                  padding-block-start: 15px;"
              >
              <img
                src="@images/front-pages/landing-page/platinum.png"
                alt="platinum"
                style="
                  border-radius: 5%;
                  block-size: 460px;border-start-start-radius: 4%;
                  inline-size: 455px;
                  object-fit: fill;
                  padding-block-start: 15px;"
              >
              <img
                src="@images/front-pages/landing-page/titanium.png"
                alt="titanium"
                style="border-radius: 4%;
                    block-size: 460px;
                    inline-size: 455px;
                    object-fit: fill;
                    padding-block-start: 8px;"
              >
              <img
                src="@images/front-pages/landing-page/diamond.png"
                alt="diamond"
                style="border-radius: 5%;
                    block-size: 460px;
                    inline-size: 455px;
                    object-fit: fill;
                    padding-block-start: 15px;"
              >
            </div>
          </div>
        </VCol>
        <VCol
          cols="12"
          md="6"
        >
          <VRow>
            <VCol cols="12" md="6">
              <div class="card-2">
                <div class="card-text">
                  <h2
                    style="color: black;
                font-weight: 500;
                margin-inline-start: 2rem;
                padding-block-start: 1.5rem;"
                  >
                    Does not increase every 5 years
                  </h2>
                </div>
                <img src="@images/front-pages/landing-page/icon1.png">
              </div>
            </VCol>

            <VCol cols="12" md="6">
              <div class="card-3">
                <div class="card-text">
                  <h2
                    style="color: black;
                font-weight: 500;
                margin-inline-start: 2rem;
                padding-block-start: 1.5rem;"
                  >
                    Covers 18-64 years old
                  </h2>
                </div>
                <img src="@images/front-pages/landing-page/icon2.png">
              </div>
            </VCol>

            <VCol cols="12" md="12">
              <div class="card-4">
                <div class="card-text">
                  <h2
                    style="color: black;
                font-weight: 500;
                margin-inline-start: 2rem;
                padding-block-start: 1.5rem;"
                  >
                    Can add dependent from 0-21 years old
                  </h2>
                </div>
                <img
                  src="@images/front-pages/landing-page/depend.png"
                  style="
                  block-size: 210px;inline-size: 420px;
                  margin-inline-start: 10rem;
                  transform: translateY(2rem);"
                >
              </div>
            </VCol>
          </VRow>
        </VCol>
      </VRow>
    </VContainer>
  </div>

  
</template>

<style lang="scss" scoped>
.card-text {
  inline-size: 80%;
}

.image-container {
  display: flex;
  align-items: center;
  animation: sweep 12s linear infinite alternate;
  block-size: max-content;
  gap: 10px;
  inline-size: 38.9rem;
  padding-block-start: 2rem;
  padding-inline-start: 5rem;
}

@keyframes sweep {
  0% {
    transform: translateX(0);
  }

  100% {
    transform: translateX(calc(-220%));
  }
}

.card-1 {
  overflow: hidden;
  flex-grow: 1;
  background-color: #e9f4ff;
  border-start-end-radius: 2%;
  border-start-start-radius: 2%;
}

.card-2, .card-3 {
  overflow: hidden;
  border-radius: 5%;
  background-color: #e9f4ff;
  max-height: 270px;
}

.card-2 img {
  block-size: 20rem;
  inline-size: 19rem;
  margin-inline-start: 5rem;
  transform: translateY(-1.2rem);
}

.card-3 img {
  block-size: 21rem;
  inline-size: 19rem;
  margin-inline-start: 5rem;
  transform: translateY(-3rem);
}

.card-4 {
  overflow: hidden;
  border-radius: 5%;
  background-color: #e9f4ff;
}

.card-4 img {
  block-size: 21rem;
  inline-size: 19rem;
  margin-inline-start: 5rem;
  transform: translateY(-3rem);
}

.card {
  border-radius: 15px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 20%);
  transition: 0.3s;
}

.container {
  position: relative;
  overflow: hidden;
  border-radius: 5px;
  padding-inline: 16px;
}

.landing-hero {
  inline-size: 100%;
  padding-block: 16rem 16rem;
}

.landing-hero::before {
  position: absolute;
  background-repeat: no-repeat;
  inset-block: 0;
  opacity: 0.5;
}

.landing-hero-dark-bg {
  background-color: #fff;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.landing-hero-light-bg {
  background: center no-repeat, linear-gradient(#b5d9ff 20%, #fff 50%);
  background-size: cover;
}

@media (min-width: 650px) {
  .hero-text-box {
    inline-size: 80rem;
    margin-block-end: 1rem;
    margin-inline: auto;
  }
}

@media (max-width: 599px) {
  .hero-title {
    font-size: 8vw !important;
    line-height: 10vw !important;
  }
}

@media (max-width: 599px) {
  .text-h2 {
    font-size: 6vw !important;
    line-height: 10vw !important;
  }
}

.hero-title {
  animation: shine 2s ease-in-out infinite alternate;
  background: linear-gradient(90deg, #1b1a1a 0%, #1b1a1a 37%, #3e7dc0 37%, #3e7dc0 100%);
  background-clip: text;
  font-size: 65px;
  font-weight: 800;
  inline-size: 100%;
  line-height: 70px;
  padding-block: 0;
  padding-inline: 20px;
  text-align: center;
  -webkit-text-fill-color: rgba(0, 0, 0, 0%);
}

@keyframes shine {
  0% {
    background-position: 0% 50%;
  }

  80% {
    background-position: 50% 90%;
  }

  100% {
    background-position: 91% 100%;
  }
}

.hero-dashboard-img {
  margin-block: 0;
  margin-inline: auto;
  transform-style: preserve-3d;
  transition: all 0.35s;

  img {
    inline-size: 100%;
  }
}

.hero-elements-img {
  position: absolute;
  inset-block: 0;
  inset-inline-start: 0;
}

.feature-cards {
  margin-block-start: 6.25rem;
}

.hero-btn-item {
  inset-block-start: 80%;
  inset-inline-start: 5%;
}

.text-h2 {
  color: black;
  font-weight: 550;
}
</style>
