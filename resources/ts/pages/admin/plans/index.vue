<script setup lang="ts">

import type { Data } from '@db/pages/datatable/types';
import { ref } from 'vue';
import { useToast } from "vue-toastification";
import { VForm } from 'vuetify/components/VForm';

import Vue3TagsInput from 'vue3-tags-input';

const refVForm = ref<VForm>()

definePage({
  meta: {
    action: 'manage',
    subject: 'admin',
  },
})

const toast = useToast()

const addDialog = ref(false)
const editDialog = ref(false)
const deleteDialog = ref(false)

const defaultItem = ref<Data>({
  id: 0,
  planName: '',
  categoryId: null,
  semiAnnualPrice: '',
  semiAnnualDependentPrice: '',
  annualPrice: '',
  annualDependentPrice: '',
  isRecommended: 0,
  inclusions: []
})

const editedItem = ref<Data>(defaultItem.value)
const editedIndex = ref(-1)
const planList = ref<Data[]>([])
const categoryList = ref<Data[]>([])

const errors = ref<Record<string, string | undefined>>({
  planName: undefined,
  categoryId: undefined,
  semiAnnualPrice: undefined,
  semiAnnualDependentPrice: undefined,
  annualPrice: undefined,
  annualDependentPrice: undefined,
  isRecommended: undefined,
  inclusions: undefined
})

// headers
const headers = [
  { title: 'PLAN', key: 'planName' },
  { title: 'CATEGORY', key: 'categoryName' },
  { title: 'SEMI ANNUAL PRICE', key: 'semiAnnualPrice' },
  { title: 'ANNUAL PRICE', key: 'annualPrice' },
  { title: 'IS RECOMMENDED?', key: 'isRecommended' },
  { title: 'CREATED AT', key: 'created_at' },
  { title: 'UPDATED AT', key: 'updated_at' },
  { title: 'ACTIONS', key: 'actions' },
]

// 👉 methods
const addItem = () => {
  editedIndex.value = -1
  addDialog.value = true
}

const editItem = (item: Data) => {
  editedIndex.value = planList.value.indexOf(item)
  editedItem.value = { ...item }
  editDialog.value = true
}

const deleteItem = (item: Data) => {
  editedIndex.value = planList.value.indexOf(item)
  editedItem.value = { ...item }
  deleteDialog.value = true
}

const close = () => {
  console.log(defaultItem.value)
  addDialog.value = false
  editDialog.value = false
  editedIndex.value = -1
  editedItem.value = { ...defaultItem.value }
}

const closeDelete = () => {
  deleteDialog.value = false
  editedIndex.value = -1
  editedItem.value = { ...defaultItem.value }
}

const save = () => {
  refVForm.value?.validate()
    .then(({ valid: isValid }) => {
      if (isValid) {
        const params = editedItem.value
        saveApi(params)
      }
    })
}

const saveApi = async (params: Data) => {
  try {
    const res = await $api('/v1/plans', {
      method: 'POST',
      body: params,
      onResponseError({ response }) {
        console.log(response)
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
        })
      },
    })

    const { message, newItem } = res

    toast.success(message, {
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

    const {
      id,
      plan_name,
      category,
      semi_annual_price,
      annual_price,
      is_recommended,
      created_at,
      updated_at,
      inclusions,
      semi_annual_dependent_price,
      annual_dependent_price,
    } = newItem

    let inclusionArray: [] = []
      
    inclusions.forEach( ({ name } : {name : string}) => {
      inclusionArray.push(name)
    })
    
    const newItemFormatted = {
      id,
      planName: plan_name,
      categoryId: category.id,
      categoryName: category.name,
      semiAnnualPrice: semi_annual_price,
      semiAnnualDependentPrice: semi_annual_dependent_price,
      annualPrice: annual_price,
      annualDependentPrice: annual_dependent_price,
      isRecommended: is_recommended,
      created_at: created_at ? $date.formatDate(created_at) : '-',
      updated_at: updated_at ? $date.formatDate(updated_at) : '-',
      inclusions: inclusionArray
    }

    if (editedIndex.value > -1) {
      Object.assign(planList.value[editedIndex.value], newItemFormatted)
    } else { 
      planList.value.unshift(newItemFormatted)
    }

    close()
  }
  catch (err) {
    console.error(err)
  }
}

const deleteItemConfirm = async (val: boolean) => {

  if (!val) {
    closeDelete()
    return false
  }

  try {
    const id = editedItem.value?.id || 0
    const res = await $api(`/v1/plans/${id}`, {
      method: 'DELETE',
      onResponseError({ response }) {
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
        })
      },
    })

    const { message } = res

    toast.success(message, {
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

    planList.value.splice(editedIndex.value, 1)
    closeDelete()
  }
  catch (err) {
    console.error(err)
  }

  
}

