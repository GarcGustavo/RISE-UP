
<template>
  <div class="body mb-5 mt-5">
    <!-- buttons to create or remove a group -->
    <h1 class="mb-3">
      <!-- button if clicked, render confirmation dialogue box to validate user's action -->
      <div>
        <a
          href="#"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Click icon to delete a group"
          @click.prevent="action='Remove',
          acted_on='group(s)', isGroupSelected()"
        >
          <div id="remove_icon">
            <a>Remove</a>
            <i class="material-icons">remove_circle_outline</i>
          </div>
        </a>
      </div>
      <!-- button if clicked, render create group input box -->
      <div>
        <span data-toggle="modal" data-target="#action_table_dbox">
          <a
            href="#"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Click icon to create a group"
            @click.prevent="gname_box_show=true, show_dialogue=true,
            action='Create',
            acted_on='group', fetchUsers()"
          >
            <div id="create_icon">
              <a>Create</a>
              <i class="material-icons">add_circle_outline</i>
            </div>
          </a>
        </span>
      </div>

      <p>My groups</p>
    </h1>

    <div v-if="action=='Create' && show_dialogue">
      <!-- if action is to create group(s) render action table dialogue box-->
      <action-table-dbox
        :action="action"
        :acted_on="acted_on"
        :gname_box_show="gname_box_show"
        :errors="errors"
        @close="resetErrors"
        :users_to_add="users"
        @createGroup="createGroup"
      ></action-table-dbox>
    </div>
    <hr>

    <!-- tables tabs -->
    <div id="tabs" class="container">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link active"
            id="tab1"
            data-toggle="tab"
            data-placement="bottom"
            title="Groups i created"
            href="#owned_groups"
            role="tab"
            @click.prevent="page_content=groups_user_is_owner, curr_tab=1, updatePaginator() "
          >Groups I created</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="tab2"
            data-toggle="tab"
            data-placement="bottom"
            title="Groups i belong to"
            href="#member_groups"
            role="tab"
            @click.prevent="page_content=groups_user_is_member, curr_tab=2, updatePaginator() "
          >Groups I belong to</a>
        </li>
      </ul>
    </div>

    <div class="container" id="entries_search">
      <!--entries for tab1 -->
      <div v-if="curr_tab==1">
        <div class="btn-group">
          <label id="entries_label">Entries:</label>
          <!--entries button -->
          <span data-toggle="dropdown">
            <button
              class="btn btn-primary btn-sm dropdown-toggle"
              type="button"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Select number of items to show per table page"
              aria-haspopup="true"
              aria-expanded="false"
            >{{entries_per_table_page_tab1}}</button>
          </span>
          <div class="dropdown-menu">
            <a class="dropdown-item" @click.prevent="selectEntries(4)" href="#">4</a>
            <a class="dropdown-item" @click.prevent="selectEntries(8)" href="#">8</a>
            <a class="dropdown-item" @click.prevent="selectEntries(16)" href="#">16</a>
            <a class="dropdown-item" @click.prevent="selectEntries(32)" href="#">32</a>
          </div>
        </div>
      </div>
      <!-- entries for tab2 -->
      <div v-if="curr_tab==2">
        <div class="btn-group">
          <label id="entries_label">Entries:</label>
          <!--entries button -->
          <span data-toggle="dropdown">
            <button
              class="btn btn-primary btn-sm dropdown-toggle"
              type="button"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Select number of items to show per table page"
              aria-haspopup="true"
              aria-expanded="false"
            >{{entries_per_table_page_tab2}}</button>
          </span>
          <div class="dropdown-menu">
            <a class="dropdown-item" @click.prevent="selectEntries(4)" href="#">4</a>
            <a class="dropdown-item" @click.prevent="selectEntries(8)" href="#">8</a>
            <a class="dropdown-item" @click.prevent="selectEntries(16)" href="#">16</a>
            <a class="dropdown-item" @click.prevent="selectEntries(32)" href="#">32</a>
          </div>
        </div>
      </div>

      <!-- search bar -->
      <div class="input-group">
        <label>Search</label>
        <div class="input-group-append search">
          <input
            type="text"
            class="form-control input-sm"
            maxlength="32"
            v-model="search"
            placeholder="Group name.."
          >
        </div>
      </div>
    </div>

    <!-- table of groups user created for tab1-->
    <div class="tab-content">
      <div class="tab-pane active" id="owned_groups" role="tabpanel">
        <b-table
          sticky-header="600px"
          head-variant="light"
          hover
          :items="filterGroups"
          :fields="fields"
        >
          <template v-slot:head(index)>
            <input type="checkbox" @click="checkAll()" v-model="all_selected">
            Select All
          </template>
          <template v-slot:cell(index)="data">
            <div class="p-2 pl-4">
              <input
                class="checkbox"
                type="checkbox"
                id="checkbox"
                @click="select()"
                v-model="selected_groups"
                :value="data.item.gid"
              >
              {{data.index +1}}
            </div>
          </template>
          <template v-slot:cell(g_name)="data">
            <div>
              <b-link
                class="p-2"
                :href="'/user/'+curr_user+'/group/' + data.item.gid"
              >{{data.item.g_name}}</b-link>
            </div>
          </template>
        </b-table>
      </div>

      <!-- table of groups user belongs to for tab2 -->
      <div class="tab-pane" id="member_groups" role="tabpanel">
        <b-table
          sticky-header="600px"
          head-variant="light"
          hover
          :items="filterGroups"
          :fields="fields"
        >
          <template v-slot:cell(index)="data">
            <div class="p-2">{{data.index +1}}</div>
          </template>
          <template v-slot:cell(g_name)="data">
            <div>
              <b-link
                class="p-2"
                :href="'/user/'+curr_user+'/group/' + data.item.gid"
              >{{data.item.g_name}}</b-link>
            </div>
          </template>
        </b-table>
      </div>
    </div>

    <!--number of entries per table page option -->
    <div id="container">
      <!-- paginator for tab1 -->
      <div id="paginate" v-if="reload_paginator && curr_tab==1">
        <paginator
          :items="page_content"
          :page_size="entries_per_table_page_tab1"
          @changePage="onChangePage"
          class="pagination"
          style="display:inline-block"
        ></paginator>
      </div>
      <!-- paginator for tab2 -->
      <div id="paginate" v-if="reload_paginator && curr_tab==2">
        <paginator
          :items="page_content"
          :page_size="entries_per_table_page_tab2"
          @changePage="onChangePage"
          class="pagination"
          style="display:inline-block"
        ></paginator>
      </div>
    </div>
  </div>
