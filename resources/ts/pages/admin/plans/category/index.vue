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
const isSaving = ref(false)

const defaultItem = ref<Data>({
  id: 0,
  name: ''
})

const editedItem = ref<Data>(defaultItem.value)
const editedIndex = ref(-1)
const categoryList = ref<Data[]>([])

const errors = ref<Record<string, string | undefined>>({
  name: undefined
})

// headers
const headers = [
  { title: 'NAME', key: 'name' },
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
  editedIndex.value = categoryList.value.indexOf(item)
  editedItem.value = { ...item }
  editDialog.value = true
}

const deleteItem = (item: Data) => {
  editedIndex.value = categoryList.value.indexOf(item)
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
    isSaving.value = true
    const res = await $api('/v1/plans/category', {
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

    const { id, name, created_at, updated_at } = newItem
    const newItemFormatted = {
      id,
      name,
      created_at: created_at ? $date.formatDate(created_at) : '-',
      updated_at: updated_at ? $date.formatDate(updated_at) : '-'
    }

    if (editedIndex.value > -1) {
      Object.assign(categoryList.value[editedIndex.value], newItemFormatted)
    } else { 
      categoryList.value.unshift(newItemFormatted)
    }

    isSaving.value = false
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
    const res = await $api(`/v1/plans/category/${id}`, {
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

    categoryList.value.splice(editedIndex.value, 1)
    closeDelete()
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
        created_at,
        updated_at
      } : 
      { 
        name: string,
        id: number,
        created_at: string,
        updated_at: string
      }
  ) => {

      /**
     * @param {string} name - The name of the pricing plan.
     * @param {Array} id - An id of category.
     */

      return {
        id,
        name,
        created_at: created_at ? $date.formatDate(created_at) : '-',
        updated_at: updated_at ? $date.formatDate(updated_at) : '-'
      }
    })
  }
  catch (err) {
    console.error(err)
  }
}

onMounted(() => {
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
          Add category
        </VBtn>
      </div>
    </VCol>
    <VCol cols="12">
      <VCard
        title="Plan Categories"
        no-padding
      >
        <!-- 👉 Datatable  -->
        <VDataTable
          :headers="headers"
          :items="categoryList"
          :items-per-page="5"
        >
          <!-- full name -->
          <template #item.name="{ item }">
              <span class="d-block font-weight-medium text-high-emphasis text-truncate">{{ item.name }}</span>
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
                <span class="headline">Add Category</span>
              </VCardTitle>

              <VCardText class="pa-6 py-0">
                <VRow>
                  <!-- fullName -->
                  <VCol
                    cols="12"
                  >
                    <VTextField
                      v-model="editedItem.name"
                      label="Name"
                      :rules="[requiredValidator]"
                      :error-messages="errors.name"
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
                  :disabled="isSaving"
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
                <span class="headline">Edit Category</span>
              </VCardTitle>

              <VCardText class="pa-6 py-0">
                <VRow>
                  <!-- fullName -->
                  <VCol
                    cols="12"
                  >
                    <VTextField
                      v-model="editedItem.name"
                      label="Name"
                      :rules="[requiredValidator]"
                      :error-messages="errors.name"
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
                  :disabled="isSaving"
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
