<template>
  <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">Look for study cases:</h1>
    <!-- Search -->
    <form action="/case/search" method="POST">
      <div class="input-group mb-3">
        <input
          type="text"
          name="search"
          class="form-control"
          placeholder="Search"
          aria-label="Search"
          aria-describedby="basic-addon2">
        <div class="input-group-append">
          <input type="hidden" :value="csrfToken" name="_token"/>
          <button class="btn btn-primary border-0 btn-sm" type="submit">
            <i class="material-icons">search</i>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
        return {
            user_id: '',
            urlParams: null,
            csrfToken: null,
            data: "Here goes data..."
            }
     },
    mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
        this.urlParams = new URLSearchParams(window.location.search)
        this.user_id = this.urlParams.get("uid")
    },
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
