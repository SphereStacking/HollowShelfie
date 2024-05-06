<script setup>
import { ref } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import ApplicationMark from '@/Jetstream/ApplicationMark.vue'
import Dropdown from '@/Jetstream/Dropdown.vue'
import DropdownLink from '@/Jetstream/DropdownLink.vue'
import ResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import IconTypeMapper from '@/Components/IconTypeMapper.vue'

const page = usePage()

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

const headerButtons = [
  {
    href: route('home'),
    active: route().current('home'),
    icon: 'home',
    label: 'Home',
  },
  {
    href: route('dashboard'),
    active: route().current('dashboard'),
    icon: 'dashboard',
    label: 'Dashboard',
  },
  {
    href: route('event.timeline.show'),
    active: route().current('event.timeline.show'),
    icon: 'timeline',
    label: 'Timeline',
  },
]
</script>

<template>
  <nav class="bg-base-300">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
      <div class="flex h-10 justify-between">
        <div class="flex">
          <!-- Logo -->
          <div class="flex shrink-0 items-center">
            <Link :href="route('home')">
              <ApplicationMark class="block h-9 w-auto" />
            </Link>
          </div>

          <!-- Navigation Links -->
          <div class="hidden items-center space-x-4 sm:-my-px sm:ml-10 sm:flex">
            <Link
              v-for="button in headerButtons"
              :key="button.href"
              :href="button.href"
              class="btn btn-ghost no-animation btn-sm"
              :class="{ 'btn-active': button.active }">
              <IconTypeMapper :type="button.icon" class="mr-0.5 text-xl" />
              {{ button.label }}
            </Link>
          </div>
        </div>

        <div class="hidden sm:ml-6 sm:flex sm:items-center sm:gap-2">
          <Link class="btn btn-primary btn-active no-animation btn-sm " :href="route('event.search.index')">
            <IconTypeMapper type="search" class="mx-2 text-xl" />
          </Link>
          <Link v-if="!isLogin" :href="route('login')" class=" btn btn-primary btn-sm">
            {{ $t('Login') }}
          </Link>
          <Link v-if="!isLogin" :href="route('register')" class="btn btn-secondary btn-sm">
            {{ $t('Register') }}
          </Link>

          <div v-if="isLogin" class="relative">
            <!-- Teams Dropdown -->
            <Dropdown align="right" width="60">
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button type="button" class="btn btn-secondary btn-active no-animation btn-sm">
                    {{ auth_user.current_team ? auth_user.current_team.name : $t('Create Team') }}
                    <IconTypeMapper type="arrowDown" class="-mr-0.5 ml-1 text-xl" />
                  </button>
                </span>
              </template>

              <template #content>
                <div class="w-60 drop-shadow-2xl">
                  <!-- Team Management -->
                  <div class="block px-4 py-2 text-xs text-base-content">
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

                    <div class="block px-4 py-2 text-xs text-base-content">
                      {{ $t('Switch Teams') }}
                    </div>

                    <template v-for="team in auth_user.all_teams" :key="team.id">
                      <DropdownLink @click="switchToTeam(team)">
                        <div class="flex items-center">
                          <svg
                            v-if="team.id == auth_user.current_team_id" class="mr-2 h-5 w-5 text-success"
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
                <DropdownLink @click="logout">
                  {{ $t('Log Out') }}
                </DropdownLink>
              </template>
            </Dropdown>
          </div>
        </div>

        <!-- Hamburger -->
        <div class="-mr-2 flex items-center sm:hidden">
          <BtnSwapHamburger v-model:check="showingNavigationDropdown" />
        </div>
      </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <transition
      enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <div v-if="showingNavigationDropdown" class="bg-base-300/80 sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
          <ResponsiveNavLink
            v-for="button in headerButtons"
            :key="button.href"
            class="ml-2 rounded-l-md"
            :href="button.href"
            :active="route().current(button.href)">
            <IconTypeMapper :type="button.icon" class="mr-0.5 text-xl" />
            {{ button.label }}
          </ResponsiveNavLink>
          <ResponsiveNavLink class="ml-2 rounded-l-md" :href="route('event.search.index')">
            <IconTypeMapper type="search" class="mx-0.5 text-xl" />
            Search
          </ResponsiveNavLink>
        </div>

        <!-- Responsive Settings Options -->
        <div class="">
          <div class="border-t border-neutral-500"></div>
          <div class="flex items-center px-4 pt-4">
            <template v-if="isLogin">
              <div class="mr-3 shrink-0">
                <img
                  class="h-10 w-10 rounded-full object-cover" :src="auth_user.profile_photo_url"
                  :alt="auth_user.name">
              </div>

              <div>
                <div class="text-base font-medium text-base-content">
                  {{ auth_user.name }}
                </div>
                <div class="text-sm font-medium text-base-content">
                  {{ auth_user.email }}
                </div>
              </div>
            </template>
          </div>

          <div class="mt-3">
            <ResponsiveNavLink class="ml-2 rounded-l-md" :href="route('profile.show')" :active="route().current('profile.show')">
              {{ $t('Profile') }}
            </ResponsiveNavLink>

            <ResponsiveNavLink
              v-if="$page.props.jetstream.hasApiFeatures"
              class="ml-2 rounded-l-md" :href="route('api-tokens.index')"
              :active="route().current('api-tokens.index')">
              {{ $t('API Tokens') }}
            </ResponsiveNavLink>

            <!-- Authentication -->
            <ResponsiveNavLink class="ml-2 rounded-l-md" @click="logout">
              {{ $t('Log Out') }}
            </ResponsiveNavLink>

            <!-- Team Management -->
            <template v-if="isLogin">
              <div class="border-t border-neutral-500"></div>

              <div class="block px-4 py-2 text-xs text-base-content">
                {{ $t('Manage Team') }}
              </div>

              <!-- Team Settings -->
              <ResponsiveNavLink
                v-if="isTeam"
                class="ml-2 rounded-l-md" :href="route('teams.show', auth_user.current_team)"
                :active="route().current('teams.show')">
                {{ $t('Team Settings') }}
              </ResponsiveNavLink>

              <ResponsiveNavLink
                v-if="$page.props.jetstream.canCreateTeams"
                class="ml-2 rounded-l-md" :href="route('teams.create')"
                :active="route().current('teams.create')">
                {{ $t('Create New Team') }}
              </ResponsiveNavLink>

              <!-- Team Switcher -->
              <template v-if="auth_user.all_teams.length > 1">
                <div class="border-t border-neutral-500"></div>

                <div class="block px-4 py-2 text-xs text-base-content">
                  {{ $t('Switch Teams') }}
                </div>

                <template v-for="team in auth_user.all_teams" :key="team.id">
                  <ResponsiveNavLink class="ml-2 rounded-l-md" @click="switchToTeam(team)">
                    <div class="flex items-center">
                      <svg
                        v-if="team.id == auth_user.current_team_id" class="mr-2 h-5 w-5 text-success"
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
                </template>
              </template>
            </template>
          </div>
        </div>
        <div class="border-t border-neutral-500"></div>
      </div>
    </transition>
  </nav>
</template>

<style scoped>

</style>
