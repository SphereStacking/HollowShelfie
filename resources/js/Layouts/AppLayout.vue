<script setup>
import { ref } from 'vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3'
import ApplicationMark from '@/Jetstream/ApplicationMark.vue'
import Banner from '@/Jetstream/Banner.vue'
import Dropdown from '@/Jetstream/Dropdown.vue'
import DropdownLink from '@/Jetstream/DropdownLink.vue'
import NavLink from '@/Jetstream/NavLink.vue'
import ResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import { themeChange } from 'theme-change'

const page = usePage()
console.log(page.props)

defineProps({
  title: String,
  pageContentClass: {
    type: String,
    default: 'mt-4 px-4 sm:px-6 lg:px-8',
  },
})

const showingNavigationDropdown = ref(false)

const switchToTeam = (team) => {
  router.put(route('current-team.update'), {
    team_id: team.id,
  }, {
    preserveState: false,
  })
}

const logout = () => {
  router.post(route('logout'))
}

const auth_user = ref(page.props.auth.user ?? null)
const isTeam = ref(auth_user.value?.current_team != null)
const isLogin = ref(auth_user.value !== null)
</script>

<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-base-100 pb-4">
      <nav class="bg-base-100 shadow  ">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-10 justify-between">
            <div class="flex">
              <!-- Logo -->
              <div class="flex shrink-0 items-center">
                <Link :href="route('home')">
                  <ApplicationMark class="block h-9 w-auto" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink :href="route('home')" :active="route().current('home')" c>
                  <IconTypeMapper type="home" class="mr-0.5 text-xl" />
                  home
                </NavLink>
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                  <IconTypeMapper type="dashboard" class="mr-0.5 text-xl" />
                  dashboard
                </NavLink>
                <!-- <NavLink :href="route('home')" :active="route().current('articles')">
                  Articles
                </NavLink> -->
                <NavLink :href="route('event.timeline.show')" :active="route().current('event.timeline.show')">
                  <IconTypeMapper type="timeline" class="mr-0.5 text-xl" />
                  timeline
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center sm:gap-2">
              <a class="btn btn-sm" :href="route('event.search.index')">
                <Icon icon="mdi:magnify" class="mx-2 text-sm" />
              </a>
              <template v-if="!isLogin">
                <Link :href="route('login')" class="btn  btn-sm">
                  {{ $t('Login') }}
                </Link>
                <Link :href="route('register')" class="btn  btn-sm">
                  {{ $t('Register') }}
                </Link>
              </template>

              <div v-if="isLogin" class="relative">
                <!-- Teams Dropdown -->
                <Dropdown align="right" width="60">
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button type="button" class="btn btn-sm">
                        {{ auth_user.current_team ? auth_user.current_team.name : 'チームを作成してみよう！' }}
                        <svg
                          class="-mr-0.5 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path
                            stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <div class="w-60">
                      <!-- Team Management -->
                      <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ $t('Manage Team') }}
                      </div>
                      <!-- Team Settings -->
                      <DropdownLink v-if="isTeam" :href="route('teams.show', auth_user.current_team)">
                        {{ $t('Team Settings') }}
                      </DropdownLink>

                      <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                        {{ $t('Create New Team') }}
                      </DropdownLink>

                      <!-- Team Switcher -->
                      <template v-if="auth_user.all_teams.length > 1">
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                          {{ $t('Switch Teams') }}
                        </div>

                        <template v-for="team in auth_user.all_teams" :key="team.id">
                          <form @submit.prevent="switchToTeam(team)">
                            <DropdownLink as="button">
                              <div class="flex items-center">
                                <svg
                                  v-if="team.id == auth_user.current_team_id" class="mr-2 h-5 w-5 text-green-400"
                                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                  stroke-width="1.5"
                                  stroke="currentColor">
                                  <path
                                    stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                <div>{{ team.name }}</div>
                              </div>
                            </DropdownLink>
                          </form>
                        </template>
                      </template>
                    </div>
                  </template>
                </Dropdown>
              </div>

              <!-- Settings Dropdown -->
              <div v-if="isLogin" class="relative">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <button
                      class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
                      <img
                        class="h-8 w-8 rounded-full object-cover" :src="auth_user.profile_photo_url"
                        :alt="auth_user.name">
                    </button>
                  </template>

                  <template #content>
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs ">
                      {{ $t('Manage Account') }}
                    </div>

                    <DropdownLink :href="route('profile.show')">
                      {{ $t('Profile') }}
                    </DropdownLink>

                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                      {{ $t('API Tokens') }}
                    </DropdownLink>

                    <div class="border-t border-gray-200"></div>

                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                      <DropdownLink as="button">
                        {{ $t('Log Out') }}
                      </DropdownLink>
                    </form>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                @click="showingNavigationDropdown = !showingNavigationDropdown">
                <svg
                  class="h-6 w-6" stroke="currentColor" fill="none"
                  viewBox="0 0 24 24">
                  <path
                    :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
                  <path
                    :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }" class="sm:hidden">
          <div class="space-y-1 pb-3 pt-2">
            <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
              {{ $t('Dashboard') }}
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="flex items-center px-4">
              <template v-if="isLogin">
                <div class="mr-3 shrink-0">
                  <img
                    class="h-10 w-10 rounded-full object-cover" :src="auth_user.profile_photo_url"
                    :alt="auth_user.name">
                </div>

                <div>
                  <div class="text-base font-medium text-gray-800">
                    {{ auth_user.name }}
                  </div>
                  <div class="text-sm font-medium text-gray-500">
                    {{ auth_user.email }}
                  </div>
                </div>
              </template>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                {{ $t('Profile') }}
              </ResponsiveNavLink>

              <ResponsiveNavLink
                v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')"
                :active="route().current('api-tokens.index')">
                {{ $t('API Tokens') }}
              </ResponsiveNavLink>

              <!-- Authentication -->
              <form method="POST" @submit.prevent="logout">
                <ResponsiveNavLink as="button">
                  {{ $t('Log Out') }}
                </ResponsiveNavLink>
              </form>

              <!-- Team Management -->
              <template v-if="isLogin">
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                  {{ $t('Manage Team') }}
                </div>

                <!-- Team Settings -->
                <ResponsiveNavLink
                  v-if="isTeam" :href="route('teams.show', auth_user.current_team)"
                  :active="route().current('teams.show')">
                  {{ $t('Team Settings') }}
                </ResponsiveNavLink>

                <ResponsiveNavLink
                  v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')"
                  :active="route().current('teams.create')">
                  {{ $t('Create New Team') }}
                </ResponsiveNavLink>

                <!-- Team Switcher -->
                <template v-if="auth_user.all_teams.length > 1">
                  <div class="border-t border-gray-200"></div>

                  <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ $t('Switch Teams') }}
                  </div>

                  <template v-for="team in auth_user.all_teams" :key="team.id">
                    <form @submit.prevent="switchToTeam(team)">
                      <ResponsiveNavLink as="button">
                        <div class="flex items-center">
                          <svg
                            v-if="team.id == auth_user.current_team_id" class="mr-2 h-5 w-5 text-green-400"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor">
                            <path
                              stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          <div>{{ team.name }}</div>
                        </div>
                      </ResponsiveNavLink>
                    </form>
                  </template>
                </template>
              </template>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header v-if="$slots.header" class="shadow">
        <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
          <slot name="header"></slot>
        </div>
      </header>
      <!-- Page Content -->
      <main :class="pageContentClass">
        <slot></slot>
      </main>
    </div>
    <Footer />
  </div>
</template>
