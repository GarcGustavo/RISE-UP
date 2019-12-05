<template>
  <!-- Navigation -->
  <div>
    <nav class="navbar fixed-top navbar-expand-lg navbar-custom shadow">
      <a class="navbar-brand" :href="'/home?uid='+uid">
        <img
          class="img-fluid rounded"
          style="width:70px;height:45px;margin-right:10px"
          src="../../../public/images/iren_logo.png"
          alt
        />
        Interdisciplinary Research Network
      </a>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav options -->
      <ul class="navbar-nav mr-3">
        <li class="nav-item">
          <span
            v-if="isAdmin || isCollaborator"
            data-toggle="modal"
            data-target="#case_create_dbox"
          >
          </span>
          <!-- else -->
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Help"
            :href="'/help?uid='+uid"
          >Help</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            data-toggle="tooltip"
            data-placement="bottom"
            title="About"
            :href="'/about?uid='+uid"
          >About</a>
        </li>

        <!-- User menu -->
        <li class="nav-item dropdown">
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      errors: []
    };
  },

  created() {},
  methods: {
    resetErrors() {
      this.errors = [];
    }
  }
};
</script>

<style lang="scss" scoped>
/*style for user title*/
.profile-usertitle {
  text-align: center;
  margin-top: 20px;
}
/*style for user's name*/
.profile-usertitle-name {
  color: #5a7391;
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 7px;
}
/*style for navbar*/
.navbar-custom {
  background-color: #333333;
  //background-color: white;
  border: 0;
}

/* change the brand and text color */
.navbar-custom .navbar-brand,
.navbar-custom .navbar-text {
  color: rgba(255, 255, 255, 0.8);
  //color: #000 !important;
}

/* change the link color */
.navbar-custom .navbar-nav .nav-link {
  color: rgba(255, 255, 255, 0.5);

  //color:black;
}

/* change the color of active or hovered links */
.navbar-custom .nav-item.active .nav-link,
.navbar-custom .nav-item:hover .nav-link {
  color: #ffffff;
}
</style>
