<template>
  <div class="body mb-xl-5 mt-xl-5">
    <div class="row justify-content-center">
      <form id="loginForm" action="/landing/oauth-login" method="POST">
        <div class="form-group form-control-lg">
          <input type="hidden" :value="csrfToken2" name="_token" />
          <select v-model="choice" name="choice">
            <option></option>
            <option v-for="c in choices" :key="c" :value="c">{{c}}</option>
          </select>
          <br />
        </div>
        <div class="row justify-content-center">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
    <div v-if="error" class="alert alert-danger mt-3">
      <p>{{error}}</p>
    </div>
  </div>
</template>

<script src="https://unpkg.com/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/vue-select@latest"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<script type="text/javascript">
export default {
  data() {
    return {
      csrfToken2: null,
      choices: [],
      choice: "Select a login choice",
      error: ""
    };
  },

  mounted() {
    this.loadLoginChoices(),
      (this.csrfToken2 = document.querySelector(
        'meta[name="csrf-token"]'
      ).content);
    this.urlParams = new URLSearchParams(window.location.search);
    this.error = this.urlParams.get("error");
  },

  methods: {
    loadLoginChoices() {
      axios
        .get("/landing/login-choices")
        .then(response => (this.choices = response.data.choices))
        .catch(error => console.log(error));
    }
  }
};
</script>

<style lang="scss" scoped>
</style>
