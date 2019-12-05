<template>
  <div class="body mb-5 mt-5">
    <h1 class="mb-3">Profile Creation</h1>
    <hr>
    <div v-if="errors" class="alert alert-danger">
        <ul v-for="e in errors" :key="e">
            <li>{{e}}</li>
        </ul>
    </div>
    <div class="input-group">
      <form action="/user/create" method="POST">
        <input type="hidden" :value="csrfToken" name="_token" />
        <input type="hidden" :value="user_email" name="email" />
        <div class="form-goup mt-3">
          <input class="form-control form-control-lg" type="text" name="first" id="u_fname" placeholder="First Name" />
          <small class="form-text text-muted">First name up to 32 characters.</small>
        </div>
        <div class="form-goup mt-3">
          <input class="form-control form-control-lg" type="text" name="last" id="u_lname" placeholder="Last Name" />
          <small class="form-text text-muted">Last name up to 32 characters.</small>
        </div>
        <div class="form-goup mt-3">
          <input class="form-control form-control-lg" type="email" name="contact_email" id="u_email" placeholder="Contact Email" />
          <small class="form-text text-muted">Contact email can have a different domain from upr.edu.</small>
        </div>
        <div class="form-goup mt-3">
          <input class="form-control form-control-lg" type="text" name="organization" id="u_organization" placeholder="Organization" />
          <small class="form-text text-muted">Organization up to 32 characters.</small>
        </div>
        <div class="form-group form-check mt-3">
          <input class="form-check-input" type="checkbox" name="terms" id="terms" />
          Check the box to accept
          <a href="/terms">Terms and Conditions</a> to use IReN webpage
        </div>
        <div class="form-group mt-3">
          <button type="submit" class="btn btn-primary btn-lg">Submit</button>
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
      csrfToken: null,
      errors: []
    };
  },

  mounted() {
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
      this.urlParams = new URLSearchParams(window.location.search)
      this.user_email = this.urlParams.get("email")
      this.errors = JSON.parse(this.urlParams.get("errors"))
  }
};
</script>

<style lang="scss" scoped>
</style>
