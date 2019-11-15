<template>
  <transition>
    <div>
      <div class="modal" id="action_table_dbox" tabindex="-1" role="dialog" ref="action_modal">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{action}} {{acted_on}}</h5>
            </div>
            <!-- Render group name input element to dialogue box when user creates group -->
            <div class="modal-body">
              <div v-if="action=='Add'">
                <p style="font-size:18px;margin:15px,padding-top:25px;" aria-hidden="true">
                  Please select
                  <strong>atleast</strong> one user to add.
                </p>
              </div>
              <div v-if="action=='Remove'">
                <p style="font-size:18px;margin:15px,padding-top:25px;" aria-hidden="true">
                  Please select
                  <strong>atleast</strong> one user to remove.
                </p>
              </div>
              <div class="input-group" v-if="gname_box_show==true">
                <label>
                  <span class="required">*</span>
                  Group name
                </label>
                <div class="input-group-append">
                  <input
                    type="text"
                    maxlength="32"
                    class="form-control input-sm"
                    style="width:250px;"
                    v-model="group_name_input"
                    placeholder="Name..."
                  >
                </div>
              </div>
              <!-- Search box for table -->
              <div class="input-group">
                <label>Search</label>
                <div class="input-group-append search">
                  <input
                    type="text"
                    class="form-control input-sm"
                    style="width:250px;"
                    maxlength="32"
                    v-model="search"
                    placeholder="User email.."
                  >
                </div>
              </div>
              <!-- table -->
              <div class="table-wrapper">
                <!-- change table id -->
                <table id="group-table" class="table table-hover table-bordered" cellspacing="0">
                  <thead class="thead-dark">
                    <tr>
                      <th id="row-checkbox">
                        <input type="checkbox" @click="checkAll()" v-model="all_selected">#
                      </th>
                      <th>Email</th>
                      <th>Name</th>
                    </tr>
                  </thead>
                  <!-- list users to add -->
                  <tbody>
                    <tr v-for="(user,index) in filterUsers" v-bind:key="index">
                      <td>
                        <div class="check-box">
                          <input
                            class="checkbox"
                            type="checkbox"
                            v-model="selected_users"
                            :value="user.uid"
                            @click="select()"
                          >
                          <label for="checkbox">{{index+1}}</label>
                        </div>
                      </td>
                      <td>
                        <label>{{user.email}}</label>
                      </td>
                      <td>
                        <label>{{user.first_name}} {{user.last_name}}</label>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <!--Remove user from group  -->
              <div v-if="action=='Create'">
              <p
                v-if="action=='Add'"
                style="margin-right:510px;padding-top:15px;font-size:18px;"
                aria-hidden="true"
                id="required-description"
              >
                <span class="required">*</span>Required field
              </p>
              <p
                v-else
                style="margin-right:485px;padding-top:15px;font-size:18px;"
                aria-hidden="true"
                id="required-description"
              >
                <span class="required">*</span>Required field
              </p>
              </div>
              <div v-if="action=='Remove'">
                <button
                  type="button"
                  class="btn btn-primary"
                  :data-dismiss="close_dialog"
                  data-toggle="modal"
                  data-target="#action_confirm_dbox"
                  @click="isUserSelected()"
                >{{action}}</button>
              </div>
              <div v-else-if="action=='Add'">
                <!--add user to group -->
                <button
                  type="button"
                  class="btn btn-primary"
                  :data-dismiss="close_dialog"
                  data-toggle="modal"
                  data-target="#action_confirm_dbox"
                  @click="isUserSelected()"
                >{{action}}</button>
              </div>

              <!-- create group -->
              <div v-else-if="action=='Create'">
                <button
                  type="button"
                  class="btn btn-primary"
                  :data-dismiss="close_dialog"
                  data-toggle="modal"
                  data-target="#action_confirm_dbox"
                  @click=" validateInput()"
                >{{action}}</button>
              </div>

              <!-- close button -->
              <div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--confirmation dialogue box -->
      <div>
        <action_confirm_dbox
          :action_confirm="action"
          :acted_on="acted_on"
          :is_selected="is_selected"
          :errors="errors"
          @sendUsers="sendUsers"
          @sendGroupData="sendGroupData"
        ></action_confirm_dbox>
      </div>
    </div>
  </transition>
</template>

<script>
/**
 *  this table is used everytime a user wants to add/remove members of an existing group or to add an existing
    user to a new group
 */
