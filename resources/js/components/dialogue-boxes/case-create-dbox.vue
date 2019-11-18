<template>
  <transition>
    <div>
      <!-- Dialogue Component to create case study -->
      <div class="modal" id="case_create_dbox" tabindex="-1" role="dialog" ref="case_modal">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{action}} {{acted_on}}</h5>
            </div>
            <!-- Render group name input element to dialogue box when user creates group -->
            <div class="modal-body">
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
              <label for="title">
                Title
                <span class="required">*</span>
              </label>
              <div class="input-group">
                <input
                  id="title"
                  aria-describedby="required-description"
                  class="form-control input-sm"
                  style="
                    height:35px;"
                  required="required"
                  type="text"
                  maxlength="50"
                  v-model="title"
                  placeholder="Title..."
                >
              </div>

              <!-- group selection for table -->
              <div class="form-group">
                <label for="group_select">Assign to a group</label>
                <select
                  class="form-control"
                  id="group_select"
                  style="height:38px"
                  v-model="curr_group"
                  :disabled="disable_dropdown"
                >
                  <option></option>
                  <option
                    v-for="group in user_groups"
                    v-bind:key="group.gid"
                    :value="group.gid"
                  >{{group.g_name}}</option>
                </select>
              </div>
              <!-- case description -->
              <div class="form-group">
                <label for="description">
                  Description
                  <span class="required">*</span>
                </label>
                <textarea
                  class="form-control"
                  id="description"
                  maxlength="140"
                  required="required"
                  v-model="description"
                  v-on:keyup="countdown"
                ></textarea>
              </div>
              <!-- error not used due to character limit -->
              <p class="text-right h6" v-bind:class="{'text-danger': hasError }">{{remainingCount}}</p>
            </div>
            <!-- footer -->
            <div class="modal-footer">
              <p
                style="margin-right:495px;padding-top:15px;font-size:18px;"
                aria-hidden="true"
                id="required-description"
              >
                <span class="required">*</span>Required field
              </p>
              <!--action button -->
              <button type="button" class="btn btn-primary" @click="sendCaseStudyData()">{{action}}</button>
              <!-- close button -->
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
/**
 *This dialogue box is used to get input for a new case study
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
    group_selection: {
      //curr group user is viewing, append as default option for groups
      type: String,
      default: ""
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
  data() {
    return {
      close_dialog: "", //to close action table
      title: "", //input for title of case study
      curr_user: "", //current user id
      curr_group: "", //curr group id
      description: "", //inpuy for description of case study

      all_cases: [], //all cases of the system. Used to determine ID of new case study
      user_groups: [], //groups of curr user

      case_study: {
        //case study attributes
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
      valid_input: false, //is input valid
      disable_dropdown: false //disable dropdown options for group
    };
  },
  /**
   * @description gets a list of users groups to append to case study when the component is loaded
   * gets all system's cases to set case variable
   */
  created() {
    this.fetchGroups();
    this.totalCases();
  },
  /**
   * @descriptcion handles modal closing event
   */
  mounted() {
    $(this.$refs.case_modal).on("hidden.bs.modal", this.resetInputFields);
  },

  methods: {
    /**
     * @description updates the description's remaining characters count
     */
    countdown() {
      this.remainingCount = this.maxCount - this.description.length;
      this.hasError = this.remainingCount < 0;
    },
    /**
     * @description resets all case study input fields
     */
    resetInputFields() {
      this.title = "";
      this.description = "";
      if (!this.group_selection) {
        this.curr_group = "";
      }
      this.remainingCount = 140;
      this.$emit("close"); //reset error prop
    },

    /**
     * @description gets all of the system's cases
     */
    totalCases() {
      fetch("/cases")
        .then(res => res.json())
        .then(res => {
          this.all_cases = res.data;
        })
        .catch(err => console.log(err));
    },

    /**
     * @description gets all the groups of the current user
     */
    fetchGroups() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      if (this.group_selection) {
        //call from group view, default selection is made
        //variable sent by group vue to set default in group options, therefor set group default to (curr_group/group selection)
        this.curr_user = this.path[this.path.length - 3]; //get ID from path
        this.curr_group = this.group_selection; //default dropdown selection
        this.disable_dropdown = true;
      } else {
        //called by user_groups vue
        this.curr_user = this.path[this.path.length - 2]; //get ID from path
      }

      fetch("/user_groups/" + this.curr_user)
        .then(res => res.json())
        .then(res => {
          this.user_groups = res.data;
        })
        .catch(err => console.log(err));
    },

    /**
     * @description calls the createCaseStudy method from parent window(user_cases)
     *  and sends the data for the new case study
     */
    sendCaseStudyData() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID

      //yyyy-mm-dd
      this.date = new Date().toJSON().slice(0, 10); //current date

      //append data to new case study
      this.case_study.cid = this.all_cases[this.all_cases.length - 1].cid + 1; //append new id
      this.case_study.c_title = this.title;
      this.case_study.c_description = this.description;
      this.case_study.c_thumbnail = "";
      this.case_study.c_status = "active";
      this.case_study.c_date = this.date;
      this.case_study.c_owner = this.curr_user;
      this.case_study.c_group = this.curr_group;

      this.$emit("createCaseStudy", this.case_study); //call method with data
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
    }
  }
};
</script>

<style lang="scss" scoped>
/*the following style are for the search text and input text box(title)*/
.modal-body label,
.modal-body select,
.modal-body input {
  font-size: 18px;
  display: inline-block;
  margin: 5px;
}

/*title input text box*/
.input-group input {
  border-radius: 3px;
}
/***********************************************************/

/*description box attributes*/
textarea {
  width: 100%;
  height: 100px;
  resize: none;
}

/*height and width for group dropdown and title input are defined in html element*/

/*set color for dialogue box popup background*/
.modal {
  background: rgba(85, 85, 85, 0.5);
}

.required {
  color: red;
}
</style>
