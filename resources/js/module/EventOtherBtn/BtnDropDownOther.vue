<script setup lang="ts">
import { SnsShare, Good, Bookmark } from './BtnDropDownOtherTypes'

defineProps<{
  eventAlias: string,
  snsShare: SnsShare,
  good: Good,
  bookmark: Bookmark
}>()

</script>

<template>
  <div class="flex flex-row gap-1">
    <!-- <BtnSwapEventGood
      :event-id="eventDetails.alias" :check="eventDetails.authUser?.isGood" :count="eventDetails.shortGoodCount"
      show-count /> -->
    <div class="dropdown dropdown-end dropdown-bottom">
      <div tabindex="0" role="button" class="btn btn-ghost btn-xs p-0">
        <Icon icon="mdi:dots-vertical" class="text-xl" />
      </div>
      <ul tabindex="0" class="menu dropdown-content z-[1] w-auto rounded-box bg-base-200 p-2 shadow">
        <li>
          <BtnSwapEventGood
            :event-id="eventAlias" :check="!good.isGood"
            show-count />
        </li>
        <li>
          <BtnSwapEventBookmark :event-id="eventAlias" :check="!bookmark.isBookmark" />
        </li>
        <li>
          <BtnSnsShareEventToX
            :title="snsShare.title" :period="snsShare.period" :instance-names="snsShare.instances"
            :organizer-names="snsShare.organizers" :performer-names="snsShare.performers"
            :category-names="snsShare.categoryNames" :tags="snsShare.tags" :route="snsShare.route" />
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
</style>
