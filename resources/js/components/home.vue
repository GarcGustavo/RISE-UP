<template>
  <div class="body mb-5 mt-5">
    <h1 class="mb-3 mt-3">Look for case studies within IReN:</h1>
    <!-- Search -->
    <div
      id="search_form"
      class="navbar-form navbar-right ml-auto mt-2 mr-5 search"
    >
      <div class="input-group mb-3">
        <input type="hidden" :value="csrfToken" name="_token">
        <input
          type="text"
          name="q"
          class="form-control"
          placeholder="search"
          aria-label="Search"
          aria-describedby="basic-addon2"
        >
        <div class="input-group-append">
          <button class="btn btn-primary border-0 btn-sm"  @click="search_form()" type="submit">
            <i class="material-icons">search</i>
          </button>
        </div>
      </div>
    </div>
    <hr>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      user_id: "",
      urlParams: null,
      csrfToken: null,
      confirm_message: ""
    };
  },
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    this.urlParams = new URLSearchParams(window.location.search);
    this.user_id = this.urlParams.get("uid");
    this.confirm_message = this.urlParams.get("message");
    this.checkConfirmations();
  },

  methods: {
    checkConfirmations() {
      if (this.confirm_message != "") {
        this.confirmationBox();
      }
    },

    confirmationBox() {
      //alert box
      this.dialogue = bootbox.alert({
        title: "Confirmation Message",
        message: this.confirm_message,
        backdrop: true,
        className: "text-center"
      });

      //alert box CSS styling
      this.dialogue.find(".modal-content").css({
        height: "250px",
        "font-size": "18px",
        "text-align": "center"
      });
      this.dialogue.find(".modal-body").css({ "padding-top": "40px" });
    },
    search_form() {
      document.location.href =
        "/search?uid=" +
        this.user_id +
        "&q=" +
        document.getElementsByName("q")[0].value;
    }
  }
};
</script>

<style lang="scss" scoped>
.card .card-body {
  padding-left: 20px;
  padding-right: 20px;
}
.search input[type="text"] {
  width: 315px !important;
}
</style>
