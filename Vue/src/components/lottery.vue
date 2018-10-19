<template>
<div>

</div>
</template>
<script>
export default
{
  name:'lottery',
  created () {
    setInterval(() => this.now = new Date, 1000 * 60)
  }
  computed: {
    now () {
      return new Date
    }
  }
}
</script>
<style></style>
