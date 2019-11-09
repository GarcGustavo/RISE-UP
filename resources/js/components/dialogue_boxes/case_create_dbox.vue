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
        id="case_create_dbox"
        tabindex="-1"
        data-keyboard="false"
        data-backdrop="static"
        role="dialog"
      >
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{action}} {{acted_on}}</h5>
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>-->
            </div>
            <!-- Render group name input element to dialogue box when user creates group -->
            <div class="modal-body">
              <label>Title</label>
              <div class="input-group-append">
                <input
                  class="form-control input-sm"
                  style="width:350px;"
                  type="text"
                  maxlength="50"
                  v-model="title"
                  placeholder="Name..."
                >
              </div>

              <!-- group selection for table -->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Assign to a group(optional)</label>
                <select
                  class="form-control"
                  id="exampleFormControlSelect2"
                  style="height:40px"
                  v-model="curr_group"
                >
                  <option
                    v-for="group in user_groups"
                    v-bind:key="group.gid"
                    :value="group.gid"
                  >{{group.g_name}}</option>
                </select>
              </div>
              <!-- case description -->
              <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  class="form-control"
                  id="description"
                  maxlength="140"
                  v-model="description"
                  v-on:keyup="countdown"
                ></textarea>
              </div>
              <p class="text-right h6" v-bind:class="{'text-danger': hasError }">{{remainingCount}}</p>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                :data-dismiss="close_dialog"
                data-target="#action_confirm_dbox"
                @click="validateInput()"
              >{{action}}</button>
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                @click="resetInputFields()"
              >Close</button>
            </div>
          </div>
        </div>
      </div>
      <!--confirmation dialogue box -->
      <div>
        <action_confirm_dbox :action_confirm="action" :acted_on="acted_on" :errors="errors"></action_confirm_dbox>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    action: { //action the user is executing
      type: String
    },
    acted_on: { //on what is the action being executed
      type: String
    },
    group_selection: { //curr group user is viewing, append as default option for groups
      type: String
    }
  },

  data() {
    return {
      close_dialog: "",  //to close action table
      title: "", //input for title of case study
      curr_user: "", //current user id
      curr_group: "",//curr group id
      description: "",//inpuy for description of case study

      all_cases: [], //all cases of the system. Used to determine ID of new case study
      user_groups: [], //groups of curr user
      errors: [], //list of all input errors

      case_study: { //case study attributes
        cid: "",
        c_title: "",
        c_description: "",
        c_thumbnail: "",
        c_status: "",
        c_date: "",
        c_owner: "",
        c_group: ""
      },

      maxCount: 140, //maximum amount of characters allowed in the description
      remainingCount: 140, //used to determine remaining account of character

      close: false, //NOT USED
      hasError: false, //does description's character count exceed limit - NOT USED IN HTML
      valid_input: false //is input valid
    };
  },
  created() {
    this.fetchGroups();
    this.totalCases();
  },

  methods: {
    countdown() {
      this.remainingCount = this.maxCount - this.description.length;
      this.hasError = this.remainingCount < 0;
    },
    resetInputFields() {
      this.title = "";
      this.description = "";
      if (!this.group_selection) {
        this.curr_group = "";
      }
      this.remainingCount = 140;
    },

    validateInput() {
      if (this.title.trim() && this.description.trim()) {
        this.sendCaseStudyData();
        this.valid_input = true;
        this.close_dialog = "modal";
        this.errors = [];
      } else {
        this.close_dialog = "";
        this.valid_input = false;

        this.errors = [];

        if (!this.title.trim()) {
          this.errors.push("title required.");
        }
        if (!this.description.trim()) {
          this.errors.push("description required.");
        }
      }
      
    },

    totalCases() {
      fetch("/cases")
        .then(res => res.json())
        .then(res => {
          this.all_cases = res.data;
        })
        .catch(err => console.log(err));
    },

    fetchGroups() {
      this.path = window.location.pathname.split("/");
      if (this.group_selection) {
        this.curr_user = this.path[this.path.length - 3];
        this.curr_group = this.group_selection;
      } else {
        this.curr_user = this.path[this.path.length - 2];
      }

      fetch("/user_groups/" + this.curr_user)
        .then(res => res.json())
        .then(res => {
          this.user_groups = res.data;
        })
        .catch(err => console.log(err));
    },

    sendCaseStudyData() {
      this.path = window.location.pathname.split("/");
      //  this.uid = Number(this.path[this.path.length - 2]);
      this.date = new Date().toJSON().slice(0, 10);

      this.case_study.cid = this.all_cases[this.all_cases.length - 1].cid + 1;
      this.case_study.c_title = this.title;
      this.case_study.c_description = this.description;
      this.case_study.c_thumbnail = "empty";
      this.case_study.c_status = "active";
      this.case_study.c_date = this.date;
      this.case_study.c_owner = this.curr_user;
      this.case_study.c_group = this.curr_group;

      this.$emit("createCaseStudy", this.case_study);
      this.totalCases(); //update total cases
      //reset variable
      this.case_study = {
        cid: "",
        c_title: "",
        c_description: "",
        c_thumbnail: "",
        c_status: "",
        c_date: "",
        c_owner: "",
        c_group: ""
      };
      this.resetInputFields();
    }
  }
};
</script>

<style lang="scss" scoped>
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

textarea {
  width: 100%;
  min-height: 150px;
  resize: none;
}

.modal {
  background: rgba(85, 85, 85, 0.5);
}
</style>
