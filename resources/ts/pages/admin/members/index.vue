<script setup lang="ts">

import type { Data } from '@db/pages/datatable/types'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar7 from '@images/avatars/avatar-7.png'
import avatar8 from '@images/avatars/avatar-8.png'
import { ref } from 'vue'

definePage({
  meta: {
    action: 'manage',
    subject: 'admin',
  },
})

const data: Data[] = [
  {
    responsiveId: '',
    id: 95,
    avatar: avatar2,
    fullName: 'Edwina Ebsworth',
    post: 'Human Resources Assistant',
    email: 'eebsworth2m@sbwire.com',
    city: 'Puzi',
    startDate: '09/27/2018',
    salary: 19586.23,
    age: '27',
    experience: '2 Years',
    status: 1,
  },
  {
    responsiveId: '',
    id: 1,
    avatar: avatar8,
    fullName: 'Korrie O\'Crevy',
    post: 'Nuclear Power Engineer',
    email: 'kocrevy0@thetimes.co.uk',
    city: 'Krasnosilka',
    startDate: '09/23/2016',
    salary: 23896.35,
    age: '61',
    experience: '1 Year',
    status: 2,
  },
  {
    responsiveId: '',
    id: 7,
    avatar: '',
    fullName: 'Eileen Diehn',
    post: 'Environmental Specialist',
    email: 'ediehn6@163.com',
    city: 'Lampuyang',
    startDate: '10/15/2017',
    salary: 18991.67,
    age: '59',
    experience: '9 Years',
    status: 3,
  },
  {
    responsiveId: '',
    id: 11,
    avatar: '',
    fullName: 'De Falloon',
    post: 'Sales Representative',
    email: 'dfalloona@ifeng.com',
    city: 'Colima',
    startDate: '06/12/2018',
    salary: 19252.12,
    age: '30',
    experience: '0 Year',
    status: 4,
  },
  {
    responsiveId: '',
    id: 3,
    avatar: avatar7,
    fullName: 'Stella Ganderton',
    post: 'Operator',
    email: 'sganderton2@tuttocitta.it',
    city: 'Golcowa',
    startDate: '03/24/2018',
    salary: 13076.28,
    age: '66',
    experience: '6 Years',
    status: 5,
  },
  {
    responsiveId: '',
    id: 5,
    avatar: '',
    fullName: 'Harmonia Nisius',
    post: 'Senior Cost Accountant',
    email: 'hnisius4@gnu.org',
    city: 'Lucan',
    startDate: '08/25/2017',
    salary: 10909.52,
    age: '33',
    experience: '3 Years',
    status: 2,
  },
  {
    responsiveId: '',
    id: 6,
    avatar: '',
    fullName: 'Genevra Honeywood',
    post: 'Geologist',
    email: 'ghoneywood5@narod.ru',
    city: 'Maofan',
    startDate: '06/01/2017',
    salary: 17803.8,
    age: '61',
    experience: '1 Year',
    status: 1,
  },
  {
    responsiveId: '',
    id: 4,
    avatar: avatar8,
    fullName: 'Dorolice Crossman',
    post: 'Cost Accountant',
    email: 'dcrossman3@google.co.jp',
    city: 'Paquera',
    startDate: '12/03/2017',
    salary: 12336.17,
    age: '22',
    experience: '2 Years',
    status: 2,
  },
  {
    responsiveId: '',
    id: 8,
    avatar: avatar7,
    fullName: 'Richardo Aldren',
    post: 'Senior Sales Associate',
    email: 'raldren7@mtv.com',
    city: 'Skoghall',
    startDate: '11/05/2016',
    salary: 19230.13,
    age: '55',
    experience: '5 Years',
    status: 3,
  },
  {
    responsiveId: '',
    id: 9,
    avatar: avatar2,
    fullName: 'Allyson Moakler',
    post: 'Safety Technician',
    email: 'amoakler8@shareasale.com',
    city: 'Mogilany',
    startDate: '12/29/2018',
    salary: 11677.32,
    age: '39',
    experience: '9 Years',
    status: 5,
  },
  {
    responsiveId: '',
    id: 10,
    avatar: avatar7,
    fullName: 'Merline Penhalewick',
    post: 'Junior Executive',
    email: 'mpenhalewick9@php.net',
    city: 'Kanuma',
    startDate: '04/19/2019',
    salary: 15939.52,
    age: '23',
    experience: '3 Years',
    status: 2,
  },

  {
    responsiveId: '',
    id: 12,
    avatar: '',
    fullName: 'Cyrus Gornal',
    post: 'Senior Sales Associate',
    email: 'cgornalb@fda.gov',
    city: 'Boro Utara',
    startDate: '12/09/2017',
    salary: 16745.47,
    age: '22',
    experience: '2 Years',
    status: 4,
  },
  {
    responsiveId: '',
    id: 13,
    avatar: '',
    fullName: 'Tallou Balf',
    post: 'Staff Accountant',
    email: 'tbalfc@sina.com.cn',
    city: 'Siliana',
    startDate: '01/21/2016',
    salary: 15488.53,
    age: '36',
    experience: '6 Years',
    status: 4,
  },
  {
    responsiveId: '',
    id: 14,
    avatar: '',
    fullName: 'Othilia Extill',
    post: 'Associate Professor',
    email: 'oextilld@theatlantic.com',
    city: 'Brzyska',
    startDate: '02/01/2016',
    salary: 18442.34,
    age: '43',
    experience: '3 Years',
    status: 2,
  },
  {
    responsiveId: '',
    id: 15,
    avatar: '',
    fullName: 'Wilmar Bourton',
    post: 'Administrative Assistant',
    email: 'wbourtone@sakura.ne.jp',
    city: 'Bích Động',
    startDate: '04/25/2018',
    salary: 13304.45,
    age: '19',
    experience: '9 Years',
    status: 5,
  },
  {
    responsiveId: '',
    id: 16,
    avatar: avatar4,
    fullName: 'Robinson Brazenor',
    post: 'General Manager',
    email: 'rbrazenorf@symantec.com',
    city: 'Gendiwu',
    startDate: '12/23/2017',
    salary: 11953.08,
    age: '66',
    experience: '6 Years',
    status: 5,
  },
  {
    responsiveId: '',
    id: 17,
    avatar: '',
    fullName: 'Nadia Bettenson',
    post: 'Environmental Tech',
    email: 'nbettensong@joomla.org',
    city: 'Chabařovice',
    startDate: '07/11/2018',
    salary: 20484.44,
    age: '64',
    experience: '4 Years',
    status: 1,
  },
  {
    responsiveId: '',
    id: 18,
    avatar: '',
    fullName: 'Titus Hayne',
    post: 'Web Designer',
    email: 'thayneh@kickstarter.com',
    city: 'Yangon',
    startDate: '05/25/2019',
    salary: 16871.48,
    age: '59',
    experience: '9 Years',
    status: 1,
  },
  {
    responsiveId: '',
    id: 19,
    avatar: avatar4,
    fullName: 'Roxie Huck',
    post: 'Administrative Assistant',
    email: 'rhucki@ed.gov',
    city: 'Polýkastro',
    startDate: '04/04/2019',
    salary: 19653.56,
    age: '41',
    experience: '1 Year',
    status: 4,
  },
  {
    responsiveId: '',
    id: 20,
    avatar: avatar7,
    fullName: 'Latashia Lewtey',
    post: 'Actuary',
    email: 'llewteyj@sun.com',
    city: 'Hougong',
    startDate: '08/03/2017',
    salary: 18303.87,
    age: '35',
    experience: '5 Years',
    status: 1,
  }
]

