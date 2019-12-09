<template>
  <div class="container-fluid mt-auto">
    <div id="search_bar" class="row mb-3 justify-content-center">
      <h1>Look for case studies within IReN</h1>
    </div>
    <!-- Search -->
    <div class="row mb-3 justify-content-center">
      <form id="search_form" action="/search">
        <div class="input-group search">
          <input type="hidden" :value="csrfToken" name="_token" />
          <input type="hidden" :value="uid" name="uid" />
          <input
            type="text"
            name="q"
            class="form-control"
            placeholder="Search for damages types, natural disasters, incedent location, case study author... "
            aria-label="Search"
            aria-describedby="basic-addon2"
          />
          <div class="input-group-append">
            <button class="btn btn-primary border-0 btn-sm" type="submit">
              <i class="material-icons">search</i>
            </button>
          </div>
        </div>
      </form>
    </div>
    <hr id="search_form_hr" />
    <div class="row mb-3 justify-content-center">
      <!-- case studies search -->
        <h4>Recent case studies...</h4>
        <div class="card mt-3 p-3 w-100 h-100 text-center shadow">
          <div v-if="!empty">
            <div
              class="row mt-1 pt-2 pl-2"
              v-for="case_study in list_most_recent_cases"
              :key="case_study.cid"
              id="cases"
            >
              <div class="card text-center">
                <!-- <i class="material-icons pt-2" style="font-size: 125px">image</i> -->
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
          <div v-else>
            <p class="text-center p-5">No case studies found. Please try again!</p>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      urlParams: null,
      csrfToken: null,
      uid: "", //user id
      confirm_message: "", //confirmation messages from other functionalities that redirect to home
      list_most_recent_cases: [], //contains 10 most recent case study
      most_recent_cases_parameters: [], //contains case study parameters
      empty: true, //if search is empty present "No case studies found "
      now: new Date().getTime()
    };
  },
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    this.urlParams = new URLSearchParams(window.location.search);
    this.uid = this.urlParams.get("uid");
    //this.confirm_message = this.urlParams.get("message");
    this.checkConfirmations();
    this.mostRecentCS();
  },

  methods: {

    /**
     * @description fetch the parameters all case studies have correspondingly
     */
    checkConfirmations() {
        console.log('aqui');
      if (this.confirm_message != "") {
        this.confirmationBox();
      }
    },

    /**
     * @description fetch the parameters all case studies have correspondingly
     */
    confirmationBox() {
      //alert box
      this.dialogue = bootbox.alert({
        title: "Confirmation Message",
        message: this.confirm_message,
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

    /**
     * @description fetch the parameters all case studies have correspondingly
     */
    mostRecentCS() {
        console.log('aqui');
      fetch("/case/recents?uid=" + this.uid + "&qty=10")
        .then(res => res.json())
        .then(res => {
            console.log(res);
          //this.all_cases_parameters = res.data;
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style lang="scss" scoped>
.card .card-body {
  padding-left: 20px;
  padding-right: 20px;
}

#search_form {
  width: 70%;
}

#search_form_hr {
  width: 80%;
}

#search_bar {
  margin-top: 15%;
}
.search input[type="text"] {
  width: 50%;
}
</style>
