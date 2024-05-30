<script setup lang="ts">

import type { Data } from '@db/pages/datatable/types';
import { ref } from 'vue';
import { useToast } from "vue-toastification";
import { VForm } from 'vuetify/components/VForm';


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
  question: '',
  answer: ''
})

const editedItem = ref<Data>(defaultItem.value)
const editedIndex = ref(-1)
const faqList = ref<Data[]>([])
const categoryList = ref<Data[]>([])

const errors = ref<Record<string, string | undefined>>({
  qusetion: undefined,
  answer: undefined,
})

// headers
const headers = [
  { title: 'QUESTION', key: 'question' },
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
  editedIndex.value = faqList.value.indexOf(item)
  editedItem.value = { ...item }
  editDialog.value = true
}

const deleteItem = (item: Data) => {
  editedIndex.value = faqList.value.indexOf(item)
  editedItem.value = { ...item }
  deleteDialog.value = true
}

const close = () => {
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
    const res = await $api('/v1/faqs', {
      method: 'POST',
      body: params,
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
      question,
      answer,
      created_at,
      updated_at
    } = newItem

    let inclusionArray: [] = []
      
    
    const newItemFormatted = {
      id,
      question,
      answer,
      created_at: created_at ? $date.formatDate(created_at) : '-',
      updated_at: updated_at ? $date.formatDate(updated_at) : '-',
    }

    if (editedIndex.value > -1) {
      Object.assign(faqList.value[editedIndex.value], newItemFormatted)
    } else { 
      faqList.value.unshift(newItemFormatted)
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
    const res = await $api(`/v1/faqs/${id}`, {
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

    faqList.value.splice(editedIndex.value, 1)
    closeDelete()
  }
  catch (err) {
    console.error(err)
  }

  
}

const getFaqs = async () => {
  try {
    const res = await $api('/v1/faqs', {
      method: 'GET',
      onResponseError({ response }) {
        console.log(response)
      },
    })

    faqList.value = res.map((
      {
        id,
        question,
        answer,
        created_at,
        updated_at,
      } : 
      { 
        id: number,
        question: string,
        answer: string,
        created_at: string,
        updated_at: string,
      }
  ) => {

      return {
        id,
        question,
        answer,
        created_at: created_at ? $date.formatDate(created_at) : '-',
        updated_at: updated_at ? $date.formatDate(updated_at) : '-',
      }
    })
  }
  catch (err) {
    console.error(err)
  }
}

onMounted(() => {
  getFaqs()
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
          Add New FAQ
        </VBtn>
      </div>
    </VCol>
    <VCol cols="12">
      <VCard
        title="FAQ List"
        no-padding
      >
        <!-- 👉 Datatable  -->
        <VDataTable
          :headers="headers"
          :items="faqList"
          :items-per-page="5"
        >

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
                <span class="headline">Add New FAQ</span>
              </VCardTitle>

              <VCardText class="pa-6 py-0">
                <VRow>
                  <!-- plan name -->
                  <VCol
                    cols="12"
                  >
                    <VTextField
                      v-model="editedItem.question"
                      label="Question"
                      :rules="[requiredValidator]"
                      :error-messages="errors.question"
                    />
                  </VCol>
                  <VCol
                    cols="12"
                  >
                    <VTextarea
                      v-model="editedItem.answer"
                      label="Answer"
                      rows="2"
                      placeholder="Enter the answer"
                      :rules="[requiredValidator]"
                      :error-messages="errors.answer"
                    />
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
                <span class="headline">Edit FAQ</span>
              </VCardTitle>

              <VCardText class="pa-6 py-0">
                <VRow>
                  <!-- plan name -->
                  <VCol
                    cols="12"
                  >
                    <VTextField
                      v-model="editedItem.question"
                      label="Question"
                      :rules="[requiredValidator]"
                      :error-messages="errors.question"
                    />
                  </VCol>
                  <VCol
                    cols="12"
                  >
                    <VTextarea
                      v-model="editedItem.answer"
                      label="Answer"
                      rows="2"
                      placeholder="Enter the answer"
                      :rules="[requiredValidator]"
                      :error-messages="errors.answer"
                    />
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
          confirmation-question="Are you sure you want to delete this item?"
          confirm-title="Delete"
          cancel-title="Cancelled"
          @confirm="deleteItemConfirm($event)"
        />
        
      </VCard>
    </VCol>
  </VRow>
</template>
