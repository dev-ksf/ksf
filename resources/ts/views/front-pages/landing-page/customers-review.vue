<script setup lang="ts">
import { register } from 'swiper/element/bundle'

import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'

register()


// Customer Review Data
const reviewData = [
  {
    desc: '"I would recommend KSF to friends and Family. The CEO and President both are passionate, driven, trustworthy individuals who give good service, sound financial advice, and always have your best interest at heart."',
    name: 'CHRISTY RAAGAS',
    position: 'Entrepreneur',
    avatar: avatar1,
  },
  {
    desc: '"Yes I would recommend KSF! Many people need your services and many lack proper information and education about financial services scope of your firm. Pricing was fair and worth it!"',
    name: 'MARVIN DA SILVA',
    position: 'Business Coach, Investor, COO, Cowboy Grill',
    avatar: avatar2,
  },
  {
    desc: '"Yes! Madalas ko talaga ni recommend at iri-recommend pa ang KSF. Dahil malaki ang naging tulong KSF sa akin at sa family ko. Because of KSF, naiayos ang business and personal finance namin, at naunawaan ko ang beauty ng insurance. I also have regular update and visit with the CEO and President na supper accommodating sa lahat ng questions ko!"',
    name: 'MARCIA PAJANONOT',
    position: 'Pharmacy Owner/Registered Pharmacist',
    avatar: avatar3,
  },
  {
    desc: '"I would definitely recommend KSF! 😊 I love how passionate they are in their field. They will lay down all the options you can choose, never hesitate to address any concern or queries. They help me and my husband to have an insight how to deal with finances and plan for the future."',
    name: 'LEALYN BUAL-ORAÑA',
    position: '(Placeholder)',
    avatar: avatar4,
  },
  /* {
    desc: 'KSFinancials is awesome, and I particularly enjoy knowing that if I get stuck on something, there is always a helpful community to assist me.',
    img: logo3,
    rating: 5,
    name: 'Tommy haffman',
    position: 'Founder of Levis',
    avatar: avatar5,
  },
  {
    desc: 'I\'ve never used a theme as versatile and flexible as KSFinancials. It\'s my go to for building dashboard sites on almost any project.',
    img: logo1,
    rating: 5,
    name: 'Eugenia Moore',
    position: 'Founder of Hubspot',
    avatar: avatar1,
  },
  {
    desc: 'KSFinancials is awesome, and I particularly enjoy knowing that if I get stuck on something, there is always a helpful community to assist me.',
    img: logo2,
    rating: 5,
    name: 'Tommy haffman',
    position: 'Founder of Levis',
    avatar: avatar2,
  },
  {
    desc: 'This template is superior in so many ways. The code, the design, the regular updates, the support.. It\'s the whole package. Excellent Work.',
    img: logo3,
    rating: 4,
    name: 'Eugenia Moore',
    position: 'CTO of Airbnb',
    avatar: avatar3,
  },
  {
    desc: 'All the requirements for developers have been taken into consideration, so I\'m able to build any beautiful interface I want.',
    img: logo4,
    rating: 4,
    name: 'Sara Smith',
    position: 'Founder of Continental',
    avatar: avatar4,
  },
  {
    desc: 'This template is really clean & well documented. The docs are really easy to understand and it\'s always easy to find a screenshot from their website.',
    img: logo2,
    rating: 5,
    name: 'Curtis Fletcher',
    position: 'Design Lead at Dribbble',
    avatar: avatar5,
  }, */
]

const customerReviewSwiper = ref(null)

const slide = (dir: string) => {
  const swiper = customerReviewSwiper.value?.swiper

  if (dir === 'prev') swiper.slidePrev()
  else swiper.slideNext()
}
</script>

