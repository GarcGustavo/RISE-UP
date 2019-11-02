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
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- Render group name input element to dialogue box when user creates group -->
            <div class="modal-body">
              <label>Title</label>
              <div class="input-group-append">
                <input type="text" v-model="title" placeholder="Name...">
              </div>

              <!-- group selection for table -->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Assign to a group(optional)</label>
                <select class="form-control" id="exampleFormControlSelect2" v-model="gid">
                  <option v-for="group in groups" v-bind:key="group.gid" :value="group.gid"> {{group.g_name}}</option>
                </select>
              </div>
              <!-- case description -->
              <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  class="form-control"
                  id="description"
                  maxlength="255"
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
                data-target="#mg_action_confirm"
                @click="sendCaseStudyData()"
              >{{action}}</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!--confirmation dialogue box -->
      <div>
        <mg_action_confirm :action_confirm="action" :actor="actor"></mg_action_confirm>
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
    }
  },

  data() {
    return {
      showModal: false,
      title: "",
      uid:"",
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
      cases:[],
      groups:[],
      maxCount: 255,
      remainingCount: 255,
      message: "",
      hasError: false
    };
  },
  created() {
    this.fetchGroups();
    this.totalCases();
  },

  methods: {
    countdown() {
      this.remainingCount = this.maxCount - this.message.length;
      this.hasError = this.remainingCount < 0;
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
      this.uid = Number(this.path[this.path.length - 2]);
      fetch("/user_groups/" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
          console.log(this.groups);
          this.ready = true;
        })
        .catch(err => console.log(err));
    },

    sendCaseStudyData() {
      this.path = window.location.pathname.split("/");
      this.uid = Number(this.path[this.path.length - 2]);
      this.date = new Date().toJSON().slice(0, 10);

      this.case_study.cid = this.cases.length + 1;
      this.case_study.c_title = this.title;
      this.case_study.c_description = this.description;
      this.case_study.c_thumbnail = "empty";
      this.case_study.c_status = "lol";
      this.case_study.c_date = this.date;
      this.case_study.c_owner = this.uid;
      this.case_study.c_group = this.gid;

      this.$emit("createCaseStudy", this.case_study);
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
