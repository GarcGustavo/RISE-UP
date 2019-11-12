<template>
  <!-- Team Members -->
  <div class="body mb-5 mt-5">
    <!-- group title -->
    <div v-if="!edit_title">
      <span class="text">
        <h1 class="text-center" :style=" rename_group_permission ? 'margin-left:45px;' : ''">
          {{group_name}}
          <!--render if user has permission-->
          <a href="#" @click="enableEditTitle" v-if="rename_group_permission">
            <i class="material-icons">create</i>
          </a>
        </h1>
      </span>
    </div>
    <!-- if edit mode is enabled -->
    <div v-if="edit_title">
      <input v-model="tempValue" maxlength="32" class="input">
      <button @click="disableEditTitle">Cancel</button>
      <button
        data-toggle="modal"
        data-target="#action_confirm_dbox"
        @click="saveEdit(), action='Rename'"
      >Save</button>
    </div>

    <hr>

    <!--buttons to create or remove a group -->
    <!-- render if user has permissions -->
    <h1 class="text-center mt-5 col-sm">
      <!--remove button -->
      <a
        v-if="add_remove_members_permission"
        href="#action_table_dbox"
        data-toggle="modal"
        data-target="#action_table_dbox"
        data-dismiss="modal"
        @click=" action='Remove',
        acted_on='member(s)', fetchMembers()"
      >
        <div id="remove_icon">
          <a>Remove</a>
          <i class="material-icons">remove_circle_outline</i>
        </div>
      </a>
      <!-- add button -->
      <a
        v-if="add_remove_members_permission"
        href="#action_table_dbox"
        data-toggle="modal"
        data-target="#action_table_dbox"
        data-dismiss="modal"
        @click=" action='Add',
        acted_on='member(s)', fetchUsers()"
      >
        <div id="add_icon">
          <a>Add</a>
          <i class="material-icons">add_circle_outline</i>
        </div>
      </a>

      <p :style=" add_remove_members_permission ? 'margin-left:205px;' : ''">Members</p>
    </h1>
    <!-- show table dialogue when adding or removing members -->
    <div v-if="action=='Add'|| action=='Remove'">
      <action_table_dbox
        :action="action"
        :acted_on="acted_on"
        :users="users_add_remove"
        :curr_user_id="curr_user"
        @addUsers="addUsers"
        @removeUsers="removeUsers"
      ></action_table_dbox>
    </div>
    <!-- show confirmation box when renaming group -->
    <div v-if="action=='Rename'">
      <action_confirm_dbox :action_confirm="action" :errors="errors"></action_confirm_dbox>
    </div>
    <!-- show case study dialogue box when creating it from group -->
    <div v-if="action=='Create'">
      <case_create_dbox
        :action="'Create'"
        :acted_on="'case study'"
        :group_selection="curr_group"
        @createCaseStudy="createCaseStudy"
      ></case_create_dbox>
    </div>
    <!-- Members -->
    <div class="row mt-1 mb-5" id="members">
      <div class="col-lg-4 mb-4" v-for="member in group_members" :key="member.uid">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">{{member.first_name}} {{member.last_name}}</h4>
            <h6 class="card-subtitle text-muted"></h6>
          </div>
          <div class="card-footer">
            <label>{{member.email}}</label>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <!-- Create case button -->
    <h1 id="cases_header" class="mt-5 text-center">
      <a
        v-if="create_group_case_permission"
        @click="action='Create'"
        href="#case_create_dbox"
        style="padding-top:5px;"
        data-toggle="modal"
        data-target="#case_create_dbox"
      >Create case study</a>

      <p :style="create_group_case_permission ? 'margin-left:165px;' : ''">Our Cases</p>
    </h1>
    <!-- list group's case studies -->
    <div class="mt-1 card mb-5" id="cases">
      <div class="col-sm-12 mb-3">
        <ul class="list-group list-group-flush border-0">
          <li class="list-group-item" v-for="(case_study,index) in group_cases" :key="index">
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
/**
 * this component displays a group page
 */
