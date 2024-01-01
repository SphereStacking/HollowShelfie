<script setup>
import { router, Link } from '@inertiajs/vue3';
const props = defineProps({
  profile: {
    type: Object,
    required: true
  },
  events: {
    type: Array,
    required: true
  },
  url: {
    type: String,
    required: true
  },
})


const dataile = props.profile.dataile
const authUser = ref({})
const isFollowedBtnOver = ref()

authUser.value = props.profile.auth_user

watch(authUser, (newVal, oldVal) => {
  console.log('authUser has changed', newVal, oldVal)
})

const follow = () => {
  if (!authUser.value.is_followed) {
    router.visit(route('users.follow', dataile.id), {
      method: 'post',
      preserveState: false,
      preserveScroll: true,
      onSuccess: (result) => {
        console.log(result)
      }
    })
  } else {
    router.visit(route('users.unfollow', dataile.id), {
      method: 'delete',
      preserveState: false,
      preserveScroll: true,
      onSuccess: (result) => {
        console.log(result)
      }
    })
  }
}

const isMounted = ref(false)
onBeforeMount(() => {
  setTimeout(() => {
    isMounted.value = true
  }, 500)
});

const getButtonText = (event) => {
  return `${event.name}`
}
const querySetter = (value,type) => {
  console.log(value )
  return [
    { include: 'and', type: 'user', value: props.profile.dataile.name },
    { include: 'and', type: type.toString(), value: value.name },
  ];
}
</script>
<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-neutral">
      </h2>
    </template>
    <div class="max-w-7xl mx-auto my-6 flex flex-col gap-4">
      <Card class="mt-10">
        <template #header>
        </template>
        <div class="flex flex-col items-center -mt-10">
          <div class="hero">
            <div class="relative flex gap-10 w-full flex-col lg:flex-row">
              <div class=" group">
                <div
                  class='absolute bottom-0 bg-accent origin-center  transition-all duration-700  rounded-lg -inset-x-2 -inset-y-2  '
                  :class="isMounted ? ' w-52 h-52' : ' h-0 w-0 rotate-12  '">
                </div>
                <div class="h-48 w-48">
                  <img :src="dataile.photo_url" class="absolute h-full mx-auto rounded-lg shadow-2xl bg-base-300" />
                </div>
              </div>
              <div class="flex flex-col pt-10 w-full">
                <div class="flex flex-row justify-between">
                  <p class="text-2xl font-bold  text-center lg:text-left">{{ dataile.name }}</p>
                  <div class="flex items-end gap-4">
                    <button class="btn btn-circle btn-sm btn-primary">
                      <Icon icon="line-md:bell" class="text-xl"></Icon>
                    </button>
                    <button
                      :class="authUser.is_followed ? 'btn  btn-sm btn-success hover:btn-error' : 'btn  btn-sm btn-outline hover:btn-success'"
                      @mouseover="isFollowedBtnOver = true" @mouseleave="isFollowedBtnOver = false" @click="follow">
                      <Icon
                        :icon="authUser.is_followed ? isFollowedBtnOver ? 'line-md:account-remove' : 'line-md:account-small' : 'line-md:account-add'"
                        class="text-xl"></Icon>
                      {{ authUser.is_followed ? isFollowedBtnOver ? ' Un Follow' : 'Followed' : 'Follow' }}
                      <div class="badge">{{ dataile.followers_count }}</div>
                    </button>
                    <button class="btn btn-neutral btn-sm flex flex-row ">
                      <Icon icon="line-md:email" class="text-xl"></Icon>
                      Connect
                    </button>
                  </div>
                </div>
                <div class="flex flex-row justify-between">
                  <div class="flex items-center py-2">
                    <LinkExts class="flex gap-1" :links="dataile.links"></LinkExts>
                  </div>
                  <div class="flex items-center gap-2">
                    <template v-for="badge in dataile.badges">
                      <Icon :icon="badge.icon_class" class="text-xl"></Icon>
                    </template>
                  </div>
                </div>
                <div class="parse w-full bg-base-300 rounded-lg h-full p-2">
                  {{ dataile.content }}
                </div>
                <div>
                  <div class="flex flex-row gap-1 items-center">
                    <div class="flex gap-1 rounded-md items-center  mr-auto">
                      <IconTypeMapper type="tag" class="text-xl"></IconTypeMapper>
                      <template v-for="(tag, index) in dataile.tags" :key="index">
                        <BtnEventSerchItem :buttonTextSetter="getButtonText" :querySetter="querySetter" :value="tag" type="tag" isNavigate></BtnEventSerchItem>
                      </template>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Card>

      <div class="w-full grid xl:grid-cols-6 md:grid-cols-4  sm:grid-cols-3 grid-cols-2  gap-6 my-2">
        <CardEvent v-for="(item, index) in props.events.data" :key="index" :event="item" scroll-region />
      </div>


      <Link :href="url" method="get" class=" btn btn-primary btn-sm">show more!
      </Link>

    </div>
  </AppLayout>
</template>
<style lang="">

</style>
