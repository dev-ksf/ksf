<template>
  <div 
    id="why-ksf?"
  >
    <VContainer id="ksf-membership-demo">
      <div class="feature-cards-2">
        <div class="video-card my-16">
          <video
            src="@images/cards-png/ksf-video-demo.mp4"
            alt="video-cards"
            height="286px"
            controls
            style=" display: block;
            border: 2px solid whitesmoke;
            border-radius: 10px;
            margin: auto;
            block-size: auto;
            width: 100%;"
          />
        </div>
      </div>
    </VContainer>

    <div class="feature-cards-3">
      <div class="position-relative ">
        <div class="what-more-title">
          What's more?
        </div>
      </div>
      <VContainer>
        <VRow class="cards-containers d-flex justify-space-between">
          <VCol cols="12" md="3">
            <div class="image-cards">
              <img
                src="@images/cards-png/img-1.png"
                alt="image-cards"
                height="auto"
                width="100%"
              >
              <div class="image-caption pb-5">
                Your claims will be assisted
              </div>
            </div>
          </VCol>
          <VCol cols="12" md="3">
            <div class="image-cards">
              <img
                src="@images/cards-png/img-2.png"
                alt="image-cards"
                height="auto"
                width="100%"
              >
              <div class="image-caption pb-5">
                You'll have a support community
                for networking
              </div>
            </div>
          </VCol>
          <VCol cols="12" md="3">
            <div class="image-cards">
              <img
                src="@images/cards-png/img-3.png"
                alt="image-cards"
                height="auto"
                width="100%"
              >
              <div class="image-caption pb-5">
                You already have an invitation to our Yearly Anniversary Celebration
              </div>
            </div>
          </VCol>
          <VCol cols="12" md="3">
            <div class="image-cards">
              <img
                src="@images/cards-png/img-4.png"
                alt="image-cards"
                height="auto"
                width="100%"
              >
              <div class="image-caption pb-5">
                <a href="https://project100campaign.com/homepage">You'll be part of our biggest Why- <br><strong>Project 100 Campaign</strong></a>
              </div>
            </div>
          </VCol>
        </VRow>
      </VContainer>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.feature-cards-3 {
  background-image: linear-gradient(to right, #fff, #9cccff, #fffbe7);
  background-position: relative;
  background-repeat: no-repeat;
  background-size: cover;
  block-size: auto;
  inline-size: 100%;
  padding-block-end: 100px;
}

@media (max-width: 600px) {
  .feature-card-3 {
    padding-block-end: 10px;
  }
}

.what-more-title {
  color: white;
  font-family: Ubuntu, sans-serif;
  font-size: 4vw;
  font-weight: 700;
  line-height: 4.5963rem;
  padding-block: 120px 40px;
  text-align: center;
  text-shadow: 0 4px 4px rgba(0, 0, 0, 20%);
}

@media (max-width: 50rem) {
  .what-more-title {
    font-size: 8vw;
    padding-block: 20px 10px;
  }
}

.image-caption {
  padding: 0.3em;
  margin: 0.3em;
  color: black;
  font-size: 16px;
  font-weight: 600;
  margin-block: 5px 15px;
  text-align: center;
  line-height: 20px;
}

image-caption strong {
  font-weight: 1000;
}

.image-caption a {
  color: inherit;
  text-decoration: none;
}

.image-caption a:hover {
  color: rgb(214, 214, 101);
}

.cards-containers {
  display: flex;
  overflow: hidden;
  flex-wrap: space-between;
  justify-content: center;
  max-inline-size: 100%;
}

@media (max-width: 700px) {
  .cards-containers {
    margin-inline-end: 0.1875rem;
  }

  .feature-cards-3 {
    padding-block-end: 50px;
  }
}

.image-cards {
  border-radius: 5px;
  background-color: white;
  min-height: 300px;
  // margin-inline-end: 30px;
}

.image-cards:last-child {
  margin-inline-end: 0;
}
</style>
