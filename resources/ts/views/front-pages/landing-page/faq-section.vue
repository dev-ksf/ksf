<script setup lang="ts">
import { ref } from 'vue';

const faqData = ref([])

const name = ref('');
const email = ref('');
const message = ref('');

const submitForm = () => {
  // Add form submission logic here
}

const getFaqs = async () => {
  try {
    const res = await $api('/v1/faqs', {
      method: 'GET',
      onResponseError({ response }) {
        console.log(response)
      },
    })

    faqData.value = res.map((
      {
        question,
        answer,
      } : 
      { 
        question: string,
        answer: string,
      }
  ) => {

      return {
        question,
        answer,
        expanded: false
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
  <div id="faq">
    <VContainer>
      <!-- 👉 Header -->
      <div class="faq-section">
        <div class="headers d-flex justify-center flex-column align-center">
          <h4 class="d-flex align-center text-h4 mb-1 flex-wrap justify-center">
            <h1 class="alter" style="color: #3E7DC0;  font-size: 54px;  font-family: 'Ubuntu', sans-serif;">Questions?</h1>
            <div class="position-relative ms-2">
              <div class="section-title">Look here.</div>
            </div>
          </h4>
          <p style = "font-family: 'League Spartan', 'sans-serif'; font-size: 24px; margin-top: 15px;">
               Here are some common questions about KS Financials.
            </p>
        </div>
        <div class="text-xs-left">
          <VRow>
            <VCol cols="12" md="7">
            <VExpansionPanels class="pt-16" style="max-width: 667px;">
              <VExpansionPanel v-for="(faq, index) in faqData" :key="index" v-model="faq.expanded">
              <VExpansionPanelTitle style="background-color: #FAFCFF; display: flex; align-items: center; height: 59px; font-size: 16px;  font-family:  'League Spartan', sans-serif;"  @click="faq.expanded = !faq.expanded">
                <span style="color: black;">{{ faq.question }}</span>
          
                <img
                  v-if ="faq.expanded" 
                  src="@images/content/minusSign.png" alt="Minus Sign" 
                  style="height: 
                  24px; width: 24px; 
                  position: absolute; top: 50%; 
                  right: 0; transform: 
                  translateY(-50%); 
                  margin-right: 15px;"
                >
                
                <img 
                  v-else
                  src="@images/content/plusSign.png" 
                  alt="Plus Sign" 
                  style="height: 
                  24px; width: 24px; 
                  position: absolute; top: 50%; 
                  right: 0; transform: 
                  translateY(-50%); 
                  margin-right: 15px;"
                >

              </VExpansionPanelTitle>
              <VExpansionPanelText style="background-color: white; font-size: 13px;">
                <span style="color: black;">{{ faq.answer }}</span>
              </VExpansionPanelText>
            </VExpansionPanel>
            </VExpansionPanels>
          </VCol>

          <VCol cols="12" md="5">
            <VCard style="max-width: 700px; background-color: transparent; margin-top: 100px; box-shadow: none;">
              <VCardItem class="pb-0">
                <p class="text-h4 mb-1 text-center" style="color: #2D2D2D; text-align:center;  font-family:  'League Spartan', 'sans-serif'; font-size: 36px !important;">Still have questions?</p>
                <p class="mb-6 mx-auto text-center" style="width: 299px;">Ask us anything and we’ll get back to you as soon as we can!</p>
              </VCardItem>
              <VCardText style="color: #2D2D2D;">
                <VForm @submit.prevent="submitForm">
                  <VRow>
                    <VCol cols="12">
                      <label>
                        <p class="mb-2 mt-4" style="font-size: 20px;">Let us know.</p>
                        <AppTextField
                          v-model="email"
                          placeholder="Email Address"
                        />
                      </label>
                    </VCol>
                    <VCol cols="12">
                      <div class = "field">
                        <AppTextarea
                          v-model="message"
                          placeholder="Write a message"
                          rows="3"
                        />
                      </div>
                    </VCol>
                    <VCol>
                      <div class="btn_Submit text-center" >
                        <VBtn 
                          class="mt-8s"
                          color="black" 
                          dark 
                          style="  height: 46px; width: 196px; background-color: #FAFCFF; color: #000000; stroke: #000000;  font-size: 20px;">
                          Submit
                        </VBtn>
                      </div>
                    </VCol>
                  </VRow>
                  </VForm>
            </VCardText>
          </VCard>
          </VCol>
        </VRow>
      </div>
      </div>
    </VContainer>
  </div>
</template>



<style lang="scss">

#faq {
  background-color: #e9f4ff;
  color: black;

  .v-expansion-panel-title__icon .tabler-chevron-right {
    display: none !important;
  }

  .v-expansion-panel-text__wrapper {
    padding: 0 50px 20px 24px !important;
  }

  .v-expansion-panel-title {
    padding: 12px 50px 12px 24px !important;
  }

  .faq-section {
    margin-block: 5.25rem;
  }

  .gana{
    color: black;
  }

  .text-field-color::placeholder {
    color: black; /* Change this to the desired color */
  }


  @media (max-width: 600px) {
    .faq-section {
      margin-block: 4rem;
    }
  }

  .alter {
    color: #3E7DC0;
    font-size: 54px;
    font-family: 'Ubuntu', sans-serif;
  }


  .alter{

    font-family: 'Ubuntu','sans-serif';

  }

  .btn_Submit {
    float: center;
    color: black;
    font-family: 'League Spartan', 'sans-serif';
   
  }

  .alter,
  .section-title {
    font-family: 'Ubuntu', sans-serif;
    font-size: 44px;
    font-weight: 800;
    line-height: 36px;
    color: black;
  }

  .section-title::after {
    position: absolute;
    background: url("../../../assets/images/front-pages/icons/section-title-icon.png") no-repeat left bottom;
    background-size: contain;
    block-size: 100%;
    content: "";
    font-weight: 800;
    inline-size: 130%;
    inset-block-end: 12%;
    inset-inline-start: -12%;
  }

  .text-body-1 {
    font-size: 24px;
    color: black;
    font-family: 'League Spartan', sans-serif;
    margin-top: 15px;
  }


  .text-h4 {
    font-size: 36px !important;
    font-family: 'Leauge Spartan', sans-serif;
    font-weight: bold;
  }

  @media (max-width: 700px) {
    h1.alter {
      font-size: 42px !important;
    }
    .section-title {
      font-size: 34px;
      line-height: 56px;
    }

    .faq-section {
      margin-block: 3.25rem;
    }
  }
}
</style>
