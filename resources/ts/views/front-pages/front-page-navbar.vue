<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router/auto'
import { useDisplay } from 'vuetify'

import { useWindowScroll } from '@vueuse/core'

import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import { themeConfig } from '@themeConfig'

const props = defineProps({
  activeId: String,
})

const display = useDisplay()

interface navItem {
  name: string
  to: RouteLocationRaw
}

interface MenuItem {
  listTitle: string
  listIcon: string
  navItems: navItem[]
}
const { y } = useWindowScroll()

const route = useRoute()
const router = useRouter()

const sidebar = ref(false)

watch(() => display, () => {
  return display.mdAndUp ? sidebar.value = false : sidebar.value
}, { deep: true })

const isMenuOpen = ref(false)
const isMegaMenuOpen = ref(false)

const isCurrentRoute = (to: RouteLocationRaw) => {
  return route.matched.some(_route => _route.path.startsWith(router.resolve(to).path))

  // ℹ️ Below is much accurate approach if you don't have any nested routes
  // return route.matched.some(_route => _route.path === router.resolve(to).path)
}

</script>

<template>
  <!-- 👉 Navigation drawer for mobile devices  -->
  <VNavigationDrawer
    v-model="sidebar"
    width="275"
    disable-resize-watcher
  >
    <!-- Nav items -->
    <div>
      <div class="d-flex flex-column gap-y-4 pa-4">
        <RouterLink
        v-for="(item, index) in ['Why KSF?', 'Company Benefits', 'Testimonials', 'Membership & Pricing']"
          :key="index"
          :to="{ name: 'root', hash: `#${item.toLowerCase().replaceAll(' ', '-')}` }"
          class="nav-link font-weight-medium"
          :class="[props.activeId?.toLocaleLowerCase().replaceAll('-', ' ') === item.toLocaleLowerCase() ? 'active-link' : '']"
        >
          {{ item }}
        </RouterLink>

        <RouterLink
          to="/"
          target="_blank"
          class="font-weight-medium nav-link"
        >
          Admin
        </RouterLink>
      </div>
    </div>

    <!-- Navigation drawer close icon -->
    <VIcon
      id="navigation-drawer-close-btn"
      icon="tabler-x"
      size="20"
      @click="sidebar = !sidebar"
    />
  </VNavigationDrawer>

  <!-- 👉 Navbar for desktop devices  -->
    <div class="front-page-navbar">
      <div class="front-page-navbar">
        
        <VAppBar
          :color="$vuetify.theme.current.dark ? 'rgba(var(--v-theme-surface),0.38)' : 'rgba(var(--v-theme-surface), 0.38)'"
          :class="y > 10 ? 'app-bar-scrolled' : [$vuetify.theme.current.dark ? 'app-bar-dark' : 'app-bar-light', 'elevation-0']"
          class="navbar-blur"
        >
          <VContainer class="py-0 px-0">
            <!-- toggle icon for mobile device -->
            <IconBtn
              id="vertical-nav-toggle-btn"
              class="ms-n3 me-2 d-inline-block d-md-none"
              @click="sidebar = !sidebar"
            >
              <VIcon
                size="26"
                icon="tabler-menu-2"
                color="rgba(var(--v-theme-on-surface))"
              />
            </IconBtn>
            <!-- Title and Landing page sections -->
            <div class="d-flex align-center">
              <VAppBarTitle class="me-6">
                <RouterLink
                  to="/"
                  class="d-flex gap-x-4"
                  :class="$vuetify.display.mdAndUp ? 'd-none' : 'd-block'"
                >
                  <div class="app-logo">
                    <VNodeRenderer :nodes="themeConfig.app.logo" />
                  </div>
                </RouterLink>
              </VAppBarTitle>
            </div>

            <VSpacer />

            <div class="d-flex align-center gap-x-4">
              <!-- landing page sections -->
              <div class="text-base align-center d-none d-md-flex">
                <RouterLink
                  v-for="(item, index) in ['Why KSF?', 'Company Benefits', 'Testimonials', 'Membership & Pricing']"
                  :key="index"
                  :to="{ name: 'root', hash: `#${item.toLowerCase().replaceAll(' ', '-')}` }"
                  class="nav-link font-weight-medium py-2 px-2 px-lg-4"
                  :class="[props.activeId?.toLocaleLowerCase().replaceAll('-', ' ') === item.toLocaleLowerCase() ? 'active-link' : '']"
                >
                  {{ item }}
                </RouterLink>

              </div>
              <RouterLink
                v-if="$vuetify.display.lgAndUp"
                :to="{ name: 'login' }"
              >
                <VBtn color="primary">
                  Sign in
                </VBtn>
                
              </RouterLink>

              <RouterLink
                v-else
                rounded
                icon
                variant="elevated"
                color="primary"
                :to="{ name: 'login' }"
                rel="noopener noreferrer"
              >
                <VIcon icon="tabler-login-2" />
              </RouterLink>
            </div>
          </VContainer>
        </VAppBar>
      
      </div>
    </div>
