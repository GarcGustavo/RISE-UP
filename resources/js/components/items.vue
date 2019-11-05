<template>
  <div id="app">
    <!-- Team Members -->
    <div class="body mb-5 mt-5">
      <h1 class="text-center">{{case_title}}</h1>
      <hr>
      <h1 class="text-center mt-5">
        <a
          href="#mg_action_table"
          data-toggle="modal"
          data-target="#mg_action_table"
          data-dismiss="modal"
          @click="showModal=true, action='Remove',
          actor='member(s)', fetchMembers()"
        >
          <i class="material-icons">remove_circle_outline</i>
        </a>
        <a
          href="#mg_action_table"
          data-toggle="modal"
          data-target="#mg_action_table"
          data-dismiss="modal"
          @click="showModal=true, action='Add',
          actor='member(s)', fetchUsers()"
        >
          <i class="material-icons">add_circle_outline</i>
        </a>

        <mg_action_table
          v-if="showModal"
          @close="showModal = false"
          :action="action"
          :actor="actor"
          :users="users"
          @addUsers="addUsers"
          @removeUsers="removeUsers"
        ></mg_action_table>
      </h1>
      <!-- Case view -->

      <h1 id="cases_header" class="mt-5 text-center">
        <a href="#">Edit</a>
      </h1>

      <div class="mt-1 card mb-5" id="cases">
        <div class="col-sm-12 mb-3">
          <ul class="list-group list-group-flush border-0">
            <li class="list-group-item" v-for="item in items" :key="item.iid">
              <div class="card-body">
                <h5 class="card-title">
                  <a href="#">{{item.i_name}}</a>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">{{item.i_order}}</h6>
                <p class="card-text">{{item.i_content}}</p>
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
        showModal: false,
        action: "",
        actor: "",
        case_title: "",
        users:[],
        items:[],
        ready: false,
        cid: "",
        case_to_show: [],
        //item: { iid: "", i_content:"", order:"", i_name: "" },
        case_parameters: []
    };
  },
  created() {
    this.fetchCaseItems();
    this.fetchCase();
  },
  methods: {
    fetchCaseItems() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 1]);
      fetch("/case/"+ this.cid+ "/items")
        .then(res => res.json())
        .then(res => {
          this.items = res.data;
        })
      .catch(err => console.log(err));
    },
    fetchCase() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 1]);
      fetch("/case/"+ this.cid)
        .then(res => res.json())
        .then(res => {
          this.case_to_show = res.data;
          this.case_title = this.case_to_show[0].c_title;
          this.ready = true;
        })
      .catch(err => console.log(err));
      console.log(this.case_to_show);
    },
    updateItemOrder() {
        this.path = window.location.pathname.split("/");
        this.uid = this.path[this.path.length - 2];
        fetch("/case/"+ this.i_case + "/updateItems/")
          .then(res => res.text())
          .then(res => {
            //this.groups = res.text;
            this.ready = true;
          })
          .catch(err => console.log(err));
    },
    addItem(users_to_add) {
        console.log((users_to_add));
        fetch("/group/members/add", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body:(JSON.stringify(users_to_add))
        })
        .then(res => res.text())
        .then(text => {
          console.log(text);
          this.fetchMembers();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },
    removeItem(users_to_remove) {
     console.log(JSON.stringify(users_to_remove));
      fetch("/group/members/remove", {
        method: "delete",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(users_to_remove)
      })
        .then(res => res.json())
        .then(data => {
        console.log(data);
        this.fetchMembers();
      })
      .catch(err => {
        console.error("Error: ", err);
      });
    },
    fetchCaseParameters() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 1]);
      fetch("/case/"+ this.cid+ "/items")
        .then(res => res.json())
        .then(res => {
          this.items = res.data;
        })
      .catch(err => console.log(err));
    },
    updateCaseParameters() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 1]);
      fetch("/case/"+ this.cid+ "/items")
        .then(res => res.json())
        .then(res => {
          this.items = res.data;
        })
      .catch(err => console.log(err));
    },
    onClick() {
      // update page of Casess
      this.pageOfCases = pageOfCases;
    },
    onEdit() {
      this.cids = [];

      for (let i in this.cids) {
        this.cids.push(this.cids[i].cid);
      }
    },
    onSubmit() {
      this.cids = [];

      for (let i in this.cids) {
        this.cids.push(this.cids[i].cid);
      }
    },
    draggable() {
      this.cids = [];

      for (let i in this.cids) {
        this.cids.push(this.cids[i].cid);
      }
    },

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
