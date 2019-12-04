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
        >
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

      <!-- Search bar -->

      <form action="/search" class="navbar-form navbar-right ml-auto mt-2 mr-5 search">
        <div v-if="!disable_header_search" class="input-group mb-3">
          <input
            type="text"
            name="q"
            class="form-control"
            placeholder="search"
            aria-label="Search"
            aria-describedby="basic-addon2"
          >
          <div class="input-group-append">
            <button class="btn btn-primary border-0 btn-sm" type="submit">
              <i class="material-icons">search</i>
            </button>
          </div>
        </div>
      </form>

      <!-- Nav options -->
      <ul class="navbar-nav mr-3">
        <li class="nav-item">
          <span
            v-if="isAdmin || isCollaborator"
            data-toggle="modal"
            data-target="#case_create_dbox"
          >
            <a
              class="nav-link"
              data-toggle="tooltip"
              @click.prevent="show_dialogue=true"
              href="#case_create_dbox"
              data-placement="bottom"
              title="Create case study"
            >Collaborate</a>
          </span>
        <!-- else -->
           <a
           v-if="isViewer"
            class="nav-link"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Collaborator"
            href="#"
          >Collaborator</a>
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
          <span data-toggle="dropdown">
            <a
              href="#"
              class="nav-link dropdown-toggle"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Profile"
            >
              <i class="material-icons" style="font-size: 25px">person</i>
            </a>
          </span>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="profile-usertitle">
              <div class="profile-usertitle-name">{{user_name}}</div>
              <div class="profile-usertitle-role">
                <a v-if="isAdmin">Admin</a>
                <a v-if="isViewer">Viewer</a>
                <a v-if="isCollaborator">Collaborator</a>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <a v-if="isAdmin" :href="'/admin/users-requests?uid='+uid" class="dropdown-item">Dashboard</a>
            <a :href="'/user/profile?uid='+uid" class="dropdown-item">Profile</a>
            <a v-if="isCollaborator || isAdmin" :href="'/user/cases?uid='+uid" class="dropdown-item">Cases</a>
            <a v-if="isCollaborator || isAdmin" :href="'/user/groups?uid='+uid" class="dropdown-item">Groups</a>
            <div class="dropdown-divider"></div>
            <a href="/shibboleth-logout2" class="dropdown-item">Logout</a>
          </div>
        </li>
      </ul>

      <!-- show case study dialogue box when creating it from group -->
    </nav>
    <div v-if="show_dialogue">
      <case-create-dbox
        :action="'Create'"
        :acted_on="'case study'"
        :errors="errors"
        @close="resetErrors"
        @createCaseStudy="createCaseStudy"
      ></case-create-dbox>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: "",
      user_name: "",

      errors: [],

      uid: "",
      isAdmin: false, //change to false when integration is complete
      isViewer: false,
      isCollaborator: false,
      disable_header_search: false,
      show_dialogue: false
    };
  },

  created() {
    this.getUser();
  },
  methods: {
    resetErrors() {
      this.errors = [];
    },

    getUser() {
      this.urlParams = new URLSearchParams(window.location.search); //get url parameters
      this.curr_user = Number(this.urlParams.get("uid")); //get user id
      this.q = this.urlParams.get("q");
      if (this.q != null) {
        this.disable_header_search = true;
      }

      fetch("/user?uid=" + this.curr_user)
        .then(res => res.json())
        .then(res => {
           // console.log(res);
          this.user = res.data[0];
          if (this.user.u_role == 4) {
            this.isAdmin = true;
          } else if (this.user.u_role == 3) {
            this.isCollaborator = true;
          } else {
            this.isViewer = true;
          }
          this.uid = this.user.uid;
          this.user_name = this.user.first_name +' '+this.user.last_name;
        });

    },

    /**
     * @description outputs to the caseController a JSON request to create case study
     * @param {Array} case_study - array of case study data to create a case study - data is sent by the case_create_dbox dialogue
     */
    createCaseStudy(case_study) {
      fetch("/case/create", {
        method: "post",
        //Add json content type application to indicate the media type of the resource.
        //Add access control action response that tells the browser to allow code
        //from any origin to access the resource
        //Add Cross-site request forgery protection token
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(case_study)
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);

          if (!res.errors) {
            //hide action table dbox
            this.show_dialogue = false;

            //remove component's backdrop
            $("body").removeClass("modal-open");

            $(".modal-backdrop").remove();

            this.appendDefaultParameters(case_study.cid); //default case study parameters
            //  this.resetErrors(); //reset error variable
          } else {
            this.errors = res.errors;
          }
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description add null default parameters to Case study
     */
    appendDefaultParameters(cid) {
      fetch("/parameter/create/defaults", {
        method: "post",
        //Add json content type application to indicate the media type of the resource.
        //Add access control action response that tells the browser to allow code
        //from any origin to access the resource
        //Add Cross-site request forgery protection token
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify({ cid: cid })
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);

          if (!res.errors) {
            this.resetErrors(); //reset errors

            //once creation process is complete go to case study
            window.location.href = "http://127.0.0.1:8000/case/body?cid=" + cid;
          } else {
            this.errors = res.errors;
          }
        })
        .catch(err => {
          console.error("Error: ", err);
        });
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
  width: 250px;

  max-width: 250px;
}
/*search bar width*/
.search input[type="text"] {
  width: 315px !important;
}
</style>
