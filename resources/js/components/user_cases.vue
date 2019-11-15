
<template>
  <div class="body mb-5 mt-5">
    <!-- buttons to create or remove a case study -->
    <h1 class="mb-3">
      <!-- remove button if clicked, render confirmation dialogue box to validate user's action -->
      <span data-toggle="modal" data-target="#action_confirm_dbox">
        <a
          href="#action_confirm_dbox"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Click icon to delete a case study"
          @click="action='Remove',
        acted_on='case study(s)', isCaseSelected()"
        >
          <div id="remove_icon">
            <a>Remove</a>
            <i class="material-icons">remove_circle_outline</i>
          </div>
        </a>
      </span>
      <!-- create button if clicked, render create case study dialogue box -->
      <div>
        <span data-toggle="modal" data-target="#case_create_dbox">
          <a
            href="#case_create_dbox"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Click icon to create a case study"
            @click=" action='Create',
            acted_on='case study'"
          >
            <div id="create_icon">
              <a>Create</a>
              <i class="material-icons">add_circle_outline</i>
            </div>
          </a>
        </span>
      </div>

      <p>My case studies</p>
    </h1>

    <div v-if="action=='Remove'">
      <!--  confirmation dialogue box to validate user's request-->
      <action_confirm_dbox
        :action_confirm="action"
        :acted_on="acted_on"
        :is_selected="is_selected"
        @removeCases="removeCases"
      ></action_confirm_dbox>
    </div>

    <div v-if="action=='Create'">
      <!-- if action is to create group(s) render confirmation dialogue alerting execution of said action-->
      <case_create_dbox :action="action" :acted_on="acted_on" @createCaseStudy="createCaseStudy"></case_create_dbox>
    </div>

    <hr>

    <!-- tables tabs and search bar -->
    <div id="tabs" class="container">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link active"
            id="tab1"
            data-toggle="tab"
            data-placement="bottom"
            title="Case studies i created"
            href="#owned_cases"
            role="tab"
            @click="page_content=cases_user_is_owner, curr_tab=1, updatePaginator() "
          >Case studies i created</a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="tab2"
            data-toggle="tab"
            data-placement="bottom"
            title="Case studies from groups i belong to"
            href="#group_cases"
            role="tab"
            @click="page_content=user_cases_by_group, curr_tab=2, updatePaginator() "
          >Case studies by groups</a>
        </li>
      </ul>
    </div>
    <div class="container" id="entries_search">
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
          >{{entries_per_table_page}}</button>
        </span>
        <div class="dropdown-menu">
          <a class="dropdown-item" @click="selectEntries(4)" href="#">4</a>
          <a class="dropdown-item" @click="selectEntries(8)" href="#">8</a>
          <a class="dropdown-item" @click="selectEntries(16)" href="#">16</a>
          <a class="dropdown-item" @click="selectEntries(32)" href="#">32</a>
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
            placeholder="Case title.."
          >
        </div>
      </div>
    </div>

    <!-- Table of case studies the user has created-->
    <div class="tab-content">
      <div class="tab-pane active" id="owned_cases" role="tabpanel">
        <b-table head-variant="light" hover :items="filterCases" :fields="fields">
          <template v-slot:head(index)>
            <input type="checkbox" @click="checkAll()" v-model="all_selected">
            Select All
          </template>
          <template v-slot:cell(index)="data">
            <div class="p-2">
              <input
                class="checkbox"
                type="checkbox"
                id="checkbox"
                @click="select()"
                v-model="selected_cases"
                :value="data.item.cid"
              >
              {{data.index +1}}
            </div>
          </template>
          <template v-slot:cell(c_title)="data">
            <div>
              <b-link class="p-2" href="#">{{data.item.c_title}}</b-link>
            </div>
          </template>
        </b-table>
      </div>
      <!-- Table of case studies belonging to the groups of the user -->
      <div class="tab-pane" id="group_cases" role="tabpanel">
        <b-table head-variant="light" hover :items="filterCases" :fields="fields">
          <template v-slot:cell(index)="data">
            <div class="p-2">{{data.index +1}}</div>
          </template>
          <template v-slot:cell(c_title)="data">
            <div>
              <b-link class="p-2" href="#">{{data.item.c_title}}</b-link>
            </div>
          </template>
        </b-table>
      </div>
    </div>
    <!--number of entries per table page option -->
    <div id="container">
      <!-- paginator -->
      <div id="paginate" v-if="reload_paginator">
        <paginator
          :items="page_content"
          :page_size="entries_per_table_page"
          @changePage="onChangePage"
          class="pagination"
          style="display:inline-block"
        ></paginator>
      </div>
    </div>
  </div>
