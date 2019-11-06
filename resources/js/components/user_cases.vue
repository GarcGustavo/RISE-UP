
<template>
  <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">
      <a
        href="#mg_action_confirm"
        data-toggle="modal"
        data-target="#mg_action_confirm"
        @click="action='Remove',
        actor='case study(s)', isCaseSelected()"
      >
        <div class="add_icon" style="display:inline-block;float:right;">
          <a style="font-size:18px;margin-left:15px">Remove</a>
          <i class="material-icons">remove_circle_outline</i>
        </div>
      </a>
      <a
        href="#case_create_dbox"
        data-toggle="modal"
        data-target="#case_create_dbox"
        @click="showModal=true,
        action='Create',
        actor='case study'"
      >
        <div class="remove_icon" style="display:inline-block;float:right;">
          <a style="font-size:18px">Create</a>
          <i class="material-icons">add_circle_outline</i>
        </div>
      </a>

      <div v-if="action=='Remove' && isSelected">
        <!-- if action is to remove group, render confirm box upfront; this is so there's no display issues with action_table since it also renders a confirm box -->
        <mg_action_confirm
          :action_confirm="action"
          :actor="actor"
          :errors="[]"
          :isSelected="isSelected"
          @removeCases="removeCases"
        ></mg_action_confirm>
      </div>
      <div v-else-if="action=='Remove' && !isSelected">
        <mg_action_confirm
          :action_confirm="action"
          :actor="actor"
          :errors="[]"
          :isSelected="isSelected"
          @removeCases="removeCases"
        ></mg_action_confirm>
      </div>

      <case_create_dbox :action="action" :actor="actor" @createCaseStudy="createCaseStudy"></case_create_dbox>

      <p>My cases</p>
    </h1>

    <hr>
    <!-- Table -->
    <table id="group-table" class="table table-hover table-bordered table-sm" cellspacing="0">
      <thead class="thead-dark">
        <tr>
          <th id="row-order">#</th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(case_study,index) in pageOfCases" :key="index">
          <td v-if="case_study.c_owner == uid">
            <div class="check-box">
              <input
                class="checkbox"
                type="checkbox"
                id="checkbox"
                v-model="cids"
                :value="case_study.cid"
              >
              <label for="checkbox">{{index+1}}</label>
            </div>
          </td>
          <td v-else>
            <div>
              <label style="padding-top:18px;padding-left:18px;">{{index+1}}</label>
            </div>
          </td>
          <td>
            <a href="#">{{case_study.c_title}}</a>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="ready">
      <paginator :items="cases" @changePage="onChangePage" class="pagination"></paginator>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cases: [],
      cids: [],
      cases_to_remove: [],
      case_study: { cid: "", c_title: "" },
      pageOfCases: [],
      users: [],
      uid: "",
      action: "",
      actor: "",
      showModal: false,
      isSelected: false,
      ready: false,
      gname_box_show: false //boolean to append group name input to dialogue box when creating a group
    };
  },
  created() {
    this.fetchCases();
  },

  methods: {
    onChangePage(pageOfCases) {
      // update page of Casess
      this.pageOfCases = pageOfCases;
    },

    isCaseSelected() {
      if (this.cids.length == 0) {
        this.isSelected = false;
      } else {
        this.isSelected = true;
      }
    },

    updatePaginator() {
      // Remove paginator from the DOM
      this.ready = false;

      this.$nextTick().then(() => {
        // Add the paginator back in
        this.ready = true;
      });
    },

    uncheck() {
      this.cids = [];

      for (let i in this.cids) {
        this.cids.push(this.cids[i].cid);
      }
    },

    fetchUsers() {
      fetch("/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
        })
        .catch(err => console.log(err));
    },

    fetchCases() {
      this.path = window.location.pathname.split("/");
      this.uid = this.path[this.path.length - 2];
      fetch("/user_cases/" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.cases = res.data;
          this.pageOfCases = this.cases;
          this.uncheck();
          this.updatePaginator();
        })
        .catch(err => console.log(err));
    },

    createCaseStudy(case_study) {
      console.log(JSON.stringify(case_study));
      fetch("/case/create", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(case_study)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
          this.fetchCases();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    removeCases() {
      console.log(JSON.stringify(this.cids));

      for (let i in this.cids) {
        this.cases_to_remove.push({
          cid: this.cids[i]
        });
      }
      fetch("/user_cases/remove", {
        method: "delete",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(this.cases_to_remove)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
          this.fetchCases();
          this.uncheck();

          this.cases_to_remove = [];
        })
        .catch(err => {
          console.error("Error: ", err);
        });
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
table tr td a {
  display: block;
  font-size: 18px;
}
/* This is for row content style and alignment */
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
/* align vertically to center checkbox */
table tr td .check-box {
  padding-top: 20px;
}
/* checkbox column width */
#row-order {
  width: 15%;
}
/* check box and label styling */
input[type="checkbox"] + label {
  font-size: 18px;
  height: 18px;
  width: 18px;
  display: inline-block;
  padding: 0 0 0 0px;
}
/* change checkbox size */
input[type="checkbox"] {
  transform: scale(1.2);
}
/* paginate component position in body */
.pagination {
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
  color: blue;
}
/* icon initial color */
a {
  color: black;
}
</style>
