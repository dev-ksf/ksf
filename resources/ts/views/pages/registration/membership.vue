

<script setup lang="ts">
import ChoosePlan from '@/views/pages/registration/choose-plan.vue';

import { useToast } from "vue-toastification";
import { VForm } from 'vuetify/components/VForm';

import xenditIcon from '@images/pages/xenditi.png';

const route = useRoute()
const router = useRouter()
const toast = useToast();


const currentStep = ref(0)
const refForm2 = ref<VForm>()
const refForm3 = ref<VForm>()


const items = [
  {
    title: 'Plan',
    subtitle: 'Select Plan',
    icon: 'tabler-file-analytics',
  },
  {
    title: 'Personal',
    subtitle: 'Customer Details',
    icon: 'tabler-user',
  },
  {
    title: 'Billing',
    subtitle: 'Order Summary',
    icon: 'tabler-credit-card',
  },
]

const dependents = ref([])

const errors = ref<Record<string, string | undefined>>({
  firstName: undefined,
  lastName: undefined,
  companyName: undefined,
  mobile: undefined,
  zipcode: undefined,
  address: undefined,
  landmark: undefined,
  city: undefined,
  state: undefined,
  acceptTerms: undefined,
  paymentMethod: undefined,
  name: undefined,
  birth_date: undefined,
  relationship: undefined
})

const form = ref({
  firstName: '',
  lastName: '',
  companyName: '',
  mobile: '',
  zipcode: '',
  address: '',
  landmark: '',
  city: '',
  state: null,
  hasDifShippingAddress: false,
  selectedPlan: '0',
  paymentMethod: '',
  acceptTerms: false,
})

const shippingAddress = ref({
  zipcode: '',
  address: '',
  landmark: '',
  city: '',
  state: null
})

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

const stateOptions = ref([])
const selectedPlan = ref(null)
const selectedTerm = ref(null)

const paymentMethodOptions = [
  {
    name: 'Credit Card (Xendit)',
    icon: xenditIcon,
    value: 'xendit',
  }
]

const planOptions = computed(() => {
  
    let options = []

    options.push({
      name: 'Semi-annual (6 months)',
      product_name: selectedPlan.value?.plan_name,
      term: 6,
      price: selectedPlan.value?.semi_annual_price,
      id: selectedPlan.value?.id,
      dependentPrice: selectedPlan.value?.semi_annual_dependent_price || 0
    })

    options.push({
      name: 'Annual (12 months)',
      product_name: selectedPlan.value?.plan_name,
      term: 12,
      price: selectedPlan.value?.annual_price,
      id: selectedPlan.value?.id,
      dependentPrice: selectedPlan.value?.annual_dependent_price || 0
    })

    return options; // or some default value
})

const totalDependentCost = ref(0)

const subTotal = computed(() => {
  // Check if selectedTerm.value exists and has a price property
  if (selectedTerm.value && 'price' in selectedTerm.value) {
    const planPrice = selectedTerm.value.price;
    return planPrice;
  }

  // If selectedTerm.value is undefined or null, return 0
  return 0;
})

const totalCost = computed(() => {
  totalDependentCost.value = selectedTerm.value.dependentPrice*dependents.value.length
  return subTotal.value + totalDependentCost.value
})

const onNext = async () => {

  let isValid = false
  if (currentStep.value === 0) {
    isValid = !!selectedPlan.value
    if (!isValid) {
        toast.error('Please select plan', {
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
        })
    }
  }

  if (currentStep.value === 1) {
    const { valid } = await refForm2.value?.validate()
    isValid = valid
  }

  if (isValid) {
    currentStep.value++
  }
  
}

const onSubmit = async () => {
  
  const { valid } = await refForm3.value?.validate()
  
  if (valid) {
    try {
      const userData: any = useCookie('userData').value
      const res = await $api('/v1/subscribe', {
        method: 'POST',
        body: {
          ...form.value,
          userId: userData.id,
          selectedTerm: selectedTerm.value,
          shippingAddress: shippingAddress.value,
          dependents: dependents.value
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
        },
      })

      const { action } = res

      await nextTick(() => {
        if (!action) {
          router.replace(route.query.to ? String(route.query.to) : '/login')
        } else {
          // localStorage.setItem(,)
          window.location = action
        }
        
      })
    }
    catch (err) {
      console.error(err)
    }
  }
}