export default {
  props: {
    action: {
      //action the user is executing
      type: String
    },
    acted_on: {
      //on what is the action being executed
      type: String
    },
    gname_box_show: {
      //boolean to show group name input box to dialogue
      type: Boolean,
      default: false
    },
    users: {
      //array of users to add or remove
      type: Array
    }
  },

  /**
   * @description declaration of global variables
   * @returns array of all variables
   */
  data() {
    return {
      group_name_input: "", //input for group name
      search: "", //search input
      close_dialog: "", //to close action table

      users_to_add_remove: [], //list of users to add or remove
      selected_users: [], //list of selected users to add or remove
      groups: [], //list of all the groups in the system, used to determine ID of new group
      errors: [], //list of errors

      user: {
        //user attributes to use on table
        first_name: "",
        last_name: "",
        email: ""
      },
      group_to_create: {
        //attributes to create a group
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      },

      valid_input: false, //validate input
      is_selected: false, //validate if user has made a selection to add or remove a user
      all_selected: false, //has the option to select all users been checked
      ready:false
    };
  },
  /**
   * @description sets variable of groups when component is loaded
   */
  created() {
    this.totalGroups();
  },

  /**
   * @descriptcion handles modal closing event
   */
  mounted() {
      if(this.ready){
    $(this.$refs.action_modal).on("hidden.bs.modal", this.resetInputFields);
      }
  },

  computed: {
    /**
     * @description filters users by email search. Method is called per each key press
     * @returns list of users in accordance to search.
     */
    filterUsers() {
      return this.users.filter(user => {
        return user.email.includes(this.search);
      });
    }
  },

  methods: {
    checkAll() {
      this.selected_users = [];
      if (!this.all_selected) {
        for (let i in this.users) {
          this.selected_users.push(this.users[i].uid);
        }
      }
    console.log(this.selected_users);
    },

    select() {
      this.all_selected = false;
    },

    /**
     * @description unchecks any selection of users that has been made
     */
    uncheck() {
      this.selected_users = [];

      for (let i in this.selected_users) {
        this.selected_users.push(this.selected_users[i].uid);
      }
    },
    /**
     * @description verifies if a selection has been made when performing action(add/remove)
     */
    isUserSelected() {
      if (this.selected_users.length == 0) {
        this.is_selected = false;
        this.close_dialog = ""; //keep component opened if user has not made a selection when performing an action
      } else {
        this.is_selected = true;
        this.close_dialog = "modal"; //close component if user has made a selection when perfoming action
        if (this.action == "Add") {
          this.sendUsers();
        }
      }
    },
    /**
     * @description resets all input fields
     */
    resetInputFields() {
      this.search = "";
      this.group_name_input = "";
      this.users_to_add_remove = [];
      this.select();
      this.uncheck();
    },

    /**
     * @description validates group name input field
     */
    validateInput() {
      this.group_name_input.trim();
      if (this.group_name_input) {
        this.sendGroupData();
        this.close_dialog = "modal"; //dismiss component if inputs are valid
        this.valid_input = true;
        this.errors = []; //reset
      } else {
        this.close_dialog = ""; //keep component opened if there are errors
        this.valid_input = false;

        this.errors = [];

        if (!this.group_name_input) {
          //add error
          this.errors.push("Group name required.");
        }
      }
    },

    /**
     * @description gets all of the system's groups
     */
    totalGroups() {
      fetch("/groups")
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
        })
        .catch(err => console.log(err));
    },

    /**
     * @description calls the addUsers method from parent window(user_groups or groups)
     *  and sends the user data to be processed
     */
    sendUsers() {
      //send selected users to parent component to add users
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.gid = this.path[this.path.length - 1]; //get group id from path

console.log(this.selected_users);
      for (let i in this.selected_users) {
        //populate array with selected users
        this.users_to_add_remove.push({
          uid: this.selected_users[i],
          gid: this.gid
        });
      }

      //emit data to parent
      if (this.is_selected) {
        if (this.action == "Add") {
          this.$emit("addUsers", this.users_to_add_remove);
        } else {
          //default action is to delete
          this.$emit("removeUsers", this.users_to_add_remove);
        }
       // this.select();
      //  this.uncheck(); // uncheck all values when finished
        this.resetInputFields();
        this.ready=true;
      }
    },

    /**
     * @description calls the createGroup method from parent window(user_groups)
     *  and sends the data for the new case study
     */
    sendGroupData() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.uid = this.path[this.path.length - 2]; //get user id from path
      this.date = new Date().toJSON().slice(0, 10);
      //append data to new group
      this.group_to_create.gid = this.groups[this.groups.length - 1].gid + 1;
      this.group_to_create.g_name = this.group_name_input;
      this.group_to_create.g_status = "active";
      this.group_to_create.g_creation_date = this.date;
      this.group_to_create.g_owner = this.uid;

      /*append owner to group*/
      this.users_to_add_remove.push({
        uid: this.uid,
        gid: this.group_to_create.gid
      });

      for (let i in this.selected_users) {
        //populate array with selected users
        this.users_to_add_remove.push({
          uid: this.selected_users[i],
          gid: this.group_to_create.gid
        });
      }

      if (this.is_selected || this.action == "Create") {
        this.$emit(
          //call method with data
          "createGroup",
          this.group_to_create,
          this.users_to_add_remove
        );
      }
      this.totalGroups(); //update total groups
      //reset fields
      this.group_to_create = {
        gid: "",
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      };
      this.select();
      this.uncheck();
      this.resetInputFields();
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
/*elements margins*/
.input-group {
  margin-bottom: 10px;
}
/*input box radius*/
.input-group-append input {
  border-radius: 3px;
}
/*input height*/
.form-control {
  height: 30px;
}

/***********************************************************/

/*checkbox and label attributes*/
input[type="checkbox"] + label {
  font-size: 18px;
  height: 18px;
  width: 18px;
  display: inline-block;
  padding: 0 0 0 0px;
}
/*checkbox sizing */
input[type="checkbox"] {
  transform: scale(1.2);
}

/*set color for dialogue box popup background*/
.modal {
  background: rgba(85, 85, 85, 0.5);

  /*width for group name input and search is defined in HTML elements*/
}

.required {
  color: red;
}
</style>
