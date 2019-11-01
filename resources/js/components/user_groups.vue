
<template>
  <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">
      <a
        href="#mg_action_confirm"
        data-toggle="modal"
        data-target="#mg_action_confirm"
        @click="action='Remove',
        actor='group(s)'"
      >
        <i class="material-icons">remove_circle_outline</i>
      </a>
      <a
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        @click="gname_box_show=true,
        action='Create',
        actor='group', fetchUsers()"
      >
        <i class="material-icons">add_circle_outline</i>
      </a>

      <div v-if="action=='Remove'">
        <!-- if action is to remove group, render confirm box upfront; this is so there's no display issues with action_table since it also renders a confirm box -->
        <mg_action_confirm :action_confirm="action" :actor="actor"></mg_action_confirm>
      </div>

      <mg_action_table
        :action="action"
        :actor="actor"
        :gname_box_show="gname_box_show"
        :users="users"
      ></mg_action_table>

      <p>My groups</p>
    </h1>

    <hr>
    <!-- Table -->
    <table id="group-table" class="table table-hover table-bordered table-sm" cellspacing="0">
      <thead class="thead-dark">
        <tr>
          <th id="row-order">#</th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(group,index) in pageOfGroups" :key="index">
          <td>
            <div class="check-box">
              <input class="checkbox" type="checkbox" id="'checkbox' + index" v-model="checked">
              <label for="'checkbox' + index">{{index+1}}</label>
            </div>
          </td>
          <td>
            <a :href="'/group/' + group.gid">{{group.g_name}}</a>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="ready">
      <paginator :items="groups" @changePage="onChangePage" class="pagination"></paginator>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ready: false,
      groups: [],
      pageOfGroups: [],
      users: [],
      uid: "",
      action: "",
      actor: "",
      gname_box_show: false //boolean to append group name input to dialogue box when creating a group
    };
  },
  components: {},
  created() {
    this.fetchGroups();
  },

  methods: {
    onChangePage(pageOfGroups) {
      // update page of Groups
      this.pageOfGroups = pageOfGroups;
    },

    fetchUsers() {
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
        })
        .catch(err => console.log(err));
    },

    fetchGroups() {
      this.path = window.location.pathname.split("/");
      this.uid = this.path[this.path.length - 2];
      fetch("/user_groups/" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
          this.ready = true;
        })
        .catch(err => console.log(err));
    }
  }
};
</script>


<style lang="scss" scoped>
/* align table to center */
table {
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}
/* control column display format for and content size
*Block is display to make whole row selectable
*/
table tr td a {
  display: block;
  font-size: 18px;
}
/* This is for row content style and alignment */
td a {
  text-align: center;
  margin: auto;
  vertical-align: middle;
  color: black;
  text-decoration: none;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  padding-top: 20px;
  padding-bottom: 20px;
  max-width: 775px;
}
/* align vertically to center checkbox */
table tr td .check-box {
  padding-top: 20px;
}
/* checkbox column width */
#row-order {
  width: 15%;
}
/* check box and label styling */
input[type="checkbox"] + label {
  font-size: 18px;
  height: 18px;
  width: 18px;
  display: inline-block;
  padding: 0 0 0 0px;
}
/* change checkbox size */
input[type="checkbox"] {
  transform: scale(1.2);
}
/* paginate component position in body */
.pagination {
  float: right;
}
/* add/remove icons position in relation to header */
h1 i {
  float: right;
  margin: 10px;
  margin-top: 20px;
}
/* change icon background when hovered */
h1 i:hover {
  color: blue;
}
/* icon initial color */
a {
  color: black;
}
</style>
