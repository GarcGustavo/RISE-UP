<template>
  <div class="body mb-xl-5 mt-xl-5">
    <div class="row justify-content-center">
      <form id="loginForm" action="/shibboleth-login" method="POST">
        <div class="form-group form-control-lg">
          <input type="hidden" :value="csrfToken" name="_token" />
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
  </div>
</template>

<script src="https://unpkg.com/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/vue-select@latest"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<script type="text/javascript">
export default {
  data() {
    return {
      choices: [],
      choice: "Select a login choice",
      csrfToken: null
    };
  },

  mounted() {
    this.loadLoginChoices(),
      (this.csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
      ).content);
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
