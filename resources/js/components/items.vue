<template>
  <!-- Team Members -->

  <div class="body mb-5 mt-5">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <template v-if="case_to_show">
            <h1 class="text-center mt-3" v-for="(case_study,index) in case_to_show" :key="index">
              <h1 class="text-capitalize">{{case_study.c_title}}</h1>
            </h1>
            <h5
              class="text-center mt-3"
              v-for="(user,index) in users"
              :key="index + 10"
            >Created by: {{user.first_name}} {{user.last_name}}</h5>
            <h5
              class="text-center mt-3"
              v-for="(group,index) in groups"
              :key="index + 20"
            >Group: {{group.g_name}}</h5>
          </template>
        </div>
      </div>
      <div class="row" style="margin-top: 50px;">
        <div class="col-md-2.5">
          <!-- Table of Contents -->
          <h4 class="card-title">Table of Contents</h4>
          <div class="row mt-2 card mb-5"  id="toc">
            <div class="toc_list">
              <ul class="list-group list-group-flush border-0">
                <li class="list-group-item" v-for="(item, index) in items" :key="index">
                  <a href="#">{{index + 1}}: {{item.i_name}}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9" >
          <h4 class="card-title" style="margin-left: 50px;">Parameters</h4>
          <div class="row border" style="margin-left: 50px;" id="toc">
            <div
              class="col-sm-1 mx-auto-left"
              v-for="(item, index) in items"
              :key="index"
              style="margin: 50px;"
            >
              <div class="dropdown">
                <button
                  class="btn btn-primary dropdown-toggle"
                  type="button"
                  id="dropdownMenuButton"
                  data-toggle="dropdown"
                >Action</button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a
                    class="dropdown-item"
                    href="#"
                    v-for="(item, sd) in items"
                    :key="sd"
                  >Action {{sd + 1}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 mb-1">
          <button v-on:click="addItem(new_item)">Add Item</button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- Case Body -->
          <div class="row mt-2 card mb-5" id="items">
            <draggable
              v-model="items"
              animation="250"
              group="members"
              @start="drag=true"
              @end="drag=false"
            >
              <div class="col-sm-12 mb-3" v-for="(item,index) in items" :key="index">
                <ul class="list-items">
                  <div class="card h-100 text-left shadow">
                    <div class="card-body">
                      <h4 class="card-title">
                        {{item.i_name }}
                        <button v-on:click="removeItem(item)">Delete</button>
                      </h4>
                      <p class="card-text">{{item.i_content}}</p>
                    </div>
                  </div>
                </ul>
              </div>
            </draggable>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Editor from "v-markdown-editor";
import draggable from "vuedraggable";
import "v-markdown-editor/dist/index.css";
//Vue.use(Editor);
export default {
  //name: 'app',
  components: {
    draggable
  },

  events: {},
  data() {
    return {
      showModal: false,
      action: "",
      actor: "",
      total_items: "",
      case_study: {
        cid: "",
        c_title: "",
        c_description: "",
        c_thumbnail: "",
        c_status: "",
        c_date: "",
        c_owner: "",
        c_group: ""
      },
      users: [],
      items: [],
      all_items: [],
      ready: false,
      cid: "",
      gid: "",
      case_to_show: [],
      users: [],
      user: { uid: "", first_name: "", last_name: "" },
      groups: [],
      group: { g_name: "" },
      uid: "",
      item: {
        iid: "",
        i_content: "",
        i_case: "",
        i_type: "",
        order: "",
        i_name: ""
      },
      new_item: {
        iid: "",
        i_content: "",
        i_case: "",
        i_type: "",
        order: "",
        i_name: ""
      },
      case_parameters: []
    };
  },
  created() {
    this.fetchItems();
    this.fetchCaseItems();
    this.fetchCase();
  },
  methods: {
    fetchCaseItems() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 2]);
      fetch("/case/"+this.cid+"/items")
        .then(res => res.json())
        .then(res => {
          this.items = res.data;
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
    fetchItems() {
      fetch("/items")
        .then(res => res.json())
        .then(res => {
          this.all_items = res.data;
          this.total_items = this.all_items.length;
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
    fetchCase() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 2]);
      fetch("/case/"+this.cid)
        .then(res => res.json())
        .then(res => {
          this.case_to_show = res.data;
          this.uid = Number(this.case_to_show[0].c_owner);
          this.gid = Number(this.case_to_show[0].c_group);
          this.fetchUser(this.uid);
          this.fetchGroup(this.gid);
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
    fetchUser(uid) {
      fetch("/user/"+this.uid)
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchGroup(gid) {
      fetch("/case/group/"+this.gid)
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
        })
        .catch(err => console.log(err));
    },
    updateItemOrder() {
      this.path = window.location.pathname.split("/");
      this.uid = this.path[this.path.length - 2];
      fetch("/case/" + this.i_case + "/updateItems/")
        .then(res => res.text())
        .then(res => {
          //this.groups = res.text;
          this.ready = true;
        })
        .catch(err => console.log(err));
    },
    updateItems() {
      this.path = window.location.pathname.split("/");
      this.uid = this.path[this.path.length - 2];
      fetch("/case/" + this.i_case + "/updateItems/")
        .then(res => res.text())
        .then(res => {
          //this.groups = res.text;
          this.ready = true;
        })
        .catch(err => console.log(err));
    },
    addItem(new_item) {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 2]);
      this.new_item.iid = this.total_items + 1;
      this.new_item.i_content = "dfsad";
      this.new_item.i_case = this.cid;
      this.new_item.i_type = "1";
      this.new_item.order = "1";
      this.new_item.i_name = "New Item";
      console.log(new_item);
      fetch("/item/add", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(new_item)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
          this.fetchCaseItems();
        })
        .catch(err => {
          console.error("Error: ", err);
        });
      this.fetchItems();
      this.fetchCaseItems();

      //Reset item container data
      this.new_item = {
        iid: "",
        i_content: "",
        i_case: "",
        i_type: "",
        order: "",
        i_name: ""
      };
    },
    removeItem(item_to_remove) {
      console.log(item_to_remove.iid);
      fetch("/item/"+Number(item_to_remove.iid)+"/remove", {
        method: "delete",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(item_to_remove)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
        })
        .catch(err => {
          console.error("Error: ", err);
        });
      this.fetchCaseItems();
      this.fetchItems();
    },
    fetchCaseParameters() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 1]);
      fetch("/case/" + this.cid + "/items")
        .then(res => res.json())
        .then(res => {
          this.items = res.data;
        })
        .catch(err => console.log(err));
    },
    updateCaseParameters() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 1]);
      fetch("/case/" + this.cid + "/items")
        .then(res => res.json())
        .then(res => {
          this.items = res.data;
        })
        .catch(err => console.log(err));
    },
    languageToggle() {},
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
    }
  }
};
</script>

<style lang="scss" scoped>

/* Set max height for content containers */
#items {
  //max-height: 475px;
  overflow-y: auto;
}
#toc {
  max-height: 475px;
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
#toc_container {
  background: #f9f9f9 none repeat scroll 0 0;
  border: 1px solid #aaa;
  display: table;
  font-size: 95%;
  margin-bottom: 1em;
  padding: 20px;
  width: auto;
}

.mt-0 {
  margin-top: 100px;
  padding: 10px;
  text-align: left;
}

.toc_title {
  font-weight: 700;
  text-align: center;
}

#toc_container li,
#toc_container ul,
#toc_container ul li {
  list-style: outside none none !important;
}
</style>
