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
              <!--Body description -->
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
              <!-- errors -->
              <div v-if="errors.length">
                <div>
                  <label>Please correct the following error(s):</label>
                  <div class="alert alert-danger">
                    <ul style="margin:10px;">
                      <li
                        v-for="(error,index) in errors"
                        :key="index"
                        style="margin:10px;"
                      >{{ error }}</li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- group name input -->
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
                <b-table head-variant="light" :fields="fields" :items="filterUsers">
                  <!-- A virtual column -->
                  <template v-slot:head(index)>
                    <input type="checkbox" @click="checkAll()" v-model="all_selected">
                    Select All
                  </template>
                  <template v-slot:cell(index)="data">
                    <input
                      class="checkbox"
                      type="checkbox"
                      id="checkbox"
                      @click="select()"
                      v-model="selected_users"
                      :value="data.item.uid"
                    >
                    {{data.index +1}}
                  </template>

                  <!-- A custom formatted column -->
                  <template v-slot:cell(email)="data">{{ data.item.email }}</template>

                  <!-- A virtual composite column -->
                  <template
                    v-slot:cell(first_name)="data"
                  >{{ data.item.first_name }} {{ data.item.last_name }}</template>
                </b-table>
              </div>
            </div>
            <div class="modal-footer">
              <!-- footer  -->
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
              <!-- remove user -->
              <div v-if="action=='Remove'">
                <button type="button" class="btn btn-primary" @click="isUserSelected()">{{action}}</button>
              </div>

              <!--add user to group -->
              <div v-else-if="action=='Add'">
                <button type="button" class="btn btn-primary" @click="isUserSelected()">{{action}}</button>
              </div>

              <!-- create group -->
              <div v-else-if="action=='Create'">
                <button
                  type="button"
                  class="btn btn-primary"
                  @click=" sendGroupData(),is_selected=true"
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
    </div>
  </transition>
</template>

<script>
import BootstrapVue, { BTable, BLink } from "bootstrap-vue";
import bootbox from "bootbox";
/**
 *  this table is used everytime a user wants to add/remove members of an existing group or to add an existing
    user to a new group
 */
export default {
  props: {
    action: {
      //action the user is executing
      type: String,
      default: ""
    },
    acted_on: {
      //on what is the action being executed
      type: String,
      default: ""
    },
    gname_box_show: {
      //boolean to show group name input box to dialogue
      type: Boolean,
      default: false
    },
    users_to_add: {
      //array of users to add or remove
      type: Array,
      default: function() {
        return [];
      }
    },
    users_to_remove: {
      //array of users to add or remove
      type: Array,
      default: function() {
        return [];
      }
    },
    errors: {
      type: Array,
      default: function() {
        return [];
      }
    }
  },

  /**
   * @description declaration of global variables
   * @returns array of all variables
   */
  components: {
    "b-table": BTable,
    "b-link": BLink
  },
  data() {
    return {
      group_name_input: "", //input for group name
      search: "", //search input
      close_dialog: "", //to close action table
      uid: "",
      gid: "",

      users_to_add_remove: [], //list of users to add or remove
      selected_users: [], //list of selected users to add or remove
      groups: [], //list of all the groups in the system, used to determine ID of new group

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

      fields: [
        //sortable columns used in b-table and index column style definition - uses btable built in sort
        { index: { thStyle: { width: "120px" } } },
        {
          key: "email",
          label: "Email",

          sortable: true
        },
        {
          key: "first_name",
          label: "Name",

          sortable: true
        }
      ],

      valid_input: false, //validate input
      is_selected: false, //validate if user has made a selection to add or remove a user
      all_selected: false //has the option to select all users been checked
    };
  },
  /**
   * @description sets variable of groups when component is loaded
   */
  created() {
    this.totalGroups();
  },

  /**
   * @description handles modal closing event
   */
  mounted() {
    /**
     * @description handles modal closing event
     */
    $(this.$refs.action_modal).on("hidden.bs.modal", this.resetInputFields);
  },

  computed: {
    /**
     * @description filters users by email search. Method is called per each key press
     * @returns list of users in accordance to search.
     */
    filterUsers() {
      if (this.action == "Add" || this.action == "Create") {
        return this.users_to_add.filter(user => {
          return user.email.toLowerCase().includes(this.search.toLowerCase());
        });
      } else {
        return this.users_to_remove.filter(user => {
          return user.email.toLowerCase().includes(this.search.toLowerCase());
        });
      }
    }
  },

  methods: {
    /**
     * @description  checks all checkboxes when user selects "select all" option
     */
    checkAll() {
      this.selected_users = [];

      if (!this.all_selected) {
        if (this.action == "Add" || this.action == "Create") {
          for (let i in this.users_to_add) {
            this.selected_users.push(this.users_to_add[i].uid);
          }
        } else { //remove action
          for (let i in this.users_to_remove) {
            this.selected_users.push(this.users_to_remove[i].uid);
          }
        }
      }
    },
    /**
     * @description if checkbox is checked again uncheck all selections
     */
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
     * @description resets all input fields
     */
    resetInputFields() {
      this.search = "";
      this.group_name_input = "";
      this.users_to_add_remove = [];
      this.$emit("close"); //reset error prop
      this.select();
      this.uncheck();
    },

    /**
     * @description gets all of the system's groups
     */
    totalGroups() {
        //define id variables
      this.urlParams = new URLSearchParams(window.location.search); //get url parameters
      this.uid = this.urlParams.get("uid"); //get user id
      this.gid = this.urlParams.get("gid"); //get group id

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
      for (let i in this.selected_users) {
        //populate array with selected users
        this.users_to_add_remove.push({
          uid: this.selected_users[i],
          gid: this.gid
        });
      }

      //emit data to parent
      if (this.action == "Add") {
        this.$emit("addUsers", this.users_to_add_remove);
      } else {
        //default action is to delete
        this.$emit("removeUsers", this.users_to_add_remove);
      }
    },

    /**
     * @description verifies if a selection has been made when performing action(add/remove)
     */
    isUserSelected() {
      if (this.selected_users.length == 0) {
        this.is_selected = false;
        //alert box
        this.dialogue = bootbox.alert({
          title: "Remove",
          message: "Please select user(s) to remove",
          backdrop: true,
          className: "text-center"
        });
        //alert box CSS styling
        this.dialogue.find(".modal-content").css({
          height: "250px",
          "font-size": "18px",
          "text-align": "center"
        });
        this.dialogue.find(".modal-body").css({ "padding-top": "40px" });

        //if selection made remove selected groups
      } else {
        this.is_selected = true;
        this.sendUsers();
      }
    },

    /**
     * @description calls the createGroup method from parent window(user_groups)
     *  and sends the data for the new case study
     */
    sendGroupData() {
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
      //reset attributes
      this.group_to_create = {
        gid: "",
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      };
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