const dependentFields = ref<Data>({
  id: 0,
  name: '',
  relationship: '',
  birth_date: ''
})

const getStateOptions = async () => {
  const res = await useApi('https://geocode-ph.ngnw.ph/province.json')
  const { value } = res.data

  let result = [];
  value.forEach(element => {
    result.push(element.name)
  })
  stateOptions.value = result 
}

const updateSelectedTerm = async (data) => {
  selectedPlan.value = data

  /* default value */
  selectedTerm.value = {
    name: 'Semi-annual (6 months)',
    term: 6,
    product_name: data?.plan_name,
    price: data?.semi_annual_price,
    id: data?.id,
    dependentPrice: data?.semi_annual_dependent_price || 0
  }
}

const deleteDependent = async (index: number) => {
  dependents.value.splice(index, 1)
}

onMounted(() => {
  getStateOptions()

  const selectedPlanString = localStorage.getItem('selectedPlan')
  const selectedPlanValue = selectedPlanString ? JSON.parse(selectedPlanString) : null
  /* default value */
  updateSelectedTerm(selectedPlanValue)
})

</script>

<template>
    <div>
        <AppStepper
            v-model:current-step="currentStep"
            :items="items"
            :direction="$vuetify.display.smAndUp ? 'horizontal' : 'vertical'"
            icon-size="22"
            class="stepper-icon-step-bg mb-12"
            :isActiveStepValid="false"
        />
        <VWindow
            v-model="currentStep"
            class="disable-tab-transition"
            style="max-inline-size: 1000px;"
        >
            <VWindowItem>
               <ChoosePlan @onSelect="updateSelectedTerm($event)" />
            </VWindowItem>
            <VForm
            ref="refForm2"  
            @submit.prevent="() => {}"
            >
            <VWindowItem>
                <h4 class="text-h4">
                Customer Details
                </h4>
                <p>
                Enter Your Customer Details
                </p>

                <VRow>
                    <VCol
                        cols="12"
                        md="6"
                    >
                        <AppTextField
                        v-model="form.firstName"
                        label="First Name"
                        placeholder="John"
                        :rules="[requiredValidator]"
                        :error-messages="errors.firstName"
                        />
                    </VCol>

                    <VCol
                        cols="12"
                        md="6"
                    >
                        <AppTextField
                        v-model="form.lastName"
                        label="Last Name"
                        placeholder="Doe"
                        :rules="[requiredValidator]"
                        :error-messages="errors.lastName"
                        />
                    </VCol>

                    <VCol
                        cols="12"
                        md="6"
                    >
                        <AppTextField
                        v-model="form.companyName"
                        label="Company Name"
                        placeholder="Enter Company Name"
                        :rules="[requiredValidator]"
                        :error-messages="errors.companyName"
                        />
                    </VCol>

                    <VCol
                        cols="12"
                        md="6"
                    >
                        <AppTextField
                        v-model="form.mobile"
                        type="number"
                        label="Phone No."
                        placeholder="+63 123 456 7890"
                        :rules="[requiredValidator, integerValidator]"
                        :error-messages="errors.mobile"
                        />
                    </VCol>

                    <VCol cols="12">
                        <AppTextField
                        v-model="form.address"
                        label="House Number & Street Name"
                        placeholder="1234 Main St, New York, NY 10001, USA"
                        :rules="[requiredValidator]"
                        :error-messages="errors.address"
                        />
                    </VCol>

                    <VCol cols="12">
                        <AppTextField
                        v-model="form.landmark"
                        label="Apartment, suite, unit, etc. (optional)"
                        placeholder="Near Central Park"
                        />
                    </VCol>

                    <VCol
                        cols="12"
                        md="6"
                    >
                        <AppTextField
                        v-model="form.city"
                        label="City"
                        placeholder="Enter City"
                        :rules="[requiredValidator]"
                        :error-messages="errors.city"
                        />
                    </VCol>

                    <VCol
                        cols="12"
                        md="6"
                    >
                        <AppSelect
                        v-model="form.state"
                        label="State"
                        :items="stateOptions"
                        :rules="[requiredValidator]"
                        :error-messages="errors.state"
                        />
                    </VCol>

                    <VCol
                        cols="12"
                        md="6"
                    >
                        <AppTextField
                        v-model="form.zipcode"
                        type="number"
                        label="Zipcode"
                        placeholder="1234"
                        :rules="[requiredValidator, lengthValidator(form.zipcode, 4), integerValidator]"
                        :error-messages="errors.zipcode"
                        />
                    </VCol>

                    <VCol
                        cols="12"
                    >
                        <VCheckbox
                        v-model="form.hasDifShippingAddress"
                        label="Ship to a different address?"
                        />
                    </VCol>

                    <template v-if="form.hasDifShippingAddress">
                        <VCol cols="12">
                        <AppTextField
                            v-model="shippingAddress.address"
                            label="House Number & Street Name"
                            placeholder="1234 Main St, New York, NY 10001, USA"
                        />
                        </VCol>

                        <VCol cols="12">
                        <AppTextField
                            v-model="shippingAddress.landmark"
                            label="Apartment, suite, unit, etc. (optional)"
                            placeholder="Near Central Park"
                        />
                        </VCol>

                        <VCol
                        cols="12"
                        md="6"
                        >
                        <AppTextField
                            v-model="shippingAddress.city"
                            label="City"
                            placeholder="New York"
                        />
                        </VCol>

                        <VCol
                        cols="12"
                        md="6"
                        >
                        <AppSelect
                            v-model="shippingAddress.state"
                            label="State"
                            placeholder="Select State"
                            :items="stateOptions"
                        />
                        </VCol>

                        <VCol
                          cols="12"
                          md="6"
                        >
                          <AppTextField
                            v-model="shippingAddress.zipcode"
                            type="number"
                            label="Zipcode"
                            placeholder="123456"
                          />
                        </VCol>
                    </template>
                </VRow>

                <VDivider class="my-10"/>

                <h4 class="text-h4">
                Dependent Information
                </h4>

                <VRow>
                  <VCol
                    cols="12"
                    class="mb-3"
                  >
                    <VRow v-for="(dependent, index) in dependents">
                      <VCol
                        cols="12"
                        class="mt-4s"
                      >
                        <VIcon icon="tabler-square-x text-danger" @click="deleteDependent(index)" style="float: right;"/>
                        <p class="mb-0">{{ `Dependent #${index+1}` }}</p> 
                      </VCol>
                      <VCol
                        cols="12"
                      >
                        <AppTextField
                          v-model="dependents[index].name"
                          label="Name"
                          placeholder="Enter Name"
                          :rules="[requiredValidator]"
                          :error-messages="errors.name"
                        />
                      </VCol>
                      <VCol
                        cols="12"
                        md="6"
                      >
                        <AppDateTimePicker
                          v-model="dependents[index].birth_date"
                          label="Birthday"
                          placeholder="Select date and time"
                          :config="{ enableTime: false, dateFormat: 'Y-m-d' }"
                          :rules="[requiredValidator]"
                          :error-messages="errors.birth_date"
                        />
                      </VCol>
                      <VCol
                        cols="12"
                        md="6"
                      >
                        <AppTextField
                          v-model="dependents[index].relationship"
                          label="Relationship"
                          :rules="[requiredValidator]"
                          :error-messages="errors.relationship"
                        />
                      </VCol>
                    </VRow>
                    <VRow class="mt-5">
                      <VCol>
                        <VBtn
                          @click="dependents.push(Object.assign({}, dependentFields))"
                        >
                          Add Dependent
                        </VBtn>
                      </VCol>
                    </VRow>
                  </VCol>
                </VRow>
              
            </VWindowItem>
            </VForm>
            <VForm
              ref="refForm3"  
              @submit.prevent="() => {}"
            >
              <VWindowItem>
                  <h4 class="text-h4">
                  Order Summary
                  </h4>

                  <h4 class="text-h4 mt-12 mb-3">
                  Product
                  </h4>

                  <VDivider />

                  <VCardText class="px-0">
                  <div class="text-high-emphasis">
                      <div class="d-flex justify-space-between mb-2">
                      <span style="font-size: 18px; font-weight: 500;">{{ `${selectedPlan.plan_name} Membership` }}</span>
                      <span class="text-medium-emphasis">X1</span>
                      </div>

                      <VRow class="align-center">
                      <VCol
                        md="6"
                        class="d-flex align-center"
                      > 
                        <span class="mr-2">for</span> 
                          <VSelect
                            v-model="selectedTerm"
                            :items="planOptions"
                            item-title="name"
                            return-object
                            placeholder="Select Term"
                          />
                      </VCol>
                      <VCol
                          md="6"
                          class="text-right"
                      >
                          <span class="text-medium-emphasis">{{ $currency.format(selectedTerm.price) }}</span>
                      </VCol>
                      </VRow>

                  </div>
                  </VCardText>

                  <!-- 👉 Price details -->
                  <VDivider />

                  <VCardText class="px-0">
                  <div class="text-high-emphasis">
                      <div class="d-flex justify-space-between mb-2">
                        <span>Sub Total</span>
                        <span class="text-medium-emphasis">{{ $currency.format(subTotal) }}</span>
                      </div>
                      <div v-if="dependents.length" class="d-flex justify-space-between mb-2">
                        <span>Dependents (X{{dependents.length}})</span>
                        <span class="text-medium-emphasis">{{ $currency.format(totalDependentCost) }}</span>
                      </div>
                      <div class="d-flex justify-space-between">
                        <span>Total</span>
                        <h3 class="h3 text-primary">{{ $currency.format(totalCost) }}</h3>
                      </div>

                  </div>
                  </VCardText>

                  <VDivider />

                  <h5 class="text-h5 mt-8">
                  Select Payment Method
                  </h5>

                  <VRadioGroup
                  class="mt-4"
                  v-model="form.paymentMethod"
                  :rules="[requiredValidator]"
                  :error-messages="errors.paymentMethod"
                  >
                  <VRadio
                      v-for="(option, index) in paymentMethodOptions"
                      :key="index"
                      :value="option.value"
                  >
                      <template #label>
                      <div class="d-flex align-center flex-row" >
                          <span>
                          {{option.name}}
                          </span>
                          <VAvatar
                          class="ml-2"
                          :rounded="0"
                          style="width: unset"
                          >
                          <img
                              :src="option.icon"
                              :alt="option.name"
                              width="auto"
                              height="17"
                          >
                          </VAvatar>
                      </div>
                      </template>
                  </VRadio>
                  </VRadioGroup>
                  
                  <p class="mt-14">By using this payment method, you agree that all submitted data for your order will be processed by payment processor.</p>
                  <VCheckbox
                  v-model="form.acceptTerms"
                  :rules="[requiredValidator]"
                  :error-messages="errors.acceptTerms"
                  >
                  <template #label>
                      <div>
                      I've read the KSF Membership
                      <span class="text-primary">
                          Terms and Conditions
                      </span>
                      </div>
                  </template>
                  </VCheckbox>
              </VWindowItem>
            </VForm>
        </VWindow>
        <div class="d-flex flex-wrap justify-space-between gap-x-4 mt-6">
            <VBtn
            color="secondary"
            :disabled="currentStep === 0"
            variant="tonal"
            @click="currentStep--"
            >
            <VIcon
                icon="tabler-arrow-left"
                start
                class="flip-in-rtl"
            />
            Previous
            </VBtn>

            <VBtn
            v-if="items.length - 1 === currentStep"
            color="primary"
            @click="onSubmit"
            >
            Subscribe
            </VBtn>

            <VBtn
            v-else
            @click="onNext"
            >
            Next

            <VIcon
                icon="tabler-arrow-right"
                end
                class="flip-in-rtl"
            />
            </VBtn>
        </div>
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

.app-stepper .v-slide-group__content .stepper-steps-invalid.stepper-steps-active .stepper-title,
.app-stepper .v-slide-group__content .stepper-steps-invalid.stepper-steps-active .stepper-subtitle {
    color: rgb(var(--v-global-theme-primary)) !important;
}
</style>