const editDialog = ref(false)
const deleteDialog = ref(false)

const defaultItem = ref<Data>({
  responsiveId: '',
  id: -1,
  avatar: '',
  fullName: '',
  startDate: '',
  isAutoRenewal: 0,
  status: -1,
})

const editedItem = ref<Data>(defaultItem.value)
const editedIndex = ref(-1)
const userList = ref<Data[]>([])

// status options
const statusOptions = [
  { text: 'ACTIVE', value: 1 },
  { text: 'INACTIVE', value: 2 },
  { text: 'SUSPENDED', value: 3 },
  { text: 'CANCELLED', value: 4 }
]

// headers
const headers = [
  { title: 'NAME', key: 'fullName' },
  { title: 'MEMBERSHIP DATE', key: 'startDate' },
  { title: 'EXPIRATION DATE', key: 'endDate' },
  { title: 'STATUS', key: 'status' },
  { title: 'MEMBERSHIP PACKAGE', key: 'package' },
  { title: 'ACTIONS', key: 'actions' },
]

const resolveStatusVariant = (status: number) => {
  if (status == 1)
    return { color: 'primary', text: 'ACTIVE' }
  else if (status == 2)
    return { color: 'success', text: 'INACTIVE' }
  else if (status == 3)
    return { color: 'error', text: 'SUSPENDED' }
  else if (status == 4)
    return { color: 'warning', text: 'CANCELLED' }
}

// 👉 methods
const editItem = (item: Data) => {
  editedIndex.value = userList.value.indexOf(item)
  editedItem.value = { ...item }
  editDialog.value = true
}

const deleteItem = (item: Data) => {
  editedIndex.value = userList.value.indexOf(item)
  editedItem.value = { ...item }
  deleteDialog.value = true
}