const getPlans = async () => {
  try {
    const res = await $api('/v1/plans', {
      method: 'GET',
      onResponseError({ response }) {
        console.log(response)
      },
    })

    planList.value = res.map((
      {
        id,
        plan_name,
        category,
        semi_annual_price,
        semi_annual_dependent_price,
        annual_price,
        annual_dependent_price,
        is_recommended,
        created_at,
        updated_at,
        inclusions
      } : 
      { 
        id: number,
        plan_name: string,
        category: object,
        semi_annual_price: string,
        semi_annual_dependent_price: string,
        annual_price: string,
        annual_dependent_price: string,
        is_recommended: number,
        created_at: string,
        updated_at: string,
        inclusions: []
      }
  ) => {

      let inclusionArray: [] = []
      
      inclusions.forEach( ({ name } : {name : string}) => {
        inclusionArray.push(name)
      })

      return {
        id,
        planName: plan_name,
        categoryId: category.id,
        categoryName: category.name,
        semiAnnualPrice: semi_annual_price,
        semiAnnualDependentPrice: semi_annual_dependent_price,
        annualPrice: annual_price,
        annualDependentPrice: annual_dependent_price,
        isRecommended: is_recommended,
        created_at: created_at ? $date.formatDate(created_at) : '-',
        updated_at: updated_at ? $date.formatDate(updated_at) : '-',
        inclusions: inclusionArray
      }
    })
  }
  catch (err) {
    console.error(err)
  }
}

const getCategories = async () => {
  try {
    const res = await $api('/v1/plans/category', {
      method: 'GET',
      onResponseError({ response }) {
        console.log(response)
      },
    })

    categoryList.value = res.map((
      {
        id,
        name,
      } : 
      { 
        name: string,
        id: number
      }
  ) => {

      /**
     * @param {string} name - The name of the pricing plan.
     * @param {Array} id - An id of category.
     */

      return {
        id,
        name,
      }
    })
  }
  catch (err) {
    console.error(err)
  }
}

const  handleChangeTag = (tags: any) => {
  editedItem.value.inclusions = tags;
}

onMounted(() => {
  getPlans()
  getCategories()
})
</script>

