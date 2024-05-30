<script setup lang="ts">

const emit = defineEmits(['onSelect'])

interface Plan {
  plan_name: string
  semi_annual_price: number
  annual_price: number
  inclusions: []
}

interface PlanCategory {
  title: string
  is_recommended: number
  semiAnnualPrice: number
  annualPrice: number
  inclusions: [],
  plans: Plan[]
}

let selectedPlanCategory: Ref<Plan[]> = ref([])
let selectedPlanCategoryName: Ref<String> = ref('')
const pricingPlans: Ref<PlanCategory[]> = ref([])

const selectedPlan = ref(null)

const openPlan =  async (plans: Plan[], title: String = '') => {
  selectedPlanCategory.value = plans
  selectedPlanCategoryName.value = title
}

const setSelectedPlan =  async (plan: Plan[]) => {
  await nextTick(() => {
    selectedPlan.value = plan
    selectedPlanCategory.value = []
    localStorage.setItem('selectedPlan', JSON.stringify(plan))
    emit('onSelect', plan)
  })
}

const emptySelectedPlan = async () => {
    selectedPlanCategory.value = []
}

const getData = async () => {
  try {
    const res = await $api('/v1/public/plans/category', {
      method: 'GET',
      onResponseError({ response }) {
        console.log(response)
      },
    })

    pricingPlans.value = res.map((
      {
        id,
        name,
        plans
      } : 
      { 
        id: number,
        name: string,
        plans: any[]
      }
  ) => {

      /**
     * @param {string} name - The name of the pricing plan.
     * @param {Array} plans - An array of plans.
     */

     const hasRecommended = plans.filter( ({is_recommended}) => is_recommended === 1)


      return {
        id,
        title: name,
        is_recommended: !!hasRecommended.length,
        semiAnnualPrice: plans[0].semi_annual_price,
        annualPrice: plans[0].annual_price,
        inclusions: plans[0].inclusions,
        plans
      }
    })
  }
  catch (err) {
    console.error(err)
  }
}

onMounted(() => {
  getData()
  const selectedPlanString = localStorage.getItem('selectedPlan');
  selectedPlan.value = selectedPlanString ? JSON.parse(selectedPlanString) : null
})

</script>

<template>
    <div class="membership">
        <div class="pricing-plans" v-if="!selectedPlanCategory.length">
            <h4 class="text-h4">
                KSF Membership Package
            </h4>
            <p>
                Choose a plan that works best for you and your people.
            </p>
            <VRow>
                <VCol
                    v-for="(plan, index) in pricingPlans"
                    :key="index"
                    sm="6"
                    md="6"
                    lg="3"
                    class="plan-item"
                >
                    <VCard
                    class="cursor-pointer" 
                    :style="plan.is_recommended ? 'border:1px solid rgb(var(--v-theme-warning))' : (selectedPlan && selectedPlan.plan_category_id === plan.id ? 'border:2px solid rgb(var(--v-theme-warning))' : '')"
                    :class="plan.is_recommended ? 'recommended' : (selectedPlan && selectedPlan.plan_category_id === plan.id ? 'selected' : '')"
                    @click="openPlan(plan.plans, plan.title)"
                    >
                    <span
                        v-if="plan.is_recommended"
                        class="bg-warning recommended-tag"
                    >
                        Recommended
                    </span>
                    <VCardText class="pa-7 pt-12">
                        <div class="content">
                        <h4 class="plan-title text-center mb-2">
                            {{ plan.title }}
                        </h4>
                        <div class="d-flex justify-center mb-10 position-relative">
                            <div class="d-flex align-end">
                            <div
                                class="pricing-title text-primary me-1"
                                :class="!plan.is_recommended ? 'text-primary' : 'text-warning'"  
                            >
                                {{ plan.annualPrice }}
                            </div>
                            <span
                                class="text-disabled mb-2"
                                :class="!plan.is_recommended ? 'text-primary' : 'text-warning'"  
                            > per year</span>
                            </div>

                            <!-- 👉 Annual Price -->
                            <span
                            class="annual-price-text position-absolute text-sm text-muted"
                            >
                            {{ plan.monthlyPrice === 0 ? 'free' : `${plan.semiAnnualPrice} per Semi-annual` }}
                            </span>
                        </div>
                        <VList class="card-list">
                            <VListItem
                            v-for="(item, i) in plan.inclusions"
                            :key="i"
                            >
                            <template #prepend>
                                <VAvatar
                                size="14"
                                :variant="'elevated'"
                                :color="!plan.is_recommended ? 'primary' : 'warning'"
                                class="me-2"
                                >
                                <VIcon
                                    icon="tabler-check"
                                    size="12"
                                    color="white"
                                />
                                </VAvatar>
                                <span class="inclusion-name">
                                {{ item.name }}
                                </span>
                            </template>
                            </VListItem>
                        </VList>
                        </div>
                        <VBtn
                            block
                            :variant="plan.is_recommended ? 'elevated' : 'tonal'"
                            :color="plan.is_recommended ? 'warning' : 'primary'"
                            class="btn-subscribe bottom"
                            :class="plan.is_recommended ? '' : 'outline'"
                        >
                            Select
                        </VBtn>
                    </VCardText>
                    </VCard>
                </VCol>
            </VRow>
        </div>
        <div class="pricing-plans" v-else>
            <!-- 👉 Headers  -->
            <div class="headers d-flex justify-start flex-column align-left flex-wrap">
                <h4 class="d-flex align-start text-h4 mb-12 flex-wrap justify-start">
                    <div class="position-relative me-2">
                        <div class=" cursor-pointer" @click="emptySelectedPlan()">
                            <VIcon
                            icon="tabler-arrow-narrow-left"
                            size="28"
                            class="me-2"
                            />
                            KSF Membership Package ({{selectedPlanCategoryName}})
                        </div>  
                    </div>
                </h4>
            </div>
            <VRow class="justify-center">
                <VCol
                    v-for="(plan, index) in selectedPlanCategory"
                    :key="index"
                    sm="6"
                    md="6"
                    lg="3"
                    class="plan-item"
                >
                    <VCard
                    class="cursor-pointer" 
                    :style="plan.is_recommended ? 'border:1px solid rgb(var(--v-theme-warning))' : (selectedPlan && selectedPlan.id === plan.id ? 'border:2px solid rgb(var(--v-theme-warning))' : '')"
                    :class="plan.is_recommended ? 'recommended' : (selectedPlan && selectedPlan.id === plan.id ? 'selected' : '' )"
                    >
                    <span
                        v-if="plan.is_recommended"
                        class="bg-warning recommended-tag"
                    >
                        Recommended
                    </span>
                    <VCardText class="pa-7 pt-12">
                        <div class="content">
                        <h4 class="plan-title text-center mb-2">
                            {{ plan.plan_name }}
                        </h4>
                        <div class="d-flex justify-center mb-10 position-relative">
                            <div class="d-flex align-end">
                            <div
                                class="pricing-title text-primary me-1"
                                :class="!plan.is_recommended ? 'text-primary' : 'text-warning'"  
                            >
                                {{ plan.annual_price }}
                            </div>
                            <span
                                class="text-disabled mb-2"
                                :class="!plan.is_recommended ? 'text-primary' : 'text-warning'"  
                            > per year</span>
                            </div>

                            <!-- 👉 Annual Price -->
                            <span
                            class="annual-price-text position-absolute text-sm text-muted"
                            >
                            {{ plan.semi_annual_price === 0 ? 'free' : `${plan.semi_annual_price} per Semi-annual` }}
                            </span>
                        </div>
                        <VList class="card-list">
                            <VListItem
                            v-for="(item, i) in plan.inclusions"
                            :key="i"
                            >
                            <template #prepend>
                                <VAvatar
                                size="14"
                                :variant="'elevated'"
                                :color="!plan.is_recommended ? 'primary' : 'warning'"
                                class="me-2"
                                >
                                <VIcon
                                    icon="tabler-check"
                                    size="12"
                                    color="white"
                                />
                                </VAvatar>
                                <span class="inclusion-name">
                                {{ item.name }}
                                </span>
                            </template>
                            </VListItem>
                        </VList>
                        </div>
                        <VBtn
                            block
                            :variant="plan.is_recommended ? 'elevated' : 'tonal'"
                            :color="plan.is_recommended ? 'warning' : 'primary'"
                            class="btn-subscribe bottom"
                            :class="plan.is_recommended ? '' : 'outline'"
                            :to="{ name: 'login' }"
                            @click="setSelectedPlan(plan)"
                        >
                            Select
                        </VBtn>
                    </VCardText>
                    </VCard>
                </VCol>
            </VRow>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 8px;
  margin-bottom: 60px;

  .inclusion-name {
    font-size: 12px;
    word-break: word-break;
  }
}

