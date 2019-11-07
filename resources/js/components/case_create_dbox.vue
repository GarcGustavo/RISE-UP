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
              <h5 class="modal-title">{{action}} {{actor}}</h5>
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
                  maxlength="32"
                  v-model="title"
                  placeholder="Name..."
                >
              </div>

              <!-- group selection for table -->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Assign to a group(optional)</label>
                <select class="form-control" id="exampleFormControlSelect2" style="height:40px" v-model="gid">
                  <option
                    v-for="group in groups"
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
                :data-dismiss="modal"
                data-target="#mg_action_confirm"
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
      <div v-if="valid_input">
        <mg_action_confirm
          :action_confirm="action"
          :actor="actor"
          :errors="errors"
          @close="close=true"
          @revalidate="validateInput"
        ></mg_action_confirm>
      </div>
      <div v-else>
        <mg_action_confirm :action_confirm="action" :actor="actor" :errors="errors"></mg_action_confirm>
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
    group_selection: {
      type: Number
    }
  },

  data() {
    return {
      showModal: false,
      modal: "",
      title: "",
      uid: "",
      gid: "",
      description: "",
      case_study: {
        cid: "",
        c_title: "",
        c_description: "",
        c_thumbnail: "",
        c_status: "",
        c_date: "",
        c_owner: "",
        c_group: ""
      },

      cases: [],
      groups: [],
      errors: [],

      maxCount: 140,
      remainingCount: 140,
      close: false,
      hasError: false,
      valid_input: false
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
      this.gid = "";
      this.remainingCount = 140;
    },

    validateInput() {
      if (this.title && this.description) {
        this.sendCaseStudyData();
        this.valid_input = true;
        this.modal = "modal";
        this.errors = [];
      } else {
        this.modal = "";
        this.valid_input = false;

        this.errors = [];

        if (!this.title) {
          this.errors.push("title required.");
        }
        if (!this.description) {
          this.errors.push("description required.");
        }
      }
      //  this.valid_input = false;
    },

    totalCases() {
      fetch("/cases")
        .then(res => res.json())
        .then(res => {
          this.cases = res.data;

        })
        .catch(err => console.log(err));
    },

    fetchGroups() {
      this.path = window.location.pathname.split("/");
      if (this.group_selection) {
        this.uid = Number(this.path[this.path.length - 3]);
        this.gid=this.group_selection;
      } else {
        this.uid = Number(this.path[this.path.length - 2]);
      }

      fetch("/user_groups/" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
        })
        .catch(err => console.log(err));
    },

    sendCaseStudyData() {
      this.path = window.location.pathname.split("/");
      this.uid = Number(this.path[this.path.length - 2]);
      this.date = new Date().toJSON().slice(0, 10);

      this.case_study.cid = this.cases[this.cases.length - 1].cid + 1;
      this.case_study.c_title = this.title;
      this.case_study.c_description = this.description;
      this.case_study.c_thumbnail = "empty";
      this.case_study.c_status = "active";
      this.case_study.c_date = this.date;
      this.case_study.c_owner = this.uid;
      this.case_study.c_group = this.gid;

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