<template>
 <VRow>
    <VCol cols="12">
      <div class="d-flex justify-end">
        <VBtn
          color="primary"
          variant="elevated"
          @click="addItem()"
        >
          Add New Plan
        </VBtn>
      </div>
    </VCol>
    <VCol cols="12">
      <VCard
        title="Plans"
        no-padding
      >
        <!-- 👉 Datatable  -->
        <VDataTable
          :headers="headers"
          :items="planList"
          :items-per-page="5"
        >
          <!-- full name -->
          <template #item.name="{ item }">
              <span class="d-block font-weight-medium text-high-emphasis text-truncate">{{ item.name }}</span>
          </template>

          <template #item.semiAnnualPrice="{ item }">
            {{ $currency.format(item.semiAnnualPrice) }}
          </template>
          
          <template #item.annualPrice="{ item }">
            {{ $currency.format(item.annualPrice) }}
          </template>

          <template #item.isRecommended="{ item }">
            {{ item.isRecommended ? 'Yes' : 'No' }}
          </template>

          <!-- Actions -->
          <template #item.actions="{ item }">
            <div class="d-flex gap-1">
              <IconBtn @click="editItem(item)">
                <VIcon icon="tabler-edit" />
              </IconBtn>
              <IconBtn @click="deleteItem(item)">
                <VIcon icon="tabler-trash" />
              </IconBtn>
            </div>
          </template>
        </VDataTable>


        <!-- 👉 Add Dialog  -->
        <VDialog
          v-model="addDialog"
          max-width="600px"
        >
          <VForm
            ref="refVForm"
            @submit.prevent="save"
          >
            <VCard>
              <VCardTitle class="pa-6">
                <span class="headline">Add New Plan</span>
              </VCardTitle>

              <VCardText class="pa-6 py-0">
                <VRow>
                  <!-- plan name -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.planName"
                      label="Plan Name"
                      :rules="[requiredValidator]"
                      :error-messages="errors.name"
                    />
                  </VCol>
                  <!-- category -->
                  <VCol
                    md="6"
                  >
                      <VSelect
                        v-model="editedItem.categoryId"
                        :items="categoryList"
                        item-title="name"
                        item-value="id"
                        :rules="[requiredValidator]"
                        :error-messages="errors.name"
                        placeholder="Select Category"
                      />
                  </VCol>

                  <!-- semi annual price -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.semiAnnualPrice"
                      label="Semi-Annual Price"
                      :rules="[requiredValidator, integerValidator]"
                      :error-messages="errors.name"
                    />
                  </VCol>

                   <!-- semi annual dependent price -->
                   <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.semiAnnualDependentPrice"
                      label="Semi-Annual Dependent Price"
                      :rules="[requiredValidator]"
                      :error-messages="errors.semiAnnualDependentPrice"
                    />
                  </VCol>
                  <!-- semi annual dependent price -->


                  <!-- annual price -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.annualPrice"
                      label="Annual Price"
                      :rules="[requiredValidator, integerValidator]"
                      :error-messages="errors.name"
                    />
                  </VCol>
                  <!-- annual price -->

                  <!-- annual dependent price -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.annualDependentPrice"
                      label="Annual Dependent Price"
                      :rules="[requiredValidator, integerValidator]"
                      :error-messages="errors.annualDependentPrice"
                    />
                  </VCol>
                  <!-- annual dependent price -->

                  <VCol
                    cols="12"
                  >
                    <label class="d-block mb-2">Inclusions:</label>
                    <vue3-tags-input :tags="editedItem.inclusions"
                      placeholder="Please enter plan inclusions"
                      @on-tags-changed="handleChangeTag"/>
                  </VCol>

                  <VCol
                    cols="12"
                    class="py-0"
                  >
                    <VCheckbox
                      v-model="editedItem.isRecommended"
                      :error-messages="errors.isRecommended"
                    >
                      <template #label>
                        Is Recommended?
                      </template>
                    </VCheckbox>
                  </VCol>
                </VRow>
              </VCardText>

              <VCardActions  class="pa-6">
                <VSpacer />

                <VBtn
                  color="error"
                  variant="outlined"
                  @click="close"
                >
                  Cancel
                </VBtn>

                <VBtn
                  color="primary"
                  variant="elevated"
                  type="submit"
                >
                  Save
                </VBtn>
              </VCardActions>
            </VCard>
          </VForm>
        </VDialog>

        <!-- 👉 Edit Dialog  -->
        <VDialog
          v-model="editDialog"
          max-width="600px"
        >
          <VForm
            ref="refVForm"
            @submit.prevent="save"
          >
            <VCard>
              <VCardTitle class="pa-6">
                <span class="headline">Edit Plan</span>
              </VCardTitle>

              <VCardText class="pa-6 py-0">
                <VRow>
                  <!-- plan name -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.planName"
                      label="Plan Name"
                      :rules="[requiredValidator]"
                      :error-messages="errors.name"
                    />
                  </VCol>
                  <!-- category -->
                  <VCol
                    md="6"
                  >
                      <VSelect
                        v-model="editedItem.categoryId"
                        :items="categoryList"
                        item-title="name"
                        item-value="id"
                        :rules="[requiredValidator]"
                        :error-messages="errors.name"
                        placeholder="Select Category"
                      />
                  </VCol>
                  <!-- semi annual price -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.semiAnnualPrice"
                      label="Semi-Annual Price"
                      :rules="[requiredValidator, integerValidator]"
                      :error-messages="errors.semiAnnualPrice"
                    />
                  </VCol>
                  <!-- semi annual price -->

                  <!-- semi annual dependent price -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.semiAnnualDependentPrice"
                      label="Semi-Annual Dependent Price"
                      :rules="[requiredValidator]"
                      :error-messages="errors.semiAnnualDependentPrice"
                    />
                  </VCol>
                  <!-- semi annual dependent price -->

                  <!-- annual price -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.annualPrice"
                      label="Annual Price"
                      :rules="[requiredValidator, integerValidator]"
                      :error-messages="errors.annualPrice"
                    />
                  </VCol>
                  <!-- annual price -->

                  <!-- annual dependent price -->
                  <VCol
                    cols="6"
                  >
                    <VTextField
                      v-model="editedItem.annualDependentPrice"
                      label="Annual Dependent Price"
                      :rules="[requiredValidator, integerValidator]"
                      :error-messages="errors.annualDependentPrice"
                    />
                  </VCol>
                  <!-- annual dependent price -->


                  <VCol
                    cols="12"
                  >
                    <label class="d-block mb-2">Inclusions:</label>
                    <vue3-tags-input :tags="editedItem.inclusions"
                      placeholder="Please enter plan inclusions"
                      @on-tags-changed="handleChangeTag"/>
                  </VCol>

                  <VCol
                    cols="12"
                    class="py-0"
                  >
                    <VCheckbox
                      v-model="editedItem.isRecommended"
                      :error-messages="errors.isRecommended"
                      :value="1"
                    >
                      <template #label>
                        Is Recommended?
                      </template>
                    </VCheckbox>
                  </VCol>
                </VRow>
              </VCardText>

              <VCardActions  class="pa-6">
                <VSpacer />

                <VBtn
                  color="error"
                  variant="outlined"
                  @click="close"
                >
                  Cancel
                </VBtn>

                <VBtn
                  color="primary"
                  variant="elevated"
                  type="submit"
                >
                  Save
                </VBtn>
              </VCardActions>
            </VCard>
          </VForm>
        </VDialog>

        <!-- 👉 Delete Dialog  -->
        <ConfirmDialog
          v-model:isDialogVisible="deleteDialog"
          confirmation-question="Are you sure you want to delete this category?"
          confirm-title="Delete"
          cancel-title="Cancelled"
          @confirm="deleteItemConfirm($event)"
        />
        
      </VCard>
    </VCol>
  </VRow>
</template>
