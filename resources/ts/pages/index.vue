<script setup lang="ts">
import Footer from '@/views/front-pages/front-page-footer.vue'
import Navbar from '@/views/front-pages/front-page-navbar.vue'
import About from '@/views/front-pages/landing-page/about.vue'
import Benefits from '@/views/front-pages/landing-page/benefits.vue'
import CustomersReview from '@/views/front-pages/landing-page/customers-review.vue'
import FaqSection from '@/views/front-pages/landing-page/faq-section.vue'
import HeroSection from '@/views/front-pages/landing-page/hero-section.vue'
import PricingPlans from '@/views/front-pages/landing-page/pricing-plans.vue'

definePage({
  meta: {
    layout: 'blank',
    public: true,
  },
})

const activeSectionId = ref()

const refWhy = ref()
const refCompany = ref()
const refTestimonials = ref()
const refMembership = ref()

useIntersectionObserver(
  [refWhy, refCompany, refTestimonials, refMembership],
  ([{ isIntersecting, target }]) => {
    if (isIntersecting)
      activeSectionId.value = target.id
  },
  {
    threshold: 0.25,
  },
)
</script>

<template>
  <div class="landing-page-wrapper">
    <Navbar :active-id="activeSectionId" />

    <!-- 👉 Hero Section  -->
    <div :style="{ 'background-color': 'rgb(var(--v-theme-surface))' }">
      <HeroSection/>
    </div>

    <!-- 👉 About  -->
    <div :style="{ 'background-color': 'rgb(var(--v-theme-surface))' }">
      <About ref="refWhy" />
    </div>

    <!-- 👉 Company Benefits  -->
    <div :style="{ 'background-color': 'rgb(var(--v-theme-surface))' }">
      <Benefits ref="refCompany" />
    </div>

    <!-- 👉 Customer Review -->
    <div :style="{ 'background-color': 'rgb(var(--v-theme-surface))' }">
      <CustomersReview ref="refTestimonials"/>
    </div>


    <!-- 👉 Pricing Plans -->
    <div :style="{ 'background-color': 'rgb(var(--v-theme-surface))' }">
      <PricingPlans ref="refMembership"/>
    </div>

    <!-- 👉 FAQ Section -->
    <div :style="{ 'background-color': 'rgb(var(--v-theme-surface))' }">
      <FaqSection/>
    </div>


    <!-- 👉 Footer -->
    <Footer />
  </div>
</template>

<style lang="scss">
@media (max-width: 960px) and (min-width: 600px) {
  .landing-page-wrapper {
    .v-container {
      padding-inline: 2rem !important;
    }
  }
}
</style>
