<template>
  <div class="body mb-5 mt-5">
    <h1 class="mb-3">Login</h1>
    <div class="input-group">
      <form action="/user/login" method="POST">
        <input type="hidden" :value="csrfToken" name="_token" />
        <div class="mb-sm-2 mt-sm-2">
          <input type="email" name="email" id="u_email" placeholder="Email" />
        </div>
        <div class="mb-sm-2 mt-sm-2">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script type="text/javascript">
export default {
  data() {
    return {
      csrfToken: null
    };
  },

  mounted() {
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
  }
};
</script>

<style lang="scss" scoped>
</style>