<template>
  <div
    id="testimonials"
    class="position-relative"
  >
    <div class="customer-reviews">
      <VContainer>
        <!-- 👉 Headers  -->
        <VRow>
          <VCol cols="12">
            <!-- 👉 Add Header and Subheader -->
            <div class="align-middle">
              <h1 class="header-title">
                What Our Clients Say
              </h1>
              <p class="header-subtitle">
                Discover why they trust KSF for financial <br /> success and services
              </p>
            </div>
          </VCol>

          <VCol
            cols="12"
          >
            <!-- 👉 Customer Review Swiper -->
            <div class="swiper-reviews-carousel">
              <!-- eslint-disable vue/attribute-hyphenation -->
              <swiper-container
                ref="customerReviewSwiper"
                slides-per-view="1"
                space-between="20"
                loop="true"
                autoplay-delay="3000"
                autoplay-disable-on-interaction="false"
                events-prefix="swiper-"
                :injectStyles="[
                  `
                    .swiper{
                      padding-block: 12px;
                      padding-inline: 12px;
                      margin-inline: -12px;
                    }
                    .swiper-button-next, .swiper-button-prev{
                      visibility: hidden;
                    }
                  `,
                ]"
                navigation="{
                  nextEl: '.swiper-button-next',
                  prevEl: '.swiper-button-prev',
                }"
                :breakpoints="{
                  1280: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                  },
                  960: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                  },
                  600: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                  },
                }"
              >
                <swiper-slide
                  v-for="(data, index) in reviewData"
                  :key="index"
                >
                  <VCard class="d-flex h-100 align-stretch">
                    <VCardText class="pa-8 d-flex flex-column justify-space-between align-start">
                      <p class="text-body-1 testimonial-body" style="font-family: 'League Spartan', 'sans-serif';">
                        {{ data.desc }}
                      </p>

                      <div>
                        <VAvatar
                          :image="data.avatar"
                          size="60"
                        />
                        <div class="mt-3">
                          <h6 class="text-h6">
                            {{ data.name }}
                          </h6>

                          <div class="text-body-2 text-disabled">
                            {{ data.position }}
                          </div>
                        </div>
                      </div>
                    </VCardText>
                  </VCard>
                </swiper-slide>
              </swiper-container>
            </div>
            <!-- Button container below the Swiper -->
            <div class="button-pagination-container mt-16">
              <VBtn color="primary" class="reviews-button-prev custom-button" @click="slide('prev')">
                <VIcon left class="mr-1">tabler-arrow-left</VIcon> Previous
              </VBtn>

              <VBtn color="primary" class="reviews-button-next custom-button" @click="slide('next')">
                Next <VIcon right class="ml-1">tabler-arrow-right</VIcon>
              </VBtn>
            </div>
          </VCol>
        </VRow>
      </VContainer>
    </div>
  </div>
</template>

<style scoped lang="scss">
swiper-container {
  display: flex;
  flex-direction: column;

  .swiper {
    padding-block-end: 3rem;
  }

  .avatar-border {
    border: 2px solid rgb(68, 119, 186); 
    border-radius: 50%; 
  }
}
</style>

<style lang="scss">
@media (max-width: 600px) {
  .customer-reviews {
    padding-block: 4rem;
    background-image: radial-gradient(circle at center, #b6e7ee, #e1f5fe 0%);
  }
}

.button-pagination-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.card-equal-height {
  margin-bottom: 100px;
  height: 500px;
  flex-grow: 1;
}

.reviews-button-prev,
.reviews-button-next {
  margin-top: -40px;
  position: relative;
  z-index: 1;
}

.card-footer {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 10px;
}

.align-middle {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  margin-bottom: 40px;
}

.header-title {
  font-size: 2rem;
}

.header-subtitle {
  font-size: 15px;
  font-weight: 500;
}

.custom-button {
  border-radius: 30px !important;
  color: #000000 !important;
  background-color: transparent !important;
  border: 1px solid;
  padding: 0px 20px !important;
  width: 150px;

  &:hover,
  &:focus {
    background-color: var(--v-theme-surface) !important;
    color: #fff !important;
  }
}
</style>


<style scoped>
.custom-bg {
  background: radial-gradient(circle at center, rgba(159, 233, 243, 0.5) 10%, rgba(205, 237, 252, 0.5) 50%, transparent 60%);
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
.testimonial-body {
  height: 280px;
  line-height: 28px;
}
</style>

<style>
.swiper-pagination-bullet {
  width: 20px; /* Adjust the size of the bullet */
  height: 20px;
  background: transparent;
  border: 2px solid #000;
  border-radius: 50%; /* Makes the bullet circular */
  opacity: 0.7;
}

.swiper-pagination-bullet-active {
  background: #000;
  opacity: 1;
}
</style>
