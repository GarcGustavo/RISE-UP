<template>
  <!-- Team Members -->
  <div class="body mb-5 mt-5">
    <h1 class="text-center">Our Group</h1>

    <!--
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item active">About</li>
    </ol>
    -->
    <hr>
    <h1 class="text-center mt-5">
      <a
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        data-dismiss="modal"
        @click="showModal=true, action='Remove',
        actor='member(s)', fetchMembers()"
      >
        <i class="material-icons">remove_circle_outline</i>
      </a>
      <a
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        data-dismiss="modal"
        @click="showModal=true, action='Add',
        actor='member(s)', fetchUsers()"
      >
        <i class="material-icons">add_circle_outline</i>
      </a>
      <mg_action_table
        v-if="showModal"
        @close="showModal = false"
        :action="action"
        :actor="actor"
        :users="users"
      ></mg_action_table>

      <p style="margin-left:90px;">Members</p>
    </h1>

<!-- Members --> 
    <div class="row mt-1 mb-5" id="members">
      <div class="col-lg-4 mb-4" v-for="member in members" :key="member.uid">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">{{member.first_name}} {{member.last_name}}</h4>
            <h6 class="card-subtitle text-muted"></h6>
          </div>
          <div class="card-footer">
            <a href="#">{{member.email}}</a>
          </div>
        </div>
      </div>
    </div>

    <hr>
    <!-- Case view -->

    <h1 id="cases_header" class="mt-5 text-center">
      <a href="#">Create case study</a>
      <p style="margin-left:170px;">Our Cases</p>
    </h1>

    <div class="mt-1 card mb-5" id="cases">
      <div class="col-sm-12 mb-3">
        <ul class="list-group list-group-flush border-0">
          <li class="list-group-item" v-for="(case_study,index) in cases" :key="index">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">{{case_study.c_title}}</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">{{case_study.c_date}}</h6>
              <p class="card-text">{{case_study.c_description}}</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showModal: false,
      action: "",
      actor: "",
      gid: "",
      members: [],
      users: [],
      cases: []
    };
  },

  created() {
    this.fetchMembers();
    this.fetchCases();
  },

  methods: {
    fetchUsers() {
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data; //to send to modal
        })
        .catch(err => console.log(err));
    },

    fetchMembers() {
      this.path = window.location.pathname.split("/");
      this.gid = this.path[this.path.length - 1];
      fetch("/group/" + this.gid + "/members")
        .then(res => res.json())
        .then(res => {
          this.users = res.data; //to send to modal
          this.members = res.data;//to render in view
        })
        .catch(err => console.log(err));
    },

    fetchCases() {
      this.path = window.location.pathname.split("/");
      this.gid = this.path[this.path.length - 1];
      fetch("/group/" + this.gid + "/cases")
        .then(res => res.json())
        .then(res => {
          this.cases = res.data;
        })
        .catch(err => console.log(err));
    }
  }
};
</script>


<style lang="scss" scoped>
/* Set max height for content containers */
#cases,
#members {
  max-height: 450px;
  overflow-y: auto;
}

/* remove case cards borders */
li {
  border: none;
}

/* add/remove icons position in relation to header */
h1 i {
  float: right;
  margin: 10px;
}

/* change icon background when hovered */
h1 i:hover {
  color: blue;
}

/* icon initial color */
a {
  color: black;
}

/* position create case study button */
#cases_header a {
  float: right;
  font-size: 18px;
  margin-top: 10px;
}
</style>
