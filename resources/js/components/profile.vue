
<template>
  <div class="container-fluid mb-5 mt-5">
    <!-- Grid row 1 -->
    <div class="row">
      <!-- Grid column 1.1 -->
      <div class="col-9">
        <h1>
          <p>Profile</p>
        </h1>
      </div>
      <!-- End Column 1.1 -->

      <!-- Grid column 1.2 -->
      <div class="col-3 float-right">
        <!-- buttons to update or cancel profile changes; if statement-->
        <div class="align-content-center" v-if="!update">
          <a
            href="#"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Click button to edit profile"
            @click.prevent="update=1"
          >
            <div id="update_icon">
              <a>Edit</a>
              <i class="material-icons">create</i>
            </div>
          </a>
        </div>

        <div v-else>
          <a
            href="#"
            data-toggle="tooltip"
            data-placement="bottom"
            title="Click button to cancel changes"
            @click.prevent="update=0"
          >
            <div id="update_icon">
              <a>Cancel</a>
              <i class="material-icons">cancel</i>
            </div>
          </a>
        </div>
        <!-- End if statement -->
      </div>
      <!-- End Column 1.2 -->
    </div>
    <!-- End Grid row 1 -->

    <hr />

    <!-- Grid 2 row -->
    <div class="row align-items-center">

      <!-- Grid 2.1 column -->
      <div class="col-3" id="avatar">
        <!-- Content -->
        <!-- <img src="../../../public/images/nsf_logo.jpg" /> -->
        <div class="circle">
          <img :src="google_info.picture" alt="User photo" />
        </div>
      </div>
      <!-- End Grid 2.1 column -->

     <div class="col-1">
     </div>

      <!-- Grid 2.2 column -->
      <div class="col-6" id="updateInfo">

          <!-- If statement -->
        <div v-if="update">
          <!-- Content -->
          <div v-if="u_errors" class="alert alert-danger">
            <ul v-for="e in u_errors" :key="e">
              <li>{{e}}</li>
            </ul>
          </div>
          <div class="input-group">
            <form action="/user/update" method="POST" style="width: 100%">
              <input type="hidden" :value="csrfToken" name="_token" />
              <input type="hidden" :value="curr_user" name="uid" />
              <div class="form-goup mt-3">
                <input
                  class="form-control form-control-sm"
                  type="text"
                  name="first"
                  id="u_fname"
                  :value="user.first_name"
                />
              </div>
              <div class="form-goup mt-3">
                <input
                  class="form-control form-control-sm"
                  type="text"
                  name="last"
                  id="u_lname"
                  :value="user.last_name"
                />
              </div>
              <div class="form-goup mt-3">
                <input
                  class="form-control form-control-sm"
                  type="email"
                  name="contact_email"
                  id="u_email"
                  :value="user.contact_email"
                />
              </div>
              <div class="form-goup mt-3">
                <input
                  class="form-control form-control-sm"
                  type="text"
                  name="organization"
                  id="u_organization"
                  :value="user.organization"
                />
              </div>
              <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 100%">Update</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Else of if statement -->
        <div v-else>
          <!-- Content -->
          <div class="card shadow">
            <div class="card-body">
              <h3 class="card-title">User Information</h3>
              <p>Name: {{user_name}}</p>
              <p>Contact Email: {{user.contact_email}}</p>
              <p>Role: {{user_role}}</p>
              <p>Organization: {{user.organization}}</p>
              <p>Account Expiration Date: {{user.u_expiration_date}}</p>
            </div>
          </div>
        </div>
        <!-- End if statement -->

      </div>
      <!-- Grid 2.2 column -->

    </div>
    <!-- Grid 2 row -->

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
            @click.prevent="
            curr_tab=1
          "
          >Case studies I created</a>
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
            @click.prevent="
            curr_tab=2
             "
          >Groups I created</a>
        </li>
      </ul>
    </div>

    <div class="container" id="entries_search">
      <!--entries for tab1 -->
      <div v-if="curr_tab==1">
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
            >{{entries_per_table_page_tab1}}</button>
          </span>
          <div class="dropdown-menu">
            <a class="dropdown-item" @click.prevent="selectEntries(4)" href="#">4</a>
            <a class="dropdown-item" @click.prevent="selectEntries(8)" href="#">8</a>
            <a class="dropdown-item" @click.prevent="selectEntries(16)" href="#">16</a>
            <a class="dropdown-item" @click.prevent="selectEntries(32)" href="#">32</a>
          </div>
        </div>
      </div>
      <!-- entries for tab2 -->

      <div v-if="curr_tab==2">
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
            >{{entries_per_table_page_tab2}}</button>
          </span>
          <div class="dropdown-menu">
            <a class="dropdown-item" @click.prevent="selectEntries(4)" href="#">4</a>
            <a class="dropdown-item" @click.prevent="selectEntries(8)" href="#">8</a>
            <a class="dropdown-item" @click.prevent="selectEntries(16)" href="#">16</a>
            <a class="dropdown-item" @click.prevent="selectEntries(32)" href="#">32</a>
          </div>
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
          />
        </div>
      </div>
    </div>

    <!-- Table of case studies the user has created for tab1-->
    <div class="tab-content">
      <div class="tab-pane active" id="owned_cases" role="tabpanel">
        <b-table
          sticky-header="600px"
          head-variant="light"
          hover
          :items="filterCases"
          :fields="fields"
        >
          <!--table headers -->
          <!-- index header -->
          <template v-slot:head(index)>
            <input type="checkbox" @click="checkAll()" v-model="all_selected" />
            <a
              href="#"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Click to unsort table"
              @click.prevent="unSort()"
            >Select All</a>
          </template>

          <!-- title header -->
          <template v-slot:head(c_title)>
            <a
              href="#"
              style="display:block"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Click to sort table"
              @click.prevent="sortItems()"
            >
              Title
              <!-- icons -->
              <i
                v-if="sort_order_tab1_icon==0"
                style="color:grey;float:right;padding-top:4px"
                class="fa fa-fw fa-sort"
              ></i>
              <i
                v-if="sort_order_tab1_icon==-1"
                style="color:grey;float:right;padding-top:4px"
                class="fa fa-fw fa-sort-up"
              ></i>
              <i
                v-if="sort_order_tab1_icon==1"
                style="color:grey;float:right;padding-top:4px"
                class="fa fa-fw fa-sort-down"
              ></i>
            </a>
          </template>

          <!--table rows -->
          <!-- index column -->
          <template v-slot:cell(index)="data">
            <div class="p-2 pl-4">
              <input
                class="checkbox"
                type="checkbox"
                id="checkbox"
                @click="select()"
                v-model="selected_cases"
                :value="data.item.cid"
              />
              {{data.index +1}}
            </div>
          </template>

          <!-- case title column -->
          <template v-slot:cell(c_title)="data">
            <div>
              <b-link class="p-2" :href="'/case/body?cid='+data.item.cid">{{data.item.c_title}}</b-link>
            </div>
          </template>
        </b-table>

        <!--paginator -->
        <div id="paginate" v-if="reload_paginator && curr_tab==1">
          <paginator
            ref="paginate"
            :items="page_content_tab1"
            :page_size="entries_per_table_page_tab1"
            @changePage="onChangePage"
            class="pagination"
            style="display:inline-block"
          ></paginator>
        </div>
      </div>

      <!-- Table of case studies belonging to the groups of the user for tab2-->
      <div class="tab-pane" id="group_cases" role="tabpanel">
        <b-table
          sticky-header="600px"
          head-variant="light"
          hover
          :items="filterCases"
          :fields="fields"
        >
          <!-- table headers -->
          <!-- index header -->
          <template v-slot:head(index)>
            <a
              href="#"
              style="display:block"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Click to unsort table"
              @click.prevent="unSort()"
            >Index</a>
          </template>

          <!-- title header -->
          <template v-slot:head(c_title)>
            <a
              href="#"
              style="display:block"
              data-toggle="tooltip"
              data-placement="bottom"
              title="Click to sort table"
              @click.prevent="sortItems()"
            >
              Title
              <!--icons -->
              <i
                v-if="sort_order_tab2_icon==0"
                style="color:grey;float:right;padding-top:4px"
                class="fa fa-fw fa-sort"
              ></i>
              <i
                v-if="sort_order_tab2_icon==-1"
                style="color:grey;float:right;padding-top:4px"
                class="fa fa-fw fa-sort-up"
              ></i>
              <i
                v-if="sort_order_tab2_icon==1"
                style="color:grey;float:right;padding-top:4px"
                class="fa fa-fw fa-sort-down"
              ></i>
            </a>
          </template>

          <!--table rows -->
          <!-- index column -->
          <template v-slot:cell(index)="data">
            <div class="p-2">{{data.index +1}}</div>
          </template>
          <!-- title column -->
          <template v-slot:cell(c_title)="data">
            <div>
              <b-link class="p-2" :href="'/case/body?cid='+data.item.cid">{{data.item.c_title}}</b-link>
            </div>
          </template>
        </b-table>

        <!--paginator -->
        <div id="paginate" v-if="reload_paginator && curr_tab==2">
          <paginator
            ref="paginate2"
            :items="page_content_tab2"
            :page_size="entries_per_table_page_tab2"
            @changePage="onChangePage"
            class="pagination"
            style="display:inline-block"
          ></paginator>
        </div>
      </div>
    </div>
    <!--number of entries per table page option -->
  </div>