</template>

<style lang="scss" scoped>
.front-page-navbar .v-toolbar {
  margin-block-start: 0rem !important;
  border-radius: 0px;
  border: 0px;
  border-bottom: 1px solid #3E7DC0;
  padding: 8px 0px;
  background-color: #fff !important;

  .v-toolbar__content, .v-toolbar__extension {
    .v-container {
      align-items: center;
      display: flex;
      flex: 0 0 auto;
      position: relative;
      transition: inherit;
      width: 100%;
    }
  }
}

.nav-menu {
  display: flex;
  gap: 2rem;
}

.nav-link {
  &:not(:hover) {
    color: rgb(var(--v-theme-on-surface));
  }
}

.page-link {
  &:hover {
    color: rgb(var(--v-theme-primary)) !important;
  }
}

@media (max-width: 1280px) {
  .nav-menu {
    gap: 2.25rem;
  }
}

.nav-item-img {
  border: 10px solid rgb(var(--v-theme-background));
  border-radius: 10px;
}

.active-link {
  color: rgb(var(--v-theme-primary)) !important;
}

.app-bar-light {
  border: 2px solid rgba(var(--v-theme-surface), 68%);
  border-radius: 0.5rem;
  background-color: rgba(var(--v-theme-surface), 38%);
  transition: all 0.1s ease-in-out;
}

.app-bar-dark {
  border: 2px solid rgba(var(--v-theme-surface), 68%);
  border-radius: 0.5rem;
  background-color: rgba(255, 255, 255, 4%);
  transition: all 0.1s ease-in-out;
}

.app-bar-scrolled {
  border-radius: 0.5rem;
  background-color: rgb(var(--v-theme-surface)) !important;
  transition: all 0.1s ease-in-out;
}

.front-page-navbar::after {
  position: fixed;
  z-index: 2;
  backdrop-filter: saturate(100%) blur(6px);
  block-size: 5rem;
  content: "";
  inline-size: 100%;
}
</style>

<style lang="scss">
@use "@layouts/styles/mixins" as layoutMixins;

.mega-menu {
  position: fixed !important;
  inset-block-start: 5.4rem;
  inset-inline-start: 50%;
  transform: translateX(-50%);

  @include layoutMixins.rtl {
    transform: translateX(50%);
  }
}

.front-page-navbar {
  .v-toolbar__content {
    padding-inline: 30px !important;
  }

  .v-toolbar {
    inset-inline: 0 !important;
    margin-block-start: 1rem !important;
    margin-inline: auto !important;
  }
}

.mega-menu-item {
  &:hover {
    color: rgb(var(--v-theme-primary)) !important;
  }
}

#navigation-drawer-close-btn {
  position: absolute;
  cursor: pointer;
  inset-block-start: 0.5rem;
  inset-inline-end: 1rem;
}
</style>
