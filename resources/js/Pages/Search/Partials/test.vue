<template lang="">
  <div class="relative">
    <input id="menu" type="checkbox" class="peer/menu hidden" />
    <label for="menu" class="absolute left-0 top-0 text-lg opacity-100 transition-all duration-300 peer-checked/menu:opacity-0">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 6h18v2H3zm0 5h18v2H3zm0 5h18v2H3z" /></svg>
    </label>
    <label for="menu" class="absolute left-0 top-0 -rotate-90 text-lg opacity-0 transition-all duration-300 peer-checked/menu:rotate-0 peer-checked/menu:opacity-100">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z" /></svg>
    </label>
  </div>
</template>
<script>
export default {

}
</script>
<style lang="">

</style>