</template>

<script>
import BootstrapVue, { BTable, BLink } from "bootstrap-vue";

/**
 * this component is used to display the cases of a user
 */
export default {
  /**
   * @description declaration of global variables
   * @returns array of all variables
   */

  components: {
    "b-table": BTable,
    "b-link": BLink
  },
  data() {
    return {
      curr_user: "", //current user id
      action: "", //action the user is executing
      acted_on: "", //on what is the action being exected
      search: "", //table search string

      user_cases: [], // cases of the user
      cases_user_is_owner: [], //list of cases the user has created
      user_cases_by_group: [], //list of cases of the groups the user belongs to(member)
      selected_cases: [], // the cases the user selects
      cases_to_remove: [], // the cases to remove, sent to controller
      page_of_cases: [], //cases to show on table page
      page_content: [], //cases to send to paginator

      case_study: { cid: "", c_title: "" }, //case attributes

      fields: [
        { index: { thStyle: { width: "120px" } } },
        {
          key: "c_title",
          label: "Title",

          sortable: true
        }
      ],

      curr_tab:1, //current opened tab DEFAULT
      entries_per_table_page: 4, //table entries
      reload_paginator: false, //used to update paginator
      is_selected: false, //has user made selection
      all_selected: false, //has the option to select all case studies been checked
      gname_box_show: false, //boolean to append group name input to dialogue box when creating a group
      initial_load:true
    };
  },
  /**
   * @description gets all users cases to populate case table when the page is loaded
   */
  created() {
    this.fetchCases();
  },
  computed: {
    /**
     * @description filters cases by title search. Method is called per each key press
     * @returns list of cases in accordance to search.
     */
    filterCases() {
      if (this.page_content.length == 0) {
        return [];
      }
      return this.page_of_cases.filter(page_of_cases => {
        return page_of_cases.c_title.includes(this.search);
      });
    }
  },
  methods: {
    /**
     * @description  checks all checkboxes when user selects "select all" option
     */
    checkAll() {
      this.selected_cases = [];
      if (!this.all_selected) { //push all case studies to array
        for (let i in this.cases_user_is_owner) {
          this.selected_cases.push(this.cases_user_is_owner[i].cid);
        }
      }
    },

    /**
     * @description if checkbox is checked again remove all selections
     */
    select() {
      this.all_selected = false;
    },
    /**
     * @description - lists the set of cases of the current table page
     * @param  {Array} page_of_cases - contains a list of set of cases sent by the paginator
     *
     */
    onChangePage(page_of_cases) {
      // update page of Cases

      this.page_of_cases = page_of_cases;
    },

    /**
     * @description verifies if user has made a selection of a case
     */
    isCaseSelected() {
      if (this.selected_cases.length == 0) {
        this.is_selected = false;
      } else {
        this.is_selected = true;
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
      this.curr_user = Number(this.path[this.path.length - 2]); //get user id from path
      fetch("/user_cases/" + this.curr_user)
        .then(res => res.json())
        .then(res => {
          this.user_cases = res.data;

          this.cases_user_is_owner = this.user_cases.filter(
            x => x.c_owner == this.curr_user
          );
          this.user_cases_by_group = this.user_cases.filter(
            x => x.c_owner !== this.curr_user
          );
      //initial content load
          if (this.initial_load) {
            this.page_content = this.cases_user_is_owner;
            this.initial_load = false;
          }

          //content varies according to tab
          if (this.curr_tab == 1) {
            this.page_content = this.cases_user_is_owner;
          } else {
            this.page_content = this.user_cases_by_group;
          }
          this.select();
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
          //push selected cases id's as cid attribute
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
        body: JSON.stringify(this.cases_to_remove) //append data to the body of request
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

th {
  cursor: pointer;
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