</template>

<script>
/**
 * this component is used to display the groups of a user
 */
import BootstrapVue, { BTable, BLink, BTooltip } from "bootstrap-vue";
import bootbox from "bootbox";
export default {
  /**
   * @description declaration of global variables
   * @returns array of all variables
   */
  components: {
    "b-table": BTable,
    "b-link": BLink,
    "b-tooltip": BTooltip
  },
  data() {
    return {
      curr_user: "", //current user id
      action: "", //action the user is executing
      acted_on: "", //on what is the action being exected
      search: "", //search table string
      path: "", //URL
      uid: "", // curr user id - NOT USED
      close: "",

      user_groups: [], // groups of the user
      groups_user_is_owner: [], //list of groups the user has created
      groups_user_is_member: [], //list of groups the user belongs to(member)
      selected_groups: [], // the groups the user selects
      groups_to_remove: [], // the groups to remove, sent to controller
      page_of_groups: [], //groups to show on table page
      page_content: [], //groups to send to paginator
      users: [],
      errors: [],

      group: {
        //group attributes
        gid: "",
        g_name: "",
        g_status: "",
        g_creation_date: "",
        g_owner: ""
      },

      fields: [
        //sortable column used in b-table and index column style definition
        { index: { thStyle: { width: "120px" } } },
        {
          key: "g_name",
          label: "Name",
          class: "text-center",
          sortable: true,
          thStyle: { paddingLeft: "23px" }
        }
      ],
      curr_tab: 1, //current opened tab DEFAULT
      entries_per_table_page_tab1: 4, //table entries
      entries_per_table_page_tab2: 4, //table entries

      reload_paginator: false, //used to update paginator
      is_selected: false, //has user made a selection,
      all_selected: false, //has the option to select all groups been checked
      gname_box_show: false, //boolean to append group name input to dialogue box when creating a group
      initial_load: true,
      show_dialogue: false
    };
  },

  /**
   * @description gets all users groups to populate group table when the page is loaded
   */
  created() {
    this.fetchGroups();
  },

  computed: {
    /**
     * @description filters groups by name search. Method is called per each key press
     * @returns list of users in accordance to search.
     */
    filterGroups() {
      if (this.page_content.length == 0) {
        return [];
      }
      return this.page_of_groups.filter(page_of_groups => {
        return page_of_groups.g_name.includes(this.search);
      });
    }
  },
  methods: {
    /**
     * @description  checks all checkboxes when user selects "select all" option
     */
    checkAll() {
      this.selected_groups = [];
      if (!this.all_selected) {
        //push all groups to array
        for (let i in this.groups_user_is_owner) {
          this.selected_groups.push(this.groups_user_is_owner[i].gid);
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
     * @description  lists the set of groups of the current table page
     * @param {Array} page_of_groups - contains a list of set of groups sent by the paginator
     */
    onChangePage(page_of_groups) {
      // update page of Groups
      this.page_of_groups = page_of_groups;
    },

    /**
     * @description refreshes the paginator
     */
    updatePaginator() {
      // Remove paginator from the DOM
      this.reload_paginator = false;

      this.$nextTick().then(() => {
        // Add the paginator back in
        this.reload_paginator = true;
      });
    },

    /**
     * @description sets the number of groups to show in a page
     * @param {Number} entry - variable containing the number of entries per page
     */
    selectEntries(entry) {
      if (this.curr_tab == 1) {
        this.entries_per_table_page_tab1 = entry;
      } else {
        this.entries_per_table_page_tab2 = entry;
      }
      this.updatePaginator();
    },

    /**
     * @description unchecks any selection of groups the user has made
     */
    uncheck() {
      this.selected_groups = [];

      for (let i in this.selected_groups) {
        this.selected_groups.push(this.selected_groups[i].gid);
      }
    },

    resetErrors() {
      this.errors = [];
    },

    /**
     * @description @description verifies if user has made a selection of a group
     */

    isGroupSelected() {
      if (this.selected_groups.length == 0) {
        this.is_selected = false;
        //alert box
        this.dialogue = bootbox.alert({
          title: "Remove",
          message: "Please select group(s) to remove",
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
        this.removeGroups();
      }
    },
    /**
     * @description get all of system's users when adding a user while creating a group
     */
    fetchUsers() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.curr_user = Number(this.path[this.path.length - 2]); //get ID from path
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data; //used in action_table_dbox
          //filter user from list to show in table
          this.users = this.users.filter(x => x.uid !== this.curr_user); //filter owner
        })
        .catch(err => console.log(err));
    },

    /**
     * @description gets all the groups of the current user
     */
    fetchGroups() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.curr_user = Number(this.path[this.path.length - 2]); //get ID from path
      fetch("/user_groups/" + this.curr_user)
        .then(res => res.json())
        .then(res => {
          this.user_groups = res.data;
          //filter groups where user is owner
          this.groups_user_is_owner = this.user_groups.filter(
            x => x.g_owner == this.curr_user
          );
          //filter groups where user is a member
          this.groups_user_is_member = this.user_groups.filter(
            x => x.g_owner !== this.curr_user
          );
          //initial content load
          if (this.initial_load) {
            this.page_content = this.groups_user_is_owner;
            this.initial_load = false;
          }

          //window content varies according to tab
          if (this.curr_tab == 1) {
            this.page_content = this.groups_user_is_owner;
          } else {
            this.page_content = this.groups_user_is_member;
          }
          this.select();
          this.uncheck(); //uncheck any selected items
          this.updatePaginator(); //refresh with updated group list
        })
        .catch(err => console.log(err));
    },

    /**
     * @description outputs to the groupController a JSON request to create a group
     * @param {Array} group - array of group data to create a group - data is sent by action_table_dbox when calling method
     * @param {Array} members - array of user id's to add to group
     */
    createGroup(group, members) {
      fetch("/group/create", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(group) //append group to body of request
      })
        .then(res => res.json())
        .then(res => {
            console.log(res);
          if (!res.errors) {
            this.addUsers(members); //add users to group
            this.fetchGroups(); //updpate group list
            //hide action table dbox
            this.show_dialogue = false;
            //remove component's backdrop
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
            //alert box
            this.dialogue = bootbox.alert({
              title: "Create",
              message: "Group has been created!",
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

            this.errors = []; //reset
          } else {
            this.errors = res.errors;
          }
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description outputs to the User_Groups controller a JSON request to add users to existing group
     * @param {Array} users_to_add - array of user id's to add to group - data is sent by the action_table_dbox dialogue
     */
    addUsers(users_to_add) {
      fetch("/group/members/add", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(this.lol)
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
          // this.fetchGroups();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description removes any selected groups by making a delete request to User_Groups controller
     */
    removeGroups() {
      var curr = this;

      //confirmation dialogue box
      this.dialogue = bootbox.confirm({
        title: "Remove?",
        message: "Do you want to remove selected groups?",
        backdrop: true,

        buttons: {
          confirm: {
            label: "No", //inverted roles, switched bootbox default order
            className: "btn btn-secondary"
          },
          cancel: {
            label: "Yes",
            className: "btn btn-primary"
          }
        }, //Callback function with user's input
        callback: function(result) {
          if (!result) {
            //if yes
            for (let i in curr.selected_groups) {
              curr.groups_to_remove.push({
                //push selected group id's as gid attributes
                gid: curr.selected_groups[i]
              });
            }
            //send request
            fetch("/user_groups/remove", {
              method: "delete",
              headers: new Headers({
                "Content-Type": "application/json",
                "Access-Control-Origin": "*",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
              }),
              body: JSON.stringify(curr.groups_to_remove)
            })
              .then(res => res.json())
              .then(res => {
                  console.log(res);
                if (!res.errors) {
                  curr.fetchGroups(); //update group list
                  curr.groups_to_remove = []; //reset variable
                }
              })
              .catch(err => {
                console.error("Error: ", err);
              });
          } //end if
        } //end callback
      }); //end alert

      //alert box CSS styling
      this.dialogue.find(".modal-content").css({
        height: "250px",
        "font-size": "18px",
        "text-align": "center"
      });
      this.dialogue.find(".modal-body").css({ "padding-top": "40px" });
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

tr td a {
  display: block;
  font-size: 18px;
}

th {
  cursor: pointer;
}
/* This is for row content style and alignment */
/*When overflow occurs limit display -
text overflow currently not used due to character limit*/
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

/* change checkbox size */
input[type="checkbox"] {
  transform: scale(1.3);
}
/* paginate component position in body */
.pagination {
  float: right;
}
/*paginate component sizing*/
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
  color: #428bca;
}
/* icon initial color */
a {
  color: black;
}
/*move remove icon to right */
#remove_icon {
  float: right;
}

/*remove label font size, and margin in relation to icon*/
#remove_icon a {
  font-size: 18px;
  margin-left: 15px;
}

/*move create icon to right */
#create_icon {
  float: right;
}

/*remove label font size, and margin in relation to icon*/
#create_icon a {
  font-size: 18px;
}
/*entries container padding in relation to table */
#container .btn-group {
  padding-top: 12px;
  width: 100px;
}

/*tabs header text color*/
#tabs a {
  color: #428bca;
  font-weight: 500;
}

/*search label style*/
.input-group label {
  font-size: 18px;
  padding: 0 0 0 0px;
  margin: 5px;
  margin-right: 10px;
}
/*page headers and tables margin*/
#tabs {
  margin-top: -25px;
}
/*entries and search bar container positioning*/
#entries_search {
  display: flex;
  justify-content: space-between;
  margin-top: -45px;
}

/*entries and search bar elements position rules*/
#entries_search .btn-group {
  display: inline;
  padding-top: 33px;
}
/*entries positioning*/
#entries_search .btn-group button {
  background-color: #428bca;
  margin-left: 60px;
  margin-top: -60px;
}
/*search bar positioning*/
#entries_search .input-group {
  margin-bottom: 15px;
  margin-top: 25px;
  margin-left: 650px;
}
</style>