export default {
  /**
   * @description declaration of global variables
   * @returns array of all variables
   */
  data() {
    return {
      group_name: "", //group name input
      group_data: "", //curr group data
      group_owner: "", //curr group owner
      curr_user: "", //current user id
      action: "", //action the user is executing
      acted_on: "", //on what is the action being exected
      curr_group: "", //current user id

      group_members: [], //members of group
      users_add_remove: [], //users to add or remove from group
      group_cases: [], //cases that belong to group
      errors: [], //input errors

      is_owner: false, //is curr user group owner
      is_member: false, //is curr user member of group
      edit_title: false, // is the edit title button clicked
      add_remove_members_permission: false, //does curr user have permision to add/remove members
      rename_group_permission: false, //does curr user have permission to rename group
      create_group_case_permission: false, //does curr user have permission to create group case
      error: false, //are there errors. Currently not being used on html

      tempValue: null
    };
  },

  /**
   * @description gets all group members to populate members section when the page is loaded
   * gets group info to determine who is owner when the page is loaded
   * gets all group cases to populate case section when the page is loaded
   */
  created() {
    this.fetchMembers();
    this.fetchGroupInfo();
    this.fetchCases();
  },

  methods: {
    /**
     * @description determine user priveleges in group
     */
    userPriveleges() {
      this.isUserOwner(); //verify if user is owner
      this.isUserMember(); //verify is user is member

      if (this.is_owner) {
        this.rename_group_permission = true;
        this.add_remove_members_permission = true;
        this.create_group_case_permission = true;
      } else if (this.is_member && !this.is_owner) {
        this.rename_group_permission = false;
        this.add_remove_members_permission = false;
        this.create_group_case_permission = true;
      } else {
        this.rename_group_permission = false;
        this.add_remove_members_permission = false;
        this.create_group_case_permission = false;
      }
    },

    /**
     * @description determine if current user is owner of group
     */
    isUserOwner() {
      if (this.curr_user == this.group_owner) {
        this.is_owner = true;
      } else {
        this.is_owner = false;
      }
    },

    /**
     * @description determine if current user is member of group
     */
    isUserMember() {
      for (let i = 0; i < this.group_members.length; i++) {
        if (this.curr_user == this.group_members[i].uid) {
          this.is_member = true;
          return;
        }
      }
      this.is_member = false;
    },

    /**
     * @description enable edit mode to rename group
     */
    enableEditTitle() {
      this.tempValue = this.group_name;
      this.edit_title = true;
    },
    /**
     * @description once saved or canceled disabled edit mode
     */
    disableEditTitle() {
      this.tempValue = null;
      this.edit_title = false;
      this.error = false;
      this.errors = []; //reset errors
    },
    /**
     * @description save changes to group name
     */
    saveEdit() {
      this.temp_name = this.tempValue.trim();

      if (this.temp_name) {
        //if not empty
        this.group_name = this.temp_name;
        this.changeGroupName(); //send request
        this.disableEditTitle(); //disable edit mode
      } else {
        this.errors = [];

        if (!this.temp_name) {
          this.errors.push("Group name required.");
        }

        this.error = true;
      }
    },

    /**
     * @description get all of system's users when adding a user to group.
     *
     */
    fetchUsers() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.curr_user = Number(this.path[this.path.length - 3]); //get ID from path and perform Numeric conversion for filter
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users_add_remove = res.data; //to send to action_table_dbox when adding users
          //filter users from list to show in table
          for (let k = 0; k < this.group_members.length; k++) {
            //filter out group members from user list when adding new users to group
            this.users_add_remove = this.users_add_remove.filter(
              x => x.uid !== this.group_members[k].uid
            );
          }
        })
        .catch(err => console.log(err));
    },

    /**
     * @description gets all of the current group's users
     */
    fetchMembers() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.curr_user = Number(this.path[this.path.length - 3]); //get ID from path and perform Numeric conversion for filter
      this.curr_group = this.path[this.path.length - 1]; //get ID of group from path

      fetch("/group/" + this.curr_group + "/members")
        .then(res => res.json())
        .then(res => {
          this.users_add_remove = res.data; //populates action_table_dbox when removing a member from group
          if (this.is_owner) {
            this.users_add_remove = this.users_add_remove.filter(
              x => x.uid !== this.curr_user
            ); //filter owner out so he can't remove himself
          }
          this.group_members = res.data; //to render in view
        })
        .catch(err => console.log(err));
    },

    /**
     * @description gets all of the cases of the current group
     */
    fetchCases() {
      fetch("/group/" + this.curr_group + "/cases")
        .then(res => res.json())
        .then(res => {
          this.group_cases = res.data;
        })
        .catch(err => console.log(err));
    },

    /**
     * @description gets info of the current group
     */
    fetchGroupInfo() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.curr_group = this.path[this.path.length - 1]; //get ID of group from path
      fetch("/group/" + this.curr_group + "/info")
        .then(res => res.json())
        .then(res => {
          this.group_data = res.data;
          this.group_name = this.group_data[0].g_name; //name of group
          this.group_owner = this.group_data[0].g_owner; // id of owner

          this.userPriveleges(); //set user priveleges
        })
        .catch(err => console.log(err));
    },

    /**
     * @description outputs to the groupController a JSON request to rename group
     */
    changeGroupName() {
      this.path = window.location.pathname.split("/");
      this.curr_group = this.path[this.path.length - 1];
      fetch("/group/" + this.curr_group + "/update", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify({ g_name: this.group_name })
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description outputs to the User_groups Controller a JSON request to add members to a group
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
        body: JSON.stringify(users_to_add)
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
          console.log(users_to_add);
          this.fetchUsers(); //update user list
          this.fetchMembers(); //update member list
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description outputs to the User_groups Controller a JSON request to remove members from group
     * @param {Array} users_to_remove - array of user id's to remove group - data is sent by the action_table_dbox dialogue
     */
    removeUsers(users_to_remove) {
      fetch("/group/members/remove", {
        method: "delete",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(users_to_remove)
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
          console.log(users_to_remove);
          this.fetchUsers(); //update user list
          this.fetchMembers(); //update member list
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description outputs to the caseController a JSON request to create case study
     * @param {Array} case_study - array of case study data to create a case study - data is sent by the case_create_dbox dialogue
     */
    createCaseStudy(case_study) {
      fetch("/case/create", {
        method: "post",
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
          console.log(case_study);
          this.fetchCases(); //update case list
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    }
  }
};
</script>


<style lang="scss" scoped>
/* Set max height for content containers */

#members {
  max-height: 580px;
  overflow-y: auto;
}
#cases{
max-height: 620px;
  overflow-y: auto;
}

/* remove case cards borders */
li {
  border: none;
}
/*margin for headers*/
h1 p {
  margin-top: 75px;
}
/* add/remove icons position in relation to header */
h1 i {
  float: right;
  margin: 10px;
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

/* position create case study button */
#cases_header a,
#edit_btn a {
  float: right;
  font-size: 18px;
  margin-top: 10px;
}

/*move remove icon to right */
#remove_icon {
  display: inline-flex;
  float: right;
  padding-top: 5px;
}

/*remove label font size, and margin in relation to icon*/
#remove_icon a {
  font-size: 18px;
  margin-left: 15px;
  padding-top: 11px;
}

/*move add icon to right */
#add_icon {
  display: inline-flex;
  float: right;
  padding-top: 5px;
}

/*remove label font size, and margin in relation to icon*/
#add_icon a {
  font-size: 18px;
  padding-top: 11px;
}
</style>
