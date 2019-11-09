
<template>
  <div class="body mb-5 mt-5">
    <!-- buttons to create or remove a group -->
    <h1 class="mb-3">
      <!-- button if clicked, render confirmation dialogue box to validate user's action -->
      <a
        href="#action_confirm_dbox"
        data-toggle="modal"
        data-target="#action_confirm_dbox"
        @click="action='Remove',
        acted_on='group(s)',isGroupSelected()"
      >
        <div class="add_icon" style="display:inline-block;float:right;">
          <a style="font-size:18px;margin-left:15px">Remove</a>
          <i class="material-icons">remove_circle_outline</i>
        </div>
      </a>
      <!-- button if clicked, render create group input box -->
      <div>
        <a
          href="#action_table_dbox"
          data-toggle="modal"
          data-target="#action_table_dbox"
          @click="gname_box_show=true,
        action='Create',
        acted_on='group', fetchUsers()"
        >
          <div class="remove_icon" style="display:inline-block;float:right;">
            <a style="font-size:18px">Create</a>
            <i class="material-icons">add_circle_outline</i>
          </div>
        </a>
      </div>

      <p>My groups</p>
    </h1>
    <div v-if="action=='Remove'">
      <!-- if action is to remove group(s) render confirmation dialogue to validate user's request-->
      <action_confirm_dbox
        :action_confirm="action"
        :acted_on="acted_on"
        :isSelected="isSelected"
        @removeGroups="removeGroups"
      ></action_confirm_dbox>
    </div>
    <div v-if="action=='Create'">
      <!-- if action is to create group(s) render confirmation dialogue alerting execution of said action-->
      <action_table_dbox
        :action="action"
        :acted_on="acted_on"
        :gname_box_show="gname_box_show"
        :users="users"
        @createGroup="createGroup"
      ></action_table_dbox>
    </div>
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
        <!--list user's groups -->
        <tr v-for="(group,index) in pageOfGroups" :key="index">
          <!-- if user is not owner of group eliminate option to remove group -->

          <td v-if="group.g_owner==curr_user">
            <div class="check-box">
              <input
                class="checkbox"
                type="checkbox"
                id="checkbox"
                v-model="selected_groups"
                :value="group.gid"
              >
              <label for="checkbox">{{index+1}}</label>
            </div>
          </td>
          <td v-else>
            <div>
              <label style="padding-top:18px;padding-left:18px;">{{index+1}}</label>
            </div>
          </td>
          <td>
            <a :href="'/user/'+curr_user+'/group/' + group.gid">{{group.g_name}}</a>
          </td>
        </tr>
      </tbody>
    </table>
    <!--number of entries per table page option -->
    <div id="container">
      <div class="btn-group" style="padding-top:12px;width:100px;">
        <label style="padding-right:5px;padding-top:5px;;">Entries:</label>
        <!-- entries button -->
        <button
          class="btn btn-primary btn-sm dropdown-toggle"
          type="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >{{entries_per_page_table}}</button>
        <div class="dropdown-menu">
          <a class="dropdown-item" @click="selectEntries(4)" href="#">4</a>
          <a class="dropdown-item" @click="selectEntries(8)" href="#">8</a>
          <a class="dropdown-item" @click="selectEntries(16)" href="#">16</a>
          <a class="dropdown-item" @click="selectEntries(32)" href="#">32</a>
        </div>
      </div>
      <!-- paginator -->
      <div id="paginate" v-if="reload_paginator">
        <paginator
          :items="user_groups"
          :pageSize="entries_per_page_table"
          @changePage="onChangePage"
          class="pagination"
          style="display:inline-block"
        ></paginator>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      curr_user: "", //current user id
      action: "", //action the user is executing
      acted_on: "", //on what is the action being exected

      user_groups: [], // groups of the user
      selected_groups: [], // the groups the user selects
      groups_to_remove: [], // the groups to remove, sent to controller
      pageOfGroups: [], //groups to show on table page
      users: [],

      group: { //group attributes
        gid: "",
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      },

      entries_per_page_table: 4, //table entries

      reload_paginator: false, //used to update paginator
      isSelected: false, //has user made a selection
      gname_box_show: false //boolean to append group name input to dialogue box when creating a group
    };
  },

  created() {
    this.fetchGroups();
  },

  computed: {},
  methods: {
    onChangePage(pageOfGroups) {
      // update page of Groups
      this.pageOfGroups = pageOfGroups;
    },
    isGroupSelected() {
      if (this.selected_groups.length == 0) {
        this.isSelected = false;
      } else {
        this.isSelected = true;
      }
    },

    selectEntries(entry) {
      this.entries_per_page_table = entry;
      this.updatePaginator();
    },

    updatePaginator() {
      // Remove paginator from the DOM
      this.reload_paginator = false;

      this.$nextTick().then(() => {
        // Add the paginator back in
        this.reload_paginator = true;
      });
    },

    uncheck() {
      this.selected_groups = [];

      for (let i in this.selected_groups) {
        this.selected_groups.push(this.selected_groups[i].gid);
      }
    },

    fetchUsers() {
      this.path = window.location.pathname.split("/");
      this.curr_user = this.path[this.path.length - 2];
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
          //filter user from list to show in table
          this.users = this.users.filter(x => x.uid !== this.curr_user); //filter owner so he can't remove himself
        })
        .catch(err => console.log(err));
    },

    fetchGroups() {
      this.path = window.location.pathname.split("/");
      this.curr_user = this.path[this.path.length - 2];
      fetch("/user_groups/" + this.curr_user)
        .then(res => res.json())
        .then(res => {
          this.user_groups = res.data;
          this.pageOfGroups = this.user_groups;
          this.uncheck();
          this.updatePaginator();
        })
        .catch(err => console.log(err));
    },

    createGroup(group, members) {
      // console.log(JSON.stringify(group));
      // console.log(JSON.stringify(members));
      fetch("/group/create", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(group)
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
          console.log(group);
          this.addUsers(members);
          this.fetchGroups();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    addUsers(users_to_add) {
      fetch("/group/members/add", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(users_to_add)
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
          console.log(users_to_add);
          this.fetchGroups();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    removeGroups() {
      for (let i in this.selected_groups) {
        this.groups_to_remove.push({
          gid: this.selected_groups[i]
        });
      }

      fetch("/user_groups/remove", {
        method: "delete",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(this.groups_to_remove)
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
          console.log(this.groups_to_remove);

          this.fetchGroups();
          this.groups_to_remove = [];
        })
        .catch(err => {
          console.error("Error: ", err);
        });
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

#paginate {
  width: 500px;
  padding-top: 12px;
  padding-right: 10px;
  float: right;
}
/* add/remove icons position in relation to header */
h1 i {
  float: right;
  margin: 10px;
  margin-top: 20px;
}
/* change icon background when hovered */
h1 i:hover,
h1 a:hover {
  color: blue;
}
/* icon initial color */
a {
  color: black;
}
</style>
