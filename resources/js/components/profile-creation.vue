<template>
  <div class="body mb-5 mt-5">
    <h1 class="mb-3">Profile Creation</h1>
    <div class="input-group">
      <form action="/user/create" method="POST">
        <input type="hidden" :value="csrfToken" name="_token" />
        <input type="hidden" :value="user_email" name="email" />
        <div>
          <input type="text" name="first" id="u_fname" placeholder="First Name" />
        </div>
        <div>
          <input type="text" name="last" id="u_lname" placeholder="Last Name" />
        </div>
        <div>
          <input type="email" name="contact_email" id="u_email" placeholder="Contact Email" />
        </div>
        <div>
          <input type="text" name="organization" id="u_organization" placeholder="Organization" />
        </div>
        <div>
          <input type="checkbox" name="terms" id="terms" />
          Check the box to accept
          <a href="/terms">Terms and Conditions</a> to use IReN webpage
        </div>
        <div class="row justify-content-lg-start">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
    data() {
    return {
      user_email: '',
      urlParams: null,
      csrfToken: null
    };
  },

  mounted() {
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
      this.urlParams = new URLSearchParams(window.location.search)
      this.user_email = this.urlParams.get("email")
  }
};
</script>

<style lang="scss" scoped>
</style>
