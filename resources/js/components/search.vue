<template>
  <div class="container-fluid mt-5">
    <!--search bar -->
    <div class="col pt-5">
      <div class="row justify-content-center pt-3">
        <div id="search_input" class="row w-50 mb-1">
          <div class="input-group mb-3">
            <input type="hidden" :value="csrfToken" name="_token">
            <input
              type="text"
              name="q"
              class="form-control"
              placeholder="search"
              aria-label="Search"
              aria-describedby="basic-addon2"
            >
            <div class="input-group-append">
              <button class="btn btn-primary border-0 btn-sm" @click="search_input()" type="submit">
                <i class="material-icons">search</i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- filters -->
    <div class="row">
      <div class="col-3 mt-5 pt-1 ">
        <div id="filter-container" class="col card pb-2 mb-3">
          <h5 for="group_select" class="text-center pt-2 m-auto">Filters:</h5>
          <hr>
          <div class="row justify-content-center" v-for="(case_parameter, index) in case_parameters" :key="index">
            <div class="form-group w-75">
              <label class="text-center text-break pl-2">{{case_parameter.csp_name}}</label>
              <div class="p-2 " v-if="(case_parameter.csp_name == 'Incident date')">
                <div class="card ">
                  <label class="pl-2 pt-2">From:</label>
                  <datepicker
                    id="datepicker"
                    class="text-center "
                    v-model="incident_date_start"
                    :use-utc="true"
                    :disabled-dates="state.disabledDates"
                    :format="date_format"
                  ></datepicker>
                  <label class="pl-2">To:</label>
                  <datepicker
                    id="datepicker"
                    class="text-center pb-3"
                    v-model="incident_date_end"
                    :use-utc="true"
                    :disabled-dates="state.disabledDates"
                    :format="date_format"
                  ></datepicker>
                  <div
                    v-if="(incident_date_start && incident_date_end) && incident_date_start > incident_date_end || incident_date_end > now"
                    class="m-auto text-break"
                    style="white-space: pre-line;max-width: 200px"
                  >
                   <p  class="text-center"> Invalid date range:
                    Starting date must be equal to or lower than end date.</p>
                  </div>
                </div>
              </div>
              <div id="Frame" class="pl-2">
                <select
                  v-if="case_parameter.csp_name != 'Incident date'"
                  class="form-control"
                  v-model="selected_options[index]"
                  @change="selected(case_parameter.csp_id), filterCases()"
                  :id="case_parameter.csp_id"
                >
                  <!--  <option selected="selected" disabled>{{case_parameter.csp_name}}</option>-->
                  <!--  <option selected disabled hidden  value></option> -->
                  <option label="None">None</option>
                  <option
                    v-for="option in filteredOptions(case_parameter.csp_id)"
                    :key="option.oid"
                    :value="option.oid"
                  >{{option.o_content}}</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row p-1">
          <div class="col text-center">
            <button class="btn btn-primary w-100" type="button" @click="clearFilter()">Clear</button>
          </div>
        </div>
      </div>

      <!-- case studies search -->
      <div class="col">
        <h4 class="mt-5">Search results for: {{search_for}}</h4>
        <div class="card p-3 w-100 shadow" style="margin-top:20px;">
          <div v-if="!empty">
            <div class="row mt-1 pt-2 pl-2" id="cases">
              <div class="col-4 mb-4" v-for="case_study in search" :key="case_study.cid">
                <div class="card h-100 text-center">
                  <img
                    :src="'../images/'+ case_study.c_thumbnail"
                    style="height:150px;width:125px; margin-top:20px; margin-left:200px"
                    onerror="this.onerror=null;this.src='../images/image_placeholder.jpg';"
                    class="card-img-top m-auto pt-2"
                    alt="..."
                  >
                  <!-- <i class="material-icons pt-2" style="font-size: 125px">image</i> -->
                  <div class="card-body">
                    <h5 class="card-title">
                      <a
                        :href="'/case/body?cid='+case_study.cid+'&uid='+uid"
                        class="stretched-link"
                      >{{case_study.c_title}}</a>
                    </h5>
                    <p class="card-text" style="overflow-y:auto">{{case_study.c_description}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p class="text-center p-5">No case studies found. Please try again!</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import datepicker from "vuejs-datepicker";
import { isNumber } from "util";
/**
 * write a component's description
 */
export default {
  props: {
    cases: {
      type: [Object, Number, Array],
      /**
       * @description
       * @returns {any}
       */
      default: function() {
        return [];
      }
    }
  },
  components: {
    datepicker
  },
  /**
   * @description
   * @returns {any}
   */
  data() {
    return {
      csrfToken: null,
      uid: "", //user id
      date_format: "yyyy-MM-dd", //date formatting for datepicker
      incident_date_start: "", //range for datepicker
      incident_date_end: "", //range for datepicker
      search_for: "", //contains the string the user is searching for
      selected_param: "", //id of selected/changed parameter,

      selected_options: [], //contains id's of the selected options of all parameters
      case_parameters: [], //contains all registered parameters
      all_cases_parameters: [] /*contains entries of Case_Parameters table - holds
                                relation of case studies with their corresponding parameters options selections*/,
      parameter_options: [], //contains all options for parameters
      list_cases: [], //contains search results
      filtered_cases: [], //Filter cases
      search: [], //variable used in for loop to present searched study cases

      state: {
        disabledDates: {
          from: new Date() // Disable all dates after specific date
        }
      },

      empty: true, //if search is empty present "No case studies found "

      now: new Date().getTime()
    };
  },
  /**
   * @description
   */
  created() {
    this.getUser();

    this.getSearch();
    this.fetchParameters();
    this.fetchParameterOptions();
    this.fetchAllCasesParameters();
    // this.filterCases();
  },

  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },

  watch: {
    incident_date_start: function() {
      this.filterCases();
    },
    incident_date_end: function() {
      this.filterCases();
    }
  },

  methods: {
    /*#region Auxilary methods - These methods provide operational
functionalities to to the web page. Operations include:
Setting user priveleges, editing title, and resetting variables*/

    getUser() {
      this.urlParams = new URLSearchParams(window.location.search); //get url parameters
      this.uid = Number(this.urlParams.get("uid")); //get user id
    },
    /**
     * @description filters cases by dropdown and date selection.
     * @returns list of cases in accordance to search.
     */
    filterCases() {
      this.filtered_cases = [];

      //create new array of selected options to manipulate data set without changing original array
      this.selected_options_temp = this.selected_options.slice();

      //Selected_option None equals to "" or none, convert to Null so it matches values on database
      for (let a = 0; a < this.selected_options.length; a++) {
        if (
          this.selected_options[a] == "" ||
          this.selected_options[a] == "None"
        ) {
          this.selected_options_temp[a] = null;
        }
      }
      //selected_option returns empty values on none selected filters
      //Remove undefined empty values
      this.data = this.selected_options_temp.filter(function(element) {
        return element !== undefined;
      });

      this.selected_options_filtered = this.data;

      //These for loops get the case studies on which one or more parameters apply individually
      //That is if user selects to filter by location and damage type, the algorithm will
      //fetch all case studies with either one or both of the parameter's selected option. The list
      // will contain duplicate id's, these repetetive id's is the key idea to the algorithm. The amount
      //of duplicate id's will equal to the amount of applicable selected parameters.
      this.case_studies_with_selected_option = []; //temp var for case studies
      //look for case studies(cid) where selected option = selected param
      for (let j = 0; j < this.all_cases_parameters.length; j++) {
        for (let c = 0; c < this.selected_options_filtered.length; c++) {
          if (
            this.all_cases_parameters[j].opt_selected ==
              this.selected_options_filtered[c] &&
            this.selected_param == this.all_cases_parameters[j].csp_id
          ) {
            this.case_studies_with_selected_option.push(
              this.all_cases_parameters[j]
            );
          }
        }
      }

      //get count of selected parameters
      this.count = 0;

      this.selected_options_filtered.forEach(element => {
        if (!element || isNumber(element)) {
          this.count = this.count + 1;
        }
      });

      /*change array to elements that contain only the id's of the case studies*/
      this.ids = [];

      this.case_studies_with_selected_option.forEach(element => {
        this.ids.push(element.cid);
      });
      this.case_studies_with_selected_option = this.ids;
      /************************* */

      //get count of id's
      this.temp = {};
      var vm = this;
      this.case_studies_with_selected_option.forEach(function(i) {
        vm.temp[i] = (vm.temp[i] || 0) + 1;
      });
      this.case_study_with_id_count = [];
      //create array containing count of each case study id
      for (let i in this.temp) {
        this.case_study_with_id_count.push({
          cid: i,
          count: this.temp[i]
        });
      }

      //filter those cid's from the list of case studies with parameters(list_cases)
      for (let i = 0; i < this.case_study_with_id_count.length; i++) {
        for (let k = 0; k < this.list_cases.length; k++) {
          //if the count of case study id equals to those of selected parameters
          // if case id is in case study search list(list_cases) and append to filtered list
          if (
            this.case_study_with_id_count[i].count == this.count &&
            this.list_cases[k].cid == this.case_study_with_id_count[i].cid
          ) {
            this.filtered_cases.push(this.list_cases[k]);
          }
        }
      }
      //Eliminate duplicates
      this.filtered_cases = [...new Set(this.filtered_cases)];

      //if no case was found and a filter has been selected
      if (
        !this.case_studies_with_selected_option.length &&
        this.selected_options_filtered.length
      ) {
        //return [];
        this.search = [];
        this.empty = true;
      }
      //if no case was found and a filter hasn't been selected
      //This is when page loads and user has not made any filter/parameter changes(excluding dates)
      //return search items

      if (
        !this.case_studies_with_selected_option.length &&
        !this.selected_options_filtered.length
      ) {
        //verify date selection
        //added disabled dates to date picker not needed. Kept for additional robustness
        if (
          this.incident_date_start > this.incident_date_end ||
          this.incident_date_end > this.now
        ) {
          this.empty = true;
          return;
        }
        //filter if dates have been selected
        this.list_cases_temp = this.filterDate(
          this.incident_date_start,
          this.incident_date_end,
          this.list_cases
        );

        this.search = this.list_cases_temp; // false - update variable
        if (!this.search.length) {
          this.empty = true;
        } else {
          this.empty = false;
        }
        //apply vuejs reactivity
        this.$nextTick(function() {
          this.search = this.list_cases_temp; // true - update variable
        });
        this.$nextTick(function() {
          this.search = this.list_cases_temp; // true - render to DOM
        });
        return;
      } //
      //filter if dates have been selected
      this.filtered_cases = this.filterDate(
        this.incident_date_start,
        this.incident_date_end,
        this.filtered_cases
      );

      this.search = this.filtered_cases;

      if (!this.search.length) {
        this.empty = true;
      } else {
        this.empty = false;
      }

      //return this.filtered_cases;
    },

    /**
     * @description get text of what the user is searching for
     */
    getSearch() {
      this.urlParams = new URLSearchParams(window.location.search); //get url parameters
      this.search_for = this.urlParams.get("q"); //get search
    },

    /**
     * @description get selected case parameter
     */
    selected(id) {
      this.selected_param = id;
    },

    /**
     * @description clear all filters
     */
    clearFilter() {
      // this.clear = false;
      this.empty = false;
      this.parameters = document.getElementsByTagName("select");
      this.incident_date_start = "";
      this.incident_date_end = "";
      this.selected_options = [];
      this.search = this.list_cases;
      this.$nextTick(function() {
        this.empty = false;
        this.search = this.list_cases; // true

        for (let i = 0; i < this.parameters.length; i++) {
          this.parameters[i].selectedIndex = -1;
        }
      });
    },

    /**
     * @description filters the options in parameter_options with their corresponding parameter
     * @param {any} parameter system parameter
     * @returns {any} options for that parameter
     */
    filteredOptions(parameter) {
      return this.parameter_options.filter(
        option => option.o_parameter == parameter
      );
    },
    /**
     * @description formats dates into an array for data manipulation
     * @returns array of formated dates
     */
    formatDate(date) {
      if (date) {
        return date.toISOString().slice(0, 10);
      }
    },
    /**
     * @description compares date range to incident date of cases in list
     * @returns array of filtered cases by date
     */
    filterDate(date_start, date_end, cases_list) {
      var filtered_list = [];

      if (date_start && date_end) {
        cases_list.forEach(element => {
          if (
            this.formatDate(date_start) <= element.c_incident_date &&
            this.formatDate(date_end) >= element.c_incident_date
          ) {
            filtered_list.push(element);
          }
        });
        return filtered_list;
      }
      return cases_list;
    },

    /**
     * @description calls controller route*/
    search_input() {
      document.location.href =
        "/search?uid=" +
        this.uid +
        "&q=" +
        document.getElementsByName("q")[0].value;
    },

    /*//#endregion*/

    /*#region Query methods - These methods provide the content of
the web page by requesting the data through route calls. The routes
passes the request to a specified predefined controller who processes
said request via Laravel's eloquent ORM. The data is appended to the
global variables as needed to be used.*/
    /**
     * @description fetch all system parameters(filters)
     */
    fetchParameters() {
      fetch("/parameters?uid=" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.case_parameters = res.data;

          if (this.cases) {
            this.list_cases = Object.values(this.cases);
            this.search = this.list_cases;
            this.empty = false;
          }
        })
        .catch(err => console.log(err));
      this.fetchParameterOptions();
    },
    /**
     * @description fetch all parameters options
     */
    fetchParameterOptions() {
      fetch("/parameter/options?=uid" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.parameter_options = res.data;
        })
        .catch(err => console.log(err));
    },
    /**
     * @description fetch the parameters all case studies have correspondingly
     */
    fetchAllCasesParameters() {
      fetch("/cs-parameters?uid=" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.all_cases_parameters = res.data;
        })
        .catch(err => console.log(err));
    }
    /*#endregion*/
  }
};
</script>

<style lang="scss" scoped>
#cases {
  min-height: 200px;
  max-height: 610px;
  overflow-y: auto;
}
a {
  color: black;
}
#filter-container {
  max-height: 640px;
  overflow-y: auto;
}
</style>
