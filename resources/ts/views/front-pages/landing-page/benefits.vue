<template>
  <VContainer id="company-benefits">
    <div class="feature-cards d-flex justify-center align-left">
      <div class="headers d-flex justify-left flex-column mb-12">
        <div class="d-flex text-h4 mb-1 flex-wrap justify-left">
          <div class="position-relative me-2">
            <div class="section-title">
              <br>
              <br>
              <h3>For Companies/ Businesses</h3>
              <h3>with Group Application</h3> <br>
              <p class="text-body-1 mb-2">
                We will add the following benefits in the same<br>
                membership package for your people; no additional<br>
                cost needed.
              </p>
              <br>
              <div>
                <VBtn
                  class="btn"
                  size="large"
                  style="font-size: 14px; font-weight: 400;"
                >
                  Schedule a discovery call
                </VBtn>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="image-card mb-12">
        <img
          src="@images/cards-png/cards-benefits.png"
          alt="image-cards"
          height="auto"
          width="100%"
        >
      </div>
    </div>
  </VContainer>
</template>

<style lang="scss" scoped>
.feature-cards {
  display: flex;
  justify-content: space-between;
  block-size: auto;
  inline-size: 100%;
  margin-block: 7rem;
}

.section-title {
  font-size: 1.875rem;
  font-weight: 800;
  margin-inline-end: 1.375rem;
}

@media screen and (max-width: 768px) {
  .feature-cards {
    flex-direction: column;
    align-items: center;
    margin-block: 0;

    .section-title {
      font-size: 28px;
    }
  }
}
</style>