</template>

<script>
/**
 * this component is used to display the cases of a user
 */
export default {
  /**
   * @description declaration of global variables
   * @returns array of all variables
   */

  data() {
    return {
      csrfToken: null,
      user: "",
      user_name: "",
      google_info: "",
      update: "",
      u_message: "",
      user_role: "",
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
      page_content_tab1: [], //cases to send to paginator
      page_content_tab2: [],
      errors: [],
      u_errors: [],

      case_study: { cid: "", c_title: "" }, //case attributes

      fields: [
        //sortable column used in b-table and index column style definition
        { index: { thStyle: { width: "120px" } } },
        {
          key: "c_title",
          label: "Title",
          class: "text-center",
          thStyle: { paddingLeft: "30px" }
        }
      ],

      curr_tab: 1, //current opened tab DEFAULT
      entries_per_table_page_tab1: 4, //table entries
      entries_per_table_page_tab2: 4, //table entries
      sorting_tab1: -1, //sorting order, 1 is descending, -1 is ascending
      sorting_tab2: -1, //sorting order, 1 is descending, -1 is ascending
      sort_order_tab1_icon: 0, //determines sorting icon to show - 0 sort is off, 1 is down arrow, -1 is up arrow
      sort_order_tab2_icon: 0, //determines sorting icon to show - 0 sort is off, 1 is down arrow, -1 is up arrow

      reload_paginator: false, //used to update paginator
      is_selected: false, //has user made selection
      all_selected: false, //has the option to select all case studies been checked
      gname_box_show: false, //boolean to append group name input to dialogue box when creating a group
      initial_load: true, //load initial table tab content when page loads
      show_dialogue: false //opens/closes case create dbox
    };
  },

  /**
   * @description gets all users cases to populate case table when the page is loaded
   */
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    this.fetchCases();
    this.getUser();
    this.getGoogleInfo();
    this.getMessages();
  },

  computed: {
    /**
     * @description filters cases by title search. Method is called per each key press
     * @returns list of cases in accordance to search.
     */
    filterCases() {
      if (this.curr_tab == 1) {
        if (this.page_content_tab1.length == 0) {
          return [];
        } else {
          if (this.page_content_tab2.length == 0) {
            return [];
          }
        }
      } //search fiter
      return this.page_of_cases.filter(page_of_cases => {
        return page_of_cases.c_title
          .toLowerCase()
          .includes(this.search.toLowerCase());
      });
    }
  },

  methods: {
    /*#region Auxilary methods - These methods provide operational
functionalities to to the web page. Operations include but are
not limited to :Sorting, updating paginator and content,
validation, and resetting variables

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
     * @description Sorts the content of the current opened tab
     */
    sortArr() {
      if (this.curr_tab == 1) {
        //current tab content will be filtered content
        this.page_content_tab1 = this.page_content_tab1
          .slice(0)
          .sort((a, b) =>
            a.c_title.toLowerCase() < b.c_title.toLowerCase()
              ? this.sorting_tab1
              : -this.sorting_tab1
          );
        //sort icon display is set to sort direction
        this.sort_order_tab1_icon = this.sorting_tab1;
      } else {
        //curr tab is 2
        //current tab content will be filtered content
        this.page_content_tab2 = this.page_content_tab2
          .slice(0)
          .sort((a, b) =>
            a.c_title.toLowerCase() < b.c_title.toLowerCase()
              ? this.sorting_tab2
              : -this.sorting_tab2
          );

        //sort icon display is set to sort direction
        this.sort_order_tab2_icon = this.sorting_tab2;
      }

      this.updatePaginator();
    },

    /**
     * @description sets sorting direction for current tab and call sorting method
     */
    sortItems() {
      if (this.curr_tab == 1) {
        this.sorting_tab1 *= -1;
        //  this.enable_sorting_tab1 = true;
      } else {
        //curr tab is 2
        this.sorting_tab2 *= -1;
        //   this.enable_sorting_tab2 = true;
      }
      this.sortArr(); //call sorting algorithm
    },

    /**
     * @description resets all sort variables and icon's state
     */
    unSort() {
      if (this.curr_tab == 1) {
        this.sorting_tab1 = -1;
        this.sort_order_tab1_icon = 0;
        this.page_content_tab1 = this.cases_user_is_owner; //original content
      } else {
        this.sorting_tab2 = -1;
        this.sort_order_tab2_icon = 0;
        this.page_content_tab2 = this.user_cases_by_group; //original content
      }
      this.updatePaginator();
    },

    /**
     * @description  checks all checkboxes when user selects "select all" option
     */
    checkAll() {
      this.selected_cases = [];
      if (!this.all_selected) {
        //push all case studies to array
        for (let i in this.cases_user_is_owner) {
          this.selected_cases.push(this.cases_user_is_owner[i].cid);
        }
      }
    },

    /**
     * @description if checkbox is checked again uncheck all selections
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
     * @description sets the number of cases to show in a page
     * @param {Number} entry - variable containing the number of entries per page
     */
    selectEntries(entry) {
      if (this.curr_tab == 1) {
        this.entries_per_table_page_tab1 = entry;
      } else {
        this.entries_per_table_page_tab2 = entry;
      }
      this.updatePaginator();
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
     * @description reset errors
     */
    resetErrors() {
      this.errors = [];
    },

    /**
     * @description verifies if user has made a selection of a case study to remove
     * if selection is made call the remove case method to proceed with removal.
     */
    isCaseSelected() {
      if (this.selected_cases.length == 0) {
        this.is_selected = false;
        //alert box
        this.dialogue = bootbox.alert({
          title: "Remove",
          message: "Please select case study(s) to remove",
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

        //if selection made remove selected groups
      } else {
        this.is_selected = true;
        this.removeCases();
      }
    },

    /*#endregion*/

    /*#region Query methods - These methods provide the content of
the web page by requesting the data through route calls. The routes
passes the request to a specified predefined controller who processes
said request via Laravel's eloquent ORM. The data is appended to the
 global variables as needed to be used.

    /**
     * @description gets all the cases of the current user
     * Sends request to the case controller
     */
    fetchCases() {
      this.urlParams = new URLSearchParams(window.location.search); //get url parameters
      this.curr_user = Number(this.urlParams.get("uid")); //get user id - numeric conversion for filter user

      fetch("/case/user/show?uid=" + this.curr_user)
        .then(res => res.json())
        .then(res => {
          this.user_cases = res.data;
          //filter cases where user is owner
          this.cases_user_is_owner = this.user_cases.filter(
            x => x.c_owner == this.curr_user
          );
          //filter cases that the user has through group relation
          this.user_cases_by_group = this.user_cases.filter(
            x => x.c_owner !== this.curr_user
          );

          //content varies according to tab
          this.page_content_tab1 = this.cases_user_is_owner;
          this.page_content_tab2 = this.user_cases_by_group;

          this.select(); //unselect all
          this.uncheck(); //uncheck
          this.updatePaginator(); //refresh with updated list of cases
        })
        .catch(err => console.log(err));
    },

    getUser() {
      if (this.curr_user != "") {
        fetch("/user?uid=" + this.curr_user)
          .then(res => res.json())
          .then(res => {
            this.user = res.data[0];
            this.user_name = this.user.first_name + " " + this.user.last_name;
            if (this.user.u_role == 4) {
              this.user_role = "Admin";
            } else if (this.user.u_role == 3) {
              this.user_role = "Collaborator";
            } else {
              this.user_role = "Viewer";
            }
            console.log(this.user);
          });
      }
    },
    getMessages() {
      this.u_errors = JSON.parse(this.urlParams.get("u_errors"));
      this.u_message = this.urlParams.get("u_message");
      if (this.u_errors) {
        this.update = 1;
      }
      if (this.u_message != "") {
        this.confirmationBox();
      }
    },
    confirmationBox() {
      //alert box
      this.dialogue = bootbox.alert({
        title: "Confirmation Message",
        message: this.u_message,
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
    },

    getGoogleInfo() {
      if (this.curr_user != "") {
        fetch("/user/google-info?uid=" + this.curr_user)
          .then(res => res.json())
          .then(res => {
            this.google_info = res["u"];
            console.log(this.google_info);
          });
      }
    },

    /**
     * @description outputs to the caseController a JSON request to create case study
     * @param {Array} case_study - array of case study data to create a case study -
     * data is sent by the case_create_dbox dialogue
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
            //this.fetchCases(); //update case study list
            //this.resetErrors();
          } else {
            this.errors = res.errors;
          }
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },

    /**
     * @description add null default parameters to case study.
     * Sends request to Case parameters controller
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
    },

    /**
     * @description removes any selected user cases by making a delete request to caseController.
     * Sends request to the case controller
     */
    removeCases() {
      var curr = this;

      //confirmation dialogue box
      this.dialogue = bootbox.confirm({
        title: "Remove",
        message: "Do you want to remove selected case study(s)?",

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
            for (let i in curr.selected_cases) {
              curr.cases_to_remove.push({
                //push selected case study id's as cid attributes
                cid: curr.selected_cases[i]
              });
            }
            //send request
            fetch("/case/remove", {
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
              body: JSON.stringify(curr.cases_to_remove)
            })
              .then(res => res.json())
              .then(res => {
                console.log(res);

                curr.fetchCases(); //update case study list

                curr.cases_to_remove = []; //reset variable
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
    }
    /*#endregion*/
  }
};
</script>


<style lang="scss" scoped>
.circle {
  border-color: #3490dc;
  border-image: none;
  border-radius: 50% 50% 50% 50%;
  border-style: solid;
  border-width: 25px;
  max-width: 100%;
  //   height: 200px;
  //   width: 200px;
  overflow: hidden;
}
img {
  height: 100%;
  width: 100%;
}

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

/*pointer on headers*/
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
  transform: scale(1.3);
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
h1 i,
i {
  float: right;
  // margin: auto;
  // margin-top: 20px;
}
/* change icon background when hovered */
h1 i:hover,
h1 a:hover,
a:hover {
  color: #428bca;
}
/* icon initial color */
a,
h1 a {
  color: black;
}
/*move remove icon to right */
#update_icon {
  float: right;
  margin: auto;
  margin-top: 15px;
}

/*remove label font size, and margin in relation to icon*/
#update_icon i {
  margin-left: 10px;
}

/*remove label font size, and margin in relation to icon*/
#update_icon a {
  font-size: 20px;
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
  display: inline-block;

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
  margin-top: 25px;
  margin-left: 650px;
}
</style>
