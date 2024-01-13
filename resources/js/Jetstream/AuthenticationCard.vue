<template>
  <div class="flex min-h-screen flex-col items-center bg-base-100 pt-6 sm:justify-center sm:pt-0 ">
    <div>
      <slot name="logo"></slot>
    </div>

    <div class="mt-6 w-full overflow-hidden bg-base-200 px-6  py-4 shadow-md sm:max-w-md sm:rounded-lg">
      <slot></slot>
    </div>
  </div>
</template>
