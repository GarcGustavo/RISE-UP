
<template>
  <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">
      <a
        href="#mg_action_confirm"
        data-toggle="modal"
        data-target="#mg_action_confirm"
        @click="action='Remove',
        actor='group(s)',isGroupSelected()"
      >
        <div class="add_icon" style="display:inline-block;float:right;">
          <a style="font-size:18px;margin-left:15px">Remove</a>
          <i class="material-icons">remove_circle_outline</i>
        </div>
      </a>
      <div>
        <a
          href="#mg_action_table"
          data-toggle="modal"
          data-target="#mg_action_table"
          @click="gname_box_show=true,
        action='Create',
        actor='group', fetchUsers()"
        >
          <div class="remove_icon" style="display:inline-block;float:right;">
            <a style="font-size:18px">Create</a>
            <i class="material-icons">add_circle_outline</i>
          </div>
        </a>
      </div>
      <div v-if="action=='Remove' && isSelected  ">
        <!-- if action is to remove group, render confirm box upfront; this is so there's no display issues with action_table since it also renders a confirm box -->
        <mg_action_confirm
          :action_confirm="action"
          :actor="actor"
          :errors="[]"
          :isSelected="isSelected"
          @removeGroups="removeGroups"
        ></mg_action_confirm>
      </div>
      <div v-else-if="action=='Remove' && !isSelected ">
        <mg_action_confirm
          :action_confirm="action"
          :actor="actor"
          :errors="[]"
          :isSelected="isSelected"
          @removeGroups="removeGroups"
        ></mg_action_confirm>
      </div>

      <mg_action_table
        :action="action"
        :actor="actor"
        :gname_box_show="gname_box_show"
        :users="users"
        @createGroup="createGroup"
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
          <td v-if="group.g_owner==uid">
            <div class="check-box">
              <input
                class="checkbox"
                type="checkbox"
                id="checkbox"
                v-model="gids"
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
            <a :href="'/user/'+uid+'/group/' + group.gid">{{group.g_name}}</a>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="reload_paginator">
      <paginator :items="groups" @changePage="onChangePage" class="pagination"></paginator>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      reload_paginator: false,
      gids: [],
      groups: [],
      group: {
        gid: "",
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      },

      groups_to_remove: [],
      pageOfGroups: [],
      users: [],
      uid: "",
      action: "",
      actor: "",
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
      if (this.gids.length == 0) {
        this.isSelected = false;
      } else {
        this.isSelected = true;
      }
    },

    forceRerender() {
      // Remove paginator from the DOM
      this.reload_paginator = false;

      this.$nextTick().then(() => {
        // Add the paginator back in
        this.reload_paginator = true;
      });
    },

    uncheck() {
      this.gids = [];

      for (let i in this.gids) {
        this.gids.push(this.gids[i].gid);
      }
    },

    fetchUsers() {
      this.path = window.location.pathname.split("/");
      this.uid = Number(this.path[this.path.length - 2]);
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
          //filter user from list to show in table
          for (let i = 0; i < this.users.length; i++) {
            if (this.users[i].uid == this.uid) {
              this.users.splice(i, 1);
              return;
            }
          }
        })
        .catch(err => console.log(err));
    },

    fetchGroups() {
      this.path = window.location.pathname.split("/");
      this.uid = Number(this.path[this.path.length - 2]);
      fetch("/user_groups/" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
          this.pageOfGroups = this.groups;
          this.uncheck();
          this.forceRerender();
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
      for (let i in this.gids) {
        this.groups_to_remove.push({
          gid: this.gids[i]
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