.plan-title {
  font-weight: 600;
  font-size: 34px;
  line-height: 36px;
}
.pricing-title {
  font-size: 24px;
  font-weight: 800;
  line-height: 42px;
}

@media (max-width: 600px) {
  .pricing-plans {
    margin-block: 4rem;
  }
}

.save-upto-chip {
  inset-block-start: -1.5rem;
  inset-inline-end: -7rem;
}

.pricing-plan-arrow {
  inset-block-start: -0.5rem;
  inset-inline-end: -8rem;
}

.section-title {
  font-size: 24px;
  font-weight: 800;
  line-height: 36px;
}

.section-title::after {
  position: absolute;
  background: url("../../../assets/images/front-pages/icons/section-title-icon.png") no-repeat left bottom;
  background-size: contain;
  block-size: 100%;
  content: "";
  font-weight: 700;
  inline-size: 120%;
  inset-block-end: 0;
  inset-inline-start: -12%;
}

.annual-price-text {
  inset-block-end: -40%;
  font-weight: 500;
}
.recommended-tag {
  position: absolute;
  padding: 5px 20px;
  border-radius: 0px 0px 0px 20px;
  font-size: 12px;
  color: #2D2D2D !important;
  right: 0px;
}

.plan-item {
  .v-card {
    height: 100%;
    &.selected {
      box-shadow: -2px 6px 16px 5px rgba(var(--v-shadow-key-umbra-color), var(--v-shadow-md-opacity)), 0 0 transparent, 0 0 transparent;
    }
    &.recommended {
    //   box-shadow: -2px 6px 16px 5px rgba(var(--v-shadow-key-umbra-color), var(--v-shadow-md-opacity)), 0 0 transparent, 0 0 transparent;
    }
    &:hover {
      box-shadow: -2px 6px 16px 5px #FFFBEB !important;
    }
    
    .v-card-text {
      display: flex;
      flex-direction: column;
      height: 100%;
      .content {
        flex: 1;
      }
      .bottom {
        margin-top: auto; /* Pushes this item to the bottom */
      }
      &:hover {
        background-color: #FFFBEB;
      }
    }
  }
}

</style>
<style lang="scss">
.btn-subscribe {
  flex: unset;
  &.outline {
    border: 1px solid;
  }
  .v-btn__underlay {
    background: transparent !important;
  }
}

.membership {
  .v-list {
    background: transparent;
    .v-list-item {
      display: flex !important;
    }
  }
}
</style>
