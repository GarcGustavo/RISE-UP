<template>
  <!-- Team Members -->
  <div class="body mb-5 mt-5">
    <!-- group title -->
    <div v-if="!edit_title">
      <span class="text">
        <h1
          class="text-center p-1"
          :style=" rename_group_permission ? 'margin-left:185px;margin-top:25px' : ''"
        >
          {{group_name}}
          <!--render if user has permission-->
          <div id="edit_icon">
            <a
              href="#"
              style="padding-bottom:25px;float:right;"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Click icon to edit the group's name"
              @click.prevent="enableEditTitle"
              v-if="rename_group_permission"
            >
              <a id="edit_title_desc">Edit group name</a>
              <i class="material-icons">create</i>
            </a>
          </div>
        </h1>
      </span>
    </div>

    <!-- if edit mode is enabled -->
    <div v-if="edit_title">
      <span class="required">*</span>
      <input v-model="tempValue" maxlength="32" class="input">
      <button class="btn btn-secondary" @click="disableEditTitle">Cancel</button>
      <button class="btn btn-primary" @click="saveEdit(), action='Rename'">Save</button>
      <p aria-hidden="true" style="margin:5px;display:inline" id="required-description">
        <span class="required">*</span>Required field
      </p>
      <div v-if="errors.length">
        <div>
          <label>Please correct the following error(s):</label>
          <div class="alert alert-danger">
            <ul style="margin:10px;">
              <li v-for="(error,index) in errors" :key="index" style="margin:10px;">{{ error }}</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <!--buttons to create or remove a group -->
    <!-- render if user has permissions -->
    <h1 class="text-center mt-5 col-sm">
      <!--remove button -->
      <span data-toggle="modal" data-target="#action_table_dbox">
        <a
          v-if="add_remove_members_permission"
          href="#"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Click icon to remove a member from the group"
          @click.prevent=" action='Remove',
        acted_on='member(s)', show_dialogue=true, fetchMembers()"
        >
          <div id="remove_icon">
            <a>Remove user</a>
            <i class="material-icons">remove_circle_outline</i>
          </div>
        </a>
      </span>

      <!-- add button -->
      <span data-toggle="modal" data-target="#action_table_dbox">
        <a
          v-if="add_remove_members_permission"
          href="#"
          data-toggle="tooltip"
          data-placement="top"
          title="Click icon to add a user to the group"
          @click.prevent=" action='Add',
        acted_on='user(s)', show_dialogue=true, fetchUsers()"
        >
          <div id="add_icon">
            <a>Add user</a>
            <i class="material-icons">add_circle_outline</i>
          </div>
        </a>
      </span>
      <p :style=" add_remove_members_permission ? 'margin-left:288px;' : ''">Members</p>
    </h1>

    <!-- show table dialogue when adding or removing members -->
    <div v-if="(action=='Add'|| action=='Remove') && show_dialogue">
      <action-table-dbox
        :action="action"
        :acted_on="acted_on"
        :users_to_add="users_to_add"
        :users_to_remove="users_to_remove"
        :curr_user_id="curr_user"
        @addUsers="addUsers"
        @removeUsers="removeUsers"
      ></action-table-dbox>
    </div>

    <!-- show case study dialogue box when creating it from group -->
    <div v-if="action=='Create' && show_dialogue">
      <case-create-dbox
        :action="'Create'"
        :acted_on="'case study'"
        :errors="errors"
        :group_selection="curr_group"
        @close="resetErrors"
        @createCaseStudy="createCaseStudy"
      ></case-create-dbox>
    </div>

    <!-- Members -->
    <div class="card mb-5 shadow" id="members_scroll">
      <div class="row mt-1 pt-2 pl-4" id="members">
        <div class="col-lg-4 mb-4" v-for="member in group_members" :key="member.uid">
          <div class="card h-100 text-center">
            <i class="material-icons pt-2" style="font-size: 125px">person</i>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#" class="stretched-link">{{member.first_name}} {{member.last_name}}</a>
              </h4>
              <h6 class="card-subtitle text-muted"></h6>
            </div>
            <div class="card-footer">
              <label>{{member.email}}</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <!-- Create case button -->
    <h1 id="cases_header" class="mt-5 text-center">
      <span data-toggle="modal" data-target="#case_create_dbox">
        <a
          v-if="create_group_case_permission"
          @click.prevent="action='Create', show_dialogue=true"
          href="#case_create_dbox"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Click icon to create a group case study"
        >
          <div id="create_case_study_icon">
            <a>Create case study</a>
            <i class="material-icons">add_circle_outline</i>
          </div>
        </a>
      </span>
      <p :style="create_group_case_permission ? 'margin-left:197px;' : ''">Our Cases</p>
    </h1>

    <!-- list group's case studies -->
    <div class="mt-1 card mb-5 shadow" id="cases">
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
      temp: "", //user name input

      group_members: [], //members of group
      users_add_remove: [], //users to add or remove from group
      users_to_add: [],
      users_to_remove: [],
      group_cases: [], //cases that belong to group
      errors: [], //input errors

      is_owner: false, //is curr user group owner
      is_member: false, //is curr user member of group
      edit_title: false, // is the edit title button clicked
      add_remove_members_permission: false, //does curr user have permision to add/remove members
      rename_group_permission: false, //does curr user have permission to rename group
      create_group_case_permission: false, //does curr user have permission to create group case
      error: false, //are there errors. Currently not being used on html
      show_dialogue: false,

      tempValue: null
    };
  },

  /**
   * @description gets all group members to populate members section when the page is loaded
   * gets group info to determine who is owner when the page is loaded
   * gets all group cases to populate case section when the page is loaded
   */
  created() {
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
      this.errors = []; //reset errors
    },
    /**
     * @description save changes to group name
     */
    saveEdit() {
      this.temp = this.tempValue;
      this.changeGroupName(); //send request
    },

    /**
     * @description method called to reset error variable
     * Method is specially needed when the case-create-dbox closes as it calls this
     * function to reset all errors.
     */
    resetErrors() {
      this.errors = [];
    },

    /**
     * @description get all of system's users when adding a user to group.
     *
     */
    fetchUsers() {
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users_to_add = res.data; //to send to action_table_dbox when adding users
          //filter users from list to show in table
          for (let k = 0; k < this.group_members.length; k++) {
            //filter out group members from user list when adding new users to group
            this.users_to_add = this.users_to_add.filter(
              x => x.uid !== this.group_members[k].uid
            );
            this.users_to_add = this.users_to_add.filter(
              x => x.u_role == 3 || x.u_role == 4
            ); //filter non collaborators
          }
        })
        .catch(err => console.log(err));
    },

    /**
     * @description gets all of the current group's users
     */
    fetchMembers() {
      fetch("/user-groups/show?gid=" + this.curr_group)
        .then(res => res.json())
        .then(res => {
          this.users_to_remove = res.data; //populates action_table_dbox when removing a member from group
          if (this.is_owner) {
            this.users_to_remove = this.users_to_remove.filter(
              x => x.uid !== this.curr_user
            ); //filter owner out so he can't remove himself
          }
          this.group_members = res.data; //to render in view
          this.userPriveleges();
        })
        .catch(err => console.log(err));
    },

    /**
     * @description gets all of the case studies of the current group
     */
    fetchCases() {
      fetch("/case/group/show?gid=" + this.curr_group)
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
      //define variables
      this.urlParams = new URLSearchParams(window.location.search); //get url parameters
      this.curr_user = Number(this.urlParams.get("uid")); //get user id
      this.curr_group = this.urlParams.get("gid"); //get group id
      fetch("/group/info?gid=" + this.curr_group)
        .then(res => res.json())
        .then(res => {
          if (!res.errors) {
            this.group_data = res.data;
            this.group_name = this.group_data[0].g_name; //name of group
            this.group_owner = this.group_data[0].g_owner; // id of owner
            this.fetchMembers();
          }
        })
        .catch(err => console.log(err));
    },

    /**
     * @description outputs to the groupController a JSON request to rename group
     */
    changeGroupName() {
      fetch("/group/rename", {
        method: "put",
        //Add json content type application to indicate the media type of the resource.
        //Add access control action response that tells the browser to allow code
        //from any origin to access the resource
        //Add Cross-site request forgery protection token
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify({ gid: this.curr_group, g_name: this.temp })
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);

          if (!res.errors) {
            this.group_name = this.temp; //group name is the updated name
            this.disableEditTitle();
            //alert box
            this.dialogue = bootbox.alert({
              title: "Rename",
              message: "Group name has been changed!",
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

            this.resetErrors(); //reset error variable
          } else {
            this.errors = res.errors;
          }
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
      fetch("/user-groups/add", {
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
        body: JSON.stringify(users_to_add)
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
            //alert box
            this.dialogue = bootbox.alert({
              title: "Add",
              message: "User(s) has been added!",
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

            this.fetchMembers(); //update member list
            this.fetchUsers(); //update user list
            this.resetErrors(); //reset error variable
          }
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
      var curr = this;
      this.remove = users_to_remove;
      //confirmation dialogue box
      this.dialogue = bootbox.confirm({
        title: "Remove?",
        message: "Do you want to remove selected user(s)?",
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
            //send request
            fetch("/user-groups/remove", {
              method: "delete",
              //Add json content type application to indicate the media type of the resource.
              //Add access control action response that tells the browser to allow code
              //from any origin to access the resource
              //Add Cross-site request forgery protection token
              headers: new Headers({
                "Content-Type": "application/json",
                "Access-Control-Origin": "*",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
              }),
              body: JSON.stringify(curr.remove)
            })
              .then(res => res.json())
              .then(res => {
                console.log(res);

                //hide action table dbox
                curr.show_dialogue = false;
                //remove component's backdrop
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                curr.fetchMembers(); //update member list
                curr.fetchUsers(); //update user list
                //  curr.users_add_remove = []; //reset variable curr.users_add_remove = []; //reset variable
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
            //alert box
            this.dialogue = bootbox.alert({
              title: "Create",
              message: "Case study has been created!",
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

            this.appendDefaultParameters(case_study.cid); //default case study parameters
            this.fetchCases(); //update case study list
            this.resetErrors(); //reset error variable
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
            this.fetchCases(); //update case study list

            this.resetErrors(); //reset errors
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
/* Set max height for content containers */
#members_scroll {
  overflow-y: auto;
  overflow-x: hidden;
}
#members_scroll,
#members {
  padding-top: 10px;
  padding-right: 10px;
  min-height: 150px;
  max-height: 620px;
}
#cases {
  min-height: 200px;
  max-height: 614px;
  overflow-y: auto;
}
/*********************/

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
  color: #428bca;
  text-decoration: none;
}

/* icon initial color */
a {
  color: black;
}

/*move remove icon to right */
#remove_icon {
  display: inline-flex;
  float: right;
  padding-top: 5px;
}

/*label font size, and margin in relation to icon*/
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
/*move edit title icon to right*/
#edit_icon {
  display: inline-flex;
  float: right;
  padding-top: 5px;
}

/*remove label font size, and margin in relation to icon*/
#edit_icon #edit_title_desc {
  font-size: 18px;
  padding-top: 11px;
}
/*move create study icon to right*/
#create_case_study_icon {
  display: inline-flex;
  float: right;
}

/*remove label font size, and margin in relation to icon*/
#create_case_study_icon a {
  font-size: 18px;
  padding-top: 11px;
}

/*asterisk color*/
.required {
  color: red;
}
</style>
