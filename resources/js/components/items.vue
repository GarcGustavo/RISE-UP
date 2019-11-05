<template>
  <div id="app">
    <!-- Team Members -->
  <div class="body mb-5 mt-5">
    <h1 class="text-center">Our Group</h1>

    <!--
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item active">About</li>
    </ol>
    -->
    <hr>
    <h1 class="text-center mt-5">
      <a
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        @click="showModal=true, action='Remove',
        actor='member(s)'"
      >
        <i class="material-icons">remove_circle_outline</i>
      </a>
      <a
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        @click="showModal=true, action='Add',
        actor='member(s)'"
      >
        <i class="material-icons">add_circle_outline</i>
      </a>
      <mg_action_table v-if="showModal" @close="showModal = false" :action="action" :actor="actor"></mg_action_table>

      <p style="margin-left:90px;">Members</p>
    </h1>

    <div class="row mt-1 mb-5" id="members">
      <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">Team Member</h4>
            <h6 class="card-subtitle text-muted">Position</h6>
          </div>
          <div class="card-footer">
            <a href="#">name@example.com</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">Team Member</h4>
            <h6 class="card-subtitle text-muted">Position</h6>
          </div>
          <div class="card-footer">
            <a href="#">name@example.com</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">Team Member</h4>
            <h6 class="card-subtitle text-muted">Position</h6>
          </div>
          <div class="card-footer">
            <a href="#">name@example.com</a>
          </div>
        </div>
      </div>
    </div>

    <hr>
    <!-- Case view -->

    <h1 id="cases_header" class="mt-5 text-center">
      <a href="#">Create case study</a>
      <p style="margin-left:170px;">Our Cases</p>
    </h1>

    <div class="mt-1 card mb-5" id="cases">
      <div class="col-sm-12 mb-3">
        <ul class="list-group list-group-flush border-0">
          <li class="list-group-item">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import Editor from 'v-markdown-editor'
import draggable from 'vuedraggable'
import 'v-markdown-editor/dist/index.css';
Vue.use(Editor);
export default {
  name: 'app',
  components: {
  },
  data(){
      return {
        data:"Hi",
        ready: false,
        cid: [],
        items: []
    };
  },
  created() {
    //this.fetchCaseItems();
  },
  mounted(){
     
  },
  methods: {
      clickHandler(){
        this.text = 'You reseted tinymce\'s content';
      },
      fetchCaseItems() {
        this.path = window.location.pathname.split("/");
        this.i_case = this.path[this.path.length - 2];
        fetch("/case/"+ this.i_case + "/items")
          .then(res => res.text())
          .then(res => {
            this.items = res.text;
          })
          .catch(err => console.log(err));
      },
      updateItemOrder() {
        this.path = window.location.pathname.split("/");
        this.uid = this.path[this.path.length - 2];
        fetch("/case/"+ this.i_case + "/updateItems/")
          .then(res => res.text())
          .then(res => {
            this.groups = res.text;
            this.ready = true;
          })
          .catch(err => console.log(err));
    }
  }
  
}
</script>

<style lang="scss" scoped>
/* Set max height for content containers */
#cases,
#members {
  max-height: 450px;
  overflow-y: auto;
}

/* remove case cards borders */
li {
  border: none;
}

/* add/remove icons position in relation to header */
h1 i {
  float: right;
  margin: 10px;
}

/* change icon background when hovered */
h1 i:hover {
  color: blue;
}

/* icon initial color */
a {
  color: black;
}

/* position create case study button */
#cases_header a {
  float: right;
  font-size: 18px;
  margin-top: 10px;
}
</style>
