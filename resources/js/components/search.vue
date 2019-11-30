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
              <select class="form-control" id="group_select">
                <option hidden>{{case_parameter.csp_name}}</option>
                <option
                  v-for="option in filteredOptions(case_parameter.csp_id)"
                  :key="option.oid"
                >{{option.o_content}}</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- case studies search -->
    <div class="card shadow">
      <div v-if="!empty">
        <div class="row mt-1 pt-2 pl-4" id="cases">
          <div class="col-lg-6 mb-4" v-for="case_study in cases" :key="case_study.cid">
            <div class="card h-100 text-center">
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
      <div v-else> <p class="text-center p-5">No case studies found. Please try again! </p></div>
      <div></div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    cases: {
      type: [Object,Number,Array]
    }
  },
  data() {
    return {
      def: 1,
      case_parameters: [],
      all_cases_parameters:[],
      parameter_options: [],
      selected_options_content: [],
      selected_options_id: [],

      empty:true
    };
  },
  created() {
    this.fetchParameters();
    this.fetchParameterOptions();
  },
  methods: {
    fetchParameters() {
      fetch("/parameters")
        .then(res => res.json())
        .then(res => {
          this.case_parameters = res.data;
          console.log(res.data);
          if(this.cases){
              this.empty=false;
          }
        })
        .catch(err => console.log(err));
      this.fetchParameterOptions();
    },
    fetchParameterOptions() {
      fetch("/parameter/options")
        .then(res => res.json())
        .then(res => {
          this.parameter_options = res.data;
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
fetchAllCasesParameters(){
 fetch("/cs-parameters")
        .then(res => res.json())
        .then(res => {
          this.all_cases_parameters = res.data;
          console.log(res.data);
        })
        .catch(err => console.log(err));
},
    filteredOptions(parameter) {
      return this.parameter_options.filter(
        option => option.o_parameter == parameter
      );
    },

    onSelectOption(selected_op, index) {
      this.case_parameters[index].o_content = selected_op.o_content;
      this.case_parameters[index].opt_selected = selected_op.oid;
    }
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