const close = () => {
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
  if (editedIndex.value > -1)
    Object.assign(userList.value[editedIndex.value], editedItem.value)

  else
    userList.value.push(editedItem.value)

  close()
}

const deleteItemConfirm = () => {
  userList.value.splice(editedIndex.value, 1)
  closeDelete()
}


const getMembers = async () => {
  try {
    const res = await $api('/v1/members', {
      method: 'GET',
      onResponseError({ response }) {
        console.log(response)
      },
    })

    userList.value = res.map((
      {
        id,
        first_name,
        last_name,
        subscription,
        created_at,
        updated_at
      } : 
      { 
        id: number,
        first_name: string,
        last_name: string,
        subscription: Object,
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
        fullName: `${first_name} ${last_name}`,
        startDate: subscription.start_date,
        endDate: subscription.end_date,
        package: subscription.plan_details.plan_name,
        status: subscription.status,
        isAutoRenewal: subscription.auto_renewal,
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
  getMembers()
})
</script>

<template>
 <VRow>
    <VCol cols="12">
      <VCard
        title="Members"
        no-padding
      >
        <!-- 👉 Datatable  -->
        <VDataTable
          :headers="headers"
          :items="userList"
          :items-per-page="5"
        >
          <!-- full name -->
          <template #item.fullName="{ item }">
            <div class="d-flex align-center">
              <!-- avatar -->
              <VAvatar
                size="32"
                :color="item.avatar ? '' : 'primary'"
                :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
                :variant="!item.avatar ? 'tonal' : undefined"
              >
                <VImg
                  v-if="item.avatar"
                  :src="item.avatar"
                />
                <span v-else>{{ avatarText(item.fullName) }}</span>
              </VAvatar>

              <div class="d-flex flex-column ms-3">
                <span class="d-block font-weight-medium text-high-emphasis text-truncate">{{ item.fullName }}</span>
                <small>{{ item.post }}</small>
              </div>
            </div>
          </template>

          <template #item.endDate="{ item }">
            {{ item.isAutoRenewal ? 'AUTO RENEWAL' : item.endDate }}
          </template>

          <!-- status -->
          <template #item.status="{ item }">
            <VChip
              :color="resolveStatusVariant(item.status).color"
              size="small"
            >
              {{ resolveStatusVariant(item.status).text }}
            </VChip>
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

        <!-- 👉 Edit Dialog  -->
        <VDialog
          v-model="editDialog"
          max-width="600px"
        >
          <VCard>
            <VCardTitle>
              <span class="headline">Edit Item</span>
            </VCardTitle>

            <VCardText>
              {{ editedItem?.fullName }}
              <VContainer>
                <VRow>
                  <!-- fullName -->
                  <VCol
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <VTextField
                      v-model="editedItem.fullName"
                      label="User name"
                    />
                  </VCol>

                  <!-- email -->
                  <VCol
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <VTextField
                      v-model="editedItem.email"
                      label="Email"
                    />
                  </VCol>

                  <!-- salary -->
                  <VCol
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <VTextField
                      v-model="editedItem.salary"
                      label="Salary"
                      prefix="$"
                      type="number"
                    />
                  </VCol>

                  <!-- age -->
                  <VCol
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <VTextField
                      v-model="editedItem.age"
                      label="Age"
                      type="number"
                    />
                  </VCol>

                  <!-- start date -->
                  <VCol
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <VTextField
                      v-model="editedItem.startDate"
                      label="Date"
                    />
                  </VCol>

                  <!-- status -->
                  <VCol
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <AppSelect
                      v-model="editedItem.status"
                      :items="statusOptions"
                      item-title="text"
                      item-value="value"
                      label="Standard"
                      variant="underlined"
                      readonly
                    />
                  </VCol>
                </VRow>
              </VContainer>
            </VCardText>

            <VCardActions>
              <VSpacer />

              <VBtn
                color="error"
                variant="outlined"
                @click="close"
              >
                Cancel
              </VBtn>

              <VBtn
                color="success"
                variant="elevated"
                @click="save"
              >
                Save
              </VBtn>
            </VCardActions>
          </VCard>
        </VDialog>

        <!-- 👉 Delete Dialog  -->
        <VDialog
          v-model="deleteDialog"
          max-width="500px"
        >
          <VCard>
            <VCardTitle>
              Are you sure you want to delete this item?
            </VCardTitle>

            <VCardActions>
              <VSpacer />

              <VBtn
                color="error"
                variant="outlined"
                @click="closeDelete"
              >
                Cancel
              </VBtn>

              <VBtn
                color="success"
                variant="elevated"
                @click="deleteItemConfirm"
              >
                OK
              </VBtn>

              <VSpacer />
            </VCardActions>
          </VCard>
        </VDialog>
      </VCard>
    </VCol>
  </VRow>
</template>
