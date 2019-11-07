<template>
  <!-- Team Members -->
  <div class="body mb-5 mt-5">
    <!-- <h1 class="text-center">Our Group</h1>-->

    <div v-if="!edit_title">
      <span class="text">
        <h1 class="text-center" :style=" is_owner ? 'margin-left:35px;' : ''">
          {{group_name}}
          <a href="#" @click="enableEditTitle" v-if="is_owner">
            <i class="material-icons">create</i>
          </a>
        </h1>
      </span>
    </div>
    <div v-if="edit_title">
      <input v-model="tempValue" maxlength="32" class="input">
      <button @click="disableEditTitle">Cancel</button>
      <button
        data-toggle="modal"
        data-target="#mg_action_confirm"
        @click="saveEdit(), action='Rename'"
      >Save</button>
    </div>

    <!--
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item active">About</li>
    </ol>
    -->

    <hr>
    <h1 class="text-center mt-5 col-sm">
      <a
        v-if="edit_members"
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        data-dismiss="modal"
        @click="showModal=true, action='Remove',
        actor='member(s)', fetchMembers()"
      >
        <div class="add_icon" style="display:inline-flex;float:right;padding-top:5px;">
          <a style="font-size:18px;margin-left:15px;padding-top:11px;">Remove</a>
          <i class="material-icons">remove_circle_outline</i>
        </div>
      </a>
      <a
        v-if="edit_members"
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        data-dismiss="modal"
        @click="showModal=true, action='Add',
        actor='member(s)', fetchUsers()"
      >
        <div class="remove_icon" style="display:inline-flex;float:right;padding-top:5px;">
          <a style="font-size:18px;padding-top:11px;">Add</a>
          <i class="material-icons">add_circle_outline</i>
        </div>
      </a>

      <mg_action_table
        v-if="showModal"
        @close="showModal = false"
        :action="action"
        :actor="actor"
        :users="users"
        @addUsers="addUsers"
        @removeUsers="removeUsers"
      ></mg_action_table>

     <div v-if="error">
        <mg_action_confirm :errors="errors"></mg_action_confirm>
      </div>




      <p :style=" edit_members ? 'margin-left:205px;' : ''">Members</p>
    </h1>

    <div>
      <case_create_dbox
        :action="'Create'"
        :actor="'case study'"
        :group_selection="gid"
        @createCaseStudy="createCaseStudy"
      ></case_create_dbox>
    </div>
<div>
    <mg_action_confirm :action_confirm="action" :errors="errors"></mg_action_confirm>
</div>
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
            <label>{{member.email}}</label>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <!-- Case view -->
    <h1 id="cases_header" class="mt-5 text-center">
      <div v-if="create_group_case">
        <a
          href="#case_create_dbox"
          style="padding-top:5px;"
          data-toggle="modal"
          data-target="#case_create_dbox"
        >Create case study</a>
      </div>
      <p :style="create_group_case ? 'margin-left:180px;' : ''">Our Cases</p>
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
      old_name: "",
      group_name: "",
      group_data: "",
      group_owner: "",
      group_user: "",
      action: "",
      actor: "",
      gid: "",
      members: [],
      users: [],
      cases: [],
      members_to_add: [],
      errors: [],
      tempValue: null,
      is_owner: false,
      is_member: false,
      edit_members: false,
      edit_title: false,
      create_group_case: false,
      error: false
    };
  },

  created() {
    this.fetchMembers();
    this.fetchGroupInfo();
    this.fetchCases();
  },

  methods: {
    userPriveleges() {
      this.isUserOwner();
      this.isUserMember();
      if (this.is_owner) {
        this.edit_members = true;
        this.create_group_case = true;
      } else if (this.is_member && !this.is_owner) {
        this.edit_members = false;
        this.create_group_case = true;
      } else {
        this.edit_members = false;
        this.create_group_case = false;
      }
    },

    isUserOwner() {
      if (this.group_user == this.group_owner) {
        this.is_owner = true;
      } else {
        this.is_owner = false;
      }
    },

    isUserMember() {
      for (let i = 0; i < this.members.length; i++) {
        if (this.group_user == this.members[i].uid) {
          this.is_member = true;
          return;
        }
      }
      this.is_member = false;
    },

    enableEditTitle() {
      this.tempValue = this.group_name;
      this.edit_title = true;
    },
    disableEditTitle() {
      this.tempValue = null;
      this.edit_title = false;
      this.error = false;
    },
    saveEdit() {
      this.old_name = this.group_name;
      this.group_name = this.tempValue.trim();

      if (this.group_name) {
        this.changeGroupName();
        this.disableEditTitle();
      } else {
        this.errors = [];

        if (!this.group_name) {
          this.errors.push("Group name required.");
        }
        this.group_name = this.old_name;
        this.error = true;
      }
    },

    fetchUsers() {
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data; //to send to modal
          //filter users from list to show in table
          for (let i = 0; i < this.users.length; i++) {
            for (let k = 0; k < this.members.length; k++) {
              if (this.users[i].uid == this.members[k].uid) {
                this.users.splice(i, 1);
              }
            }
          }
        })
        .catch(err => console.log(err));
    },

    fetchMembers() {
      this.path = window.location.pathname.split("/");
      this.group_user = Number(this.path[this.path.length - 3]);
      this.gid = Number(this.path[this.path.length - 1]);

      fetch("/group/" + this.gid + "/members")
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
          this.members = res.data; //to render in view
        })
        .catch(err => console.log(err));
    },

    fetchCases() {
      fetch("/group/" + this.gid + "/cases")
        .then(res => res.json())
        .then(res => {
          this.cases = res.data;
        })
        .catch(err => console.log(err));
    },

    fetchGroupInfo() {
      this.path = window.location.pathname.split("/");
      this.gid = Number(this.path[this.path.length - 1]);
      fetch("/group/" + this.gid + "/info")
        .then(res => res.json())
        .then(res => {
          this.group_data = res.data;
          this.group_name = this.group_data[0].g_name;
          this.group_owner = this.group_data[0].g_owner;
          //Verify if use is owner
          this.userPriveleges();
        })
        .catch(err => console.log(err));
    },

    changeGroupName() {
      this.path = window.location.pathname.split("/");
      this.gid = Number(this.path[this.path.length - 1]);
      fetch("/group/" + this.gid + "/update", {
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
          this.fetchUsers();
          this.fetchMembers();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

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
          this.fetchUsers();
          this.fetchMembers();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

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
          this.fetchCases();
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
</style>
