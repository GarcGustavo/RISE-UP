<template>
  <!--member group action table
        this table is used everytime a user wants to remove
         members of an existing group or to add an existing
         user to a new group
  -->
  <transition>
    <div>
      <div
        class="modal fade"
        id="mg_action_table"
        tabindex="-1"
        data-keyboard="false"
        data-backdrop="static"
        role="dialog"
      >
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{action}} {{actor}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- Render group name input element to dialogue box when user creates group -->
            <div class="modal-body">
              <div class="input-group" v-if="gname_box_show==true">
                <label>Group name</label>
                <div class="input-group-append">
                  <input type="text" v-model="g_name" placeholder="Name...">
                </div>
              </div>
              <!-- Search box for table -->
              <div class="input-group">
                <label>Search</label>
                <div class="input-group-append search">
                  <input type="text" v-model="search" placeholder="User email..">
                </div>
              </div>
              <!-- table -->
              <div class="table-wrapper">
                <!-- change table id -->
                <table id="group-table" class="table table-hover table-bordered" cellspacing="0">
                  <thead class="thead-dark">
                    <tr>
                      <th id="row-checkbox">#</th>
                      <th>Email</th>
                      <th>Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user,index) in filterUsers" v-bind:key="index">
                      <td>
                        <div class="check-box">
                          <input class="checkbox" type="checkbox" v-model="uids" :value="user.uid">
                          <label for="checkbox">{{index+1}}</label>
                        </div>
                      </td>
                      <td>{{user.email}}</td>
                      <td>{{user.first_name}} {{user.last_name}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <!--Remove will change -->
              <div v-if="action=='Remove'">
                <button
                  type="button"
                  class="btn btn-primary"
                  data-toggle="modal"
                  data-target="#mg_action_confirm"
                >{{action}}</button>
              </div>
              <div v-else-if="action=='Add'  && actor=='member(s)'">
                <!--add user to group -->
                <button
                  type="button"
                  class="btn btn-primary"
                  data-dismiss="modal"
                  data-toggle="modal"
                  data-target="#mg_action_confirm"
                  @click="sendUsers(), uncheck()"
                >{{action}}</button>
              </div>
              <!-- create group -->
              <div v-else-if="action=='Create' && actor=='group'">
                <button
                  type="button"
                  class="btn btn-primary"
                  data-dismiss="modal"
                  data-toggle="modal"
                  data-target="#mg_action_confirm"
                  @click="sendGroupData(), uncheck()"
                >{{action}}</button>
              </div>
              <!--Remove member(s) -->
              <div v-else-if="action=='Remove' && actor=='member(s)'">
                <button
                  type="button"
                  class="btn btn-primary"
                  data-dismiss="modal"
                  data-toggle="modal"
                  data-target="#mg_action_confirm"
                >{{action}}</button>
              </div>

              <!-- close button -->
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                @click="uncheck()"
              >Close</button>
            </div>
          </div>
        </div>
      </div>
      <!--confirmation dialogue box -->

      <div>
        <mg_action_confirm
          :action_confirm="action"
          :actor="actor"
          @sendUsers="sendUsers"
          @sendGroupData="sendGroupData"
        ></mg_action_confirm>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    action: {
      type: String
    },
    actor: {
      type: String
    },
    gname_box_show: {
      type: Boolean,
      default: false
    },
    users: {
      type: Array
    }
  },

  data() {
    return {
      showModal: false,
      uids: [],
      user: {
        first_name: "",
        last_name: "",
        email: ""
      },
      user_to_add_remove: [],
      group_to_create: {
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      },

      g_name: "",
      groups: [],
      search: "",
      success: false
    };
  },
  created() {
    this.totalGroups();
  },

  computed: {
    filterUsers() {
      return this.users.filter(user => {
        return user.email.includes(this.search);
      });
    }
  },

  methods: {
    uncheck() {
      this.uids = [];

      for (let i in this.uids) {
        this.uids.push(this.uids[i].uid);
      }
    },

    totalGroups() {
      fetch("/groups")
        .then(res => res.json())
        .then(res=> {
          this.groups = res.data;
          console.log(this.groups[this.groups.length-1].gid);

        })
        .catch(err => console.log(err));
    },

    sendUsers() {
      //send selected users to parent component to add users
      this.path = window.location.pathname.split("/");
      this.gid = Number(this.path[this.path.length - 1]);

      for (let i in this.uids) {
        // this.user_to_add_remove[i].uid = this.uids[i];
        // this.user_to_add_remove[i].gid = this.gid;
        this.user_to_add_remove.push({
          uid: this.uids[i],
          gid: this.gid
        });
      }
      //emit data to parent

      if (this.action == "Add") {
        this.$emit("addUsers", this.user_to_add_remove);
        this.user_to_add_remove = []; //reset variable
      } else {
        this.$emit("removeUsers", this.user_to_add_remove);
        this.user_to_add_remove = []; //reset variable
        // this.uncheck(); // uncheck all values when finished
      }
    },

    sendGroupData() {
      this.path = window.location.pathname.split("/");
      this.uid = Number(this.path[this.path.length - 2]);
      this.date = new Date().toJSON().slice(0, 10);
      this.new_group_gid = this.groups.length;
      this.group_to_create.gid =this.groups[this.groups.length-1].gid+1;
      this.group_to_create.g_name = this.g_name;
      this.group_to_create.g_status = "lol";
      this.group_to_create.g_creation_date = this.date; //new Date().toLocaleString();
      this.group_to_create.g_owner = this.uid;

      for (let i in this.uids) {
        this.user_to_add_remove.push({
          uid: this.uids[i],
          gid: this.group_to_create.gid
        });
      }
      /*append owner to group*/
      this.user_to_add_remove.push({
        uid: this.uid,
        gid: this.group_to_create.gid
      });
    console.log(this.group_to_create);
      this.$emit("createGroup", this.group_to_create, this.user_to_add_remove);
      this.totalGroups();
       this.group_to_create= {
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      },
      this.user_to_add_remove=[];
    }
  }
};
</script>

<style lang="scss" scoped>
/*set table's main attributes*/
.table-wrapper {
  font-size: 18px;
  overflow-y: auto;
  overflow-x: auto;
  width: 775px;
  height: 500px;
  white-space: nowrap;
}
/*table cell attrbites*/
table tr td {
  text-align: center;
  vertical-align: middle;
  padding-top: 18px;
  padding-bottom: 18px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  max-width: 386px;
}
/*set checkbock row's width*/
#row-checkbox {
  width: 15%;
}
/*the following style are for the search text and input bar*/
.modal-body label,
.modal-body input {
  font-size: 18px;
  display: inline-block;
  margin: 5px;
}

.input-group {
  margin-bottom: 10px;
}

.input-group-append input {
  border-radius: 3px;
}

.form-check-input {
  font-size: 20px;
}

.form-control {
  height: 30px;
}

/***********************************************************/

.modal {
  background: rgba(85, 85, 85, 0.5);
}

input[type="checkbox"] + label {
  font-size: 18px;
  height: 18px;
  width: 18px;
  display: inline-block;
  padding: 0 0 0 0px;
}

input[type="checkbox"] {
  transform: scale(1.2);
}
</style>
