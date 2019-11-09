
<template>
  <div class="body mb-5 mt-5">
    <!-- buttons to create or remove a case study -->
    <h1 class="mb-3">
      <!-- remove button if clicked, render confirmation dialogue box to validate user's action -->
      <a
        href="#action_confirm_dbox"
        data-toggle="modal"
        data-target="#action_confirm_dbox"
        @click="action='Remove',
        acted_on='case study(s)', isCaseSelected()"
      >
        <div class="add_icon" style="display:inline-block;float:right;">
          <a style="font-size:18px;margin-left:15px">Remove</a>
          <i class="material-icons">remove_circle_outline</i>
        </div>
      </a>
      <!-- create button if clicked, render create case study dialogue box -->
      <div>
        <a
          href="#case_create_dbox"
          data-toggle="modal"
          data-target="#case_create_dbox"
          @click=" action='Create',
        acted_on='case study'"
        >
          <div class="remove_icon" style="display:inline-block;float:right;">
            <a style="font-size:18px">Create</a>
            <i class="material-icons">add_circle_outline</i>
          </div>
        </a>
      </div>

      <p>My cases</p>
    </h1>

    <div v-if="action=='Remove'">
      <!-- if action is to remove case(s) render confirmation dialogue to validate user's request-->
      <action_confirm_dbox
        :action_confirm="action"
        :acted_on="acted_on"
        :isSelected="isSelected"
        @removeCases="removeCases"
      ></action_confirm_dbox>
    </div>

    <div v-if="action=='Create'">
      <!-- if action is to create group(s) render confirmation dialogue alerting execution of said action-->
      <case_create_dbox :action="action" :acted_on="acted_on" @createCaseStudy="createCaseStudy"></case_create_dbox>
    </div>

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
        <!--list user's case studies -->
        <tr v-for="(case_study,index) in pageOfCases" :key="index">
          <!-- if user is not owner of case study eliminate option to remove case study -->
          <td v-if="case_study.c_owner == curr_user">
            <div class="check-box">
              <input
                class="checkbox"
                type="checkbox"
                id="checkbox"
                v-model="selected_cases"
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
    <!--number of entries per table page option -->
    <div id="container">
      <div class="btn-group" style="padding-top:12px;width:100px;">
        <label style="padding-right:5px;">Entries:</label>
        <!--entries button -->
        <button
          class="btn btn-primary btn-sm dropdown-toggle"
          type="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >{{entries_per_table_page}}</button>
        <div class="dropdown-menu">
          <a class="dropdown-item" @click="selectEntries(4)" href="#">4</a>
          <a class="dropdown-item" @click="selectEntries(8)" href="#">8</a>
          <a class="dropdown-item" @click="selectEntries(16)" href="#">16</a>
          <a class="dropdown-item" @click="selectEntries(32)" href="#">32</a>
        </div>
      </div>
      <!-- paginator -->
      <div id="paginate" v-if="reload_paginator">
        <paginator
          :items="user_cases"
          :pageSize="entries_per_table_page"
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
 * write a component's description
 */
export default {

  /**
   * @description declaration of global variables
   * @returns array of all variables
   */
  data() {
    return {
      curr_user: "", //current user id
      action: "", //action the user is executing
      acted_on: "", //on what is the action being exected

      user_cases: [], // cases of the user
      selected_cases: [], // the cases the user selects
      cases_to_remove: [], // the cases to remove, sent to controller
      pageOfCases: [], //cases to show on table page

      case_study: { cid: "", c_title: "" }, //case attributes

      entries_per_table_page: 4, //table entries

      reload_paginator: false, //used to update paginator
      isSelected: false, //has user made selection
      gname_box_show: false //boolean to append group name input to dialogue box when creating a group
    };
  },
  /**
   * @description gets all users cases to populate case table when the page is loaded
   */
  created() {
    this.fetchCases();
  },
  methods: {


    /**
     * @description - lists the set of cases of the current table page 
     * @param  {Array} pageOfCases - contains a list of set of cases sent by the paginator
     *
     */
    onChangePage(pageOfCases) {

      // update page of Cases
      this.pageOfCases = pageOfCases;
    },

    /**
     * @description verifies if user has made a selection of a case
     */
    isCaseSelected() {
      if (this.selected_cases.length == 0) {
        this.isSelected = false;
      } else {
        this.isSelected = true;
      }
    },

    /**
     * @description sets the number of cases to show in a page
     * @param {Number} entry - variable containing the number of entries per page
     */
    selectEntries(entry) {
      this.entries_per_table_page = entry;
      this.updatePaginator();
    },

    /**
     * @description - refreshes the paginator
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
     * @description unchecks any selection of cases the user has made
     */
    uncheck() {
      this.selected_cases = [];

      for (let i in this.selected_cases) {
        this.selected_cases.push(this.selected_cases[i].cid);
      }
    },

    /**
     * @description gets all the cases of the current user
     */
    fetchCases() {
      this.path = window.location.pathname.split("/"); //slice URL in array to get ID
      this.curr_user = this.path[this.path.length - 2]; //get ID from path
      fetch("/user_cases/" + this.curr_user)
        .then(res => res.json())
        .then(res => {
          this.user_cases = res.data;
          this.pageOfCases = this.user_cases;
          this.uncheck();
          this.updatePaginator(); //refresh with updated list of cases
        })
        .catch(err => console.log(err));
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
          this.fetchCases();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description removes any selected user cases by making a delete request to caseController
     */
    removeCases() {
      for (let i in this.selected_cases) {
        this.cases_to_remove.push({
          cid: this.selected_cases[i]
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
        .then(res => res.json())
        .then(res => {
          console.log(res);
          console.log(this.cases_to_remove);
          this.fetchCases(); //update UI with latest cases
          this.cases_to_remove = []; //reset variable of cases to remove
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
  color: blue;
}
/* icon initial color */
a {
  color: black;
}
</style>
