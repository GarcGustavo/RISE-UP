<template>
  <div>
    <!--search bar -->
    <form action="/search" class="navbar-form ml-auto mr-auto pt-5 mt-2 mr-5 search">
      <div class="input-group mb-3">
        <input
          type="text"
          name="q"
          class="form-control"
          placeholder="search"
          aria-label="Search"
          aria-describedby="basic-addon2"
        >
        <div class="input-group-append">
          <button class="btn btn-light border-0 btn-sm" type="submit">
            <i class="material-icons">search</i>
          </button>
        </div>
      </div>
    </form>

    <!-- filters -->
    <div class="card" style>
      <div class="row mt-3 ml-4">
        <label for="group_select" style="padding-top:7px">Filters:</label>
        <div v-for="(case_parameter, index) in case_parameters" :key="index">
          <div class="col">
            <div class="form-group">
              <select
                class="form-control"
                v-model="selected_param[index]"
                @click="case_param=case_parameter.cid"
                :id="index"
              >
                <option selected="selected" disabled>{{case_parameter.csp_name}}</option>
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
    </div>

    <!-- case studies search -->
    <div class="card p-3 shadow">
      <div v-if="!empty">
        <div class="row mt-1 pt-2 pl-2" id="cases">
          <div class="col-lg-6 mb-4" v-for="case_study in filterCases" :key="case_study.cid">
            <div class="card h-100  text-center">
              <!-- <img src="..." class="card-img-top" alt="..."> -->
              <i class="material-icons pt-2" style="font-size: 125px">image</i>
              <div class="card-body">
                <h5 class="card-title">
                  <a
                    :href="'/case/body?cid='+case_study.cid"
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
      <div></div>
    </div>
  </div>
</template>

<script>
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
  /**
   * @description
   * @returns {any}
   */
  data() {
    return {
      selected_param: [],

      case_parameters: [],
      all_cases_parameters: [],
      parameter_options: [],
      selected_options_content: [],
      selected_options_id: [],
      list_cases: [],
      filtered_cases: [],

      empty: true
    };
  },
  /**
   * @description
   */
  created() {
    this.fetchParameters();
    this.fetchParameterOptions();
    this.fetchAllCasesParameters();
  },

  computed: {
    /**
     * @description filters cases by dropdown selection.
     * @returns list of cases in accordance to search.
     */
    /**
     * @description
     * @returns {any}
     */
    filterCases() {
      this.filtered_cases = [];

      this.temp = []; //temp var for case studies

      //look for case studies(cid) where selected option = selected param
      for (let j = 0; j < this.all_cases_parameters.length; j++) {
        for (let c = 0; c < this.case_parameters.length; c++) {
          if (
            this.all_cases_parameters[j].opt_selected == this.selected_param[c]
          ) {
            this.temp.push(this.all_cases_parameters[j]);
          }
        }
      }

      //filter those cid's from the list of case studies with parameters(list_cases)
      for (let i = 0; i < this.temp.length; i++) {
        for (let k = 0; k < this.list_cases.length; k++) {
          if (this.list_cases[k].cid == this.temp[i].cid) {
            this.filtered_cases.push(this.list_cases[k]);
          }
        }
      }
      //Eliminate duplicates
      this.filtered_cases = [...new Set(this.filtered_cases)];

      //if no case was found and a fitler has been selected
      if (!this.temp.length && this.selected_param.length) {
        return [];
      }
      //if no case was found and a filter hasn't been selected
      //This is when page loads and user has not made any changes
      //return search items
      if (!this.temp.length && !this.selected_param.length) {
        return this.list_cases;
      }
      return this.filtered_cases;
    }
  },

  methods: {
    /**
     * @description fetch all system parameters(filters)
     */
    fetchParameters() {
      fetch("/parameters")
        .then(res => res.json())
        .then(res => {
          this.case_parameters = res.data;

          if (this.cases) {
            this.list_cases = Object.values(this.cases);
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
      fetch("/parameter/options")
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
      fetch("/cs-parameters")
        .then(res => res.json())
        .then(res => {
          this.all_cases_parameters = res.data;
        })
        .catch(err => console.log(err));
    },
    /**
     * @description filterss the options in parameter_options with their corresponding parameter
     * @param {any} parameter system parameter
     * @returns {any} options for that parameter
     */
    filteredOptions(parameter) {
      return this.parameter_options.filter(
        option => option.o_parameter == parameter
      );
    },

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
</style>
