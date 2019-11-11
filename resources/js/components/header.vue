<template>
  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-custom">
    <a class="navbar-brand" href="#">Interdisciplinary Research Network</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Search bar -->
    <form class="navbar-form navbar-right ml-auto mt-2 mr-5 search" action>
      <div class="input-group mb-3">
        <input
          type="text"
          class="form-control"
          placeholder="search"
          aria-label="Search"
          aria-describedby="basic-addon2"
        >
        <div class="input-group-append">
          <button class="btn btn-primary border-0 btn-sm" type="button">
            <i class="material-icons">search</i>
          </button>
        </div>
      </div>
    </form>

    <!-- Nav options -->
    <ul class="navbar-nav mr-3">
      <li class="nav-item">
        <a class="nav-link" href>Collaborate</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/help">Help</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/about">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href>Language</a>
      </li>

      <!-- User menu -->
      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <i class="material-icons" style="font-size: 25px">person</i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="profile-usertitle">
            <div class="profile-usertitle-name">Melvin J Malave</div>
            <div class="profile-usertitle-role">Admin</div>
          </div>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">Profile</a>
          <a :href="'/user/'+uid+'/cases'" class="dropdown-item">Cases</a>
          <a :href="'/user/'+uid+'/groups'" class="dropdown-item">Groups</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">Logout</a>
        </div>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      uid: 10
    };
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
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 7px;
}
/*style for navbar*/
.navbar-custom {
  background-color: #333333;
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
}

/* change the color of active or hovered links */
.navbar-custom .nav-item.active .nav-link,
.navbar-custom .nav-item:hover .nav-link {
  color: #ffffff;
}

/* for dropdown only - change the color of dropdown */
.navbar-custom .dropdown-menu {
  background-color: #ffffff;
}
/*dropdown item text color*/
.navbar-custom .dropdown-item {
  color: black;
}
/*dropdown item text hover and focus styles*/
.navbar-custom .dropdown-item:hover,
.navbar-custom .dropdown-item:focus {
  color: #333333;
  background-color: lightgray;
}
/*item's padding*/
.navbar-custom .dropdown-item {
  padding-top: 10px;
  padding-bottom: 10px;
}
/*item's width*/
.navbar-custom .dropdown-menu {
  width: 35px;
}
/*search bar width*/
.search input[type="text"] {
  width: 315px !important;
}
</style>
