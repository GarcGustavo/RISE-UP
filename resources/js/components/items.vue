<template>
  <!-- Team Members -->

  <div class="body mb-5 mt-5 border">
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
          <div class="row mt-2 card mb-5" id="toc">
            <div class="toc_list">
              <ul class="list-group list-group-flush border-0">
                <li class="list-group-item" v-for="(item, index) in items" :key="index">
                  <a href="#">{{index + 1}}: {{item.i_name}}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9">
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
          <button v-on:click="onEdit()" v-if="!this.editing">Edit</button>
          <button v-on:click="addItem(new_item)" v-if="this.editing">Add Item</button>
          <button v-on:click="onSubmit(items)" v-if="this.editing">Submit Changes</button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <!-- Case Body -->
          <div class="row mt-2 card mb-5" id="items">
            <draggable
              v-model="items"
              animation="250"
              group="items"
              :options="{disabled: !editing}"
              @start="drag=true"
              @end="drag=false"
            >
              <div class="col-sm-12 mb-3" v-for="(item,index) in items" :key="index">
                <ul class="list-items">
                  <div class="card h-100 text-left shadow">
                    <div class="card-body">
                      <h4 class="card-title" v-if="!editing">
                        {{item.i_name }}
                      </h4>
                      <button class="col-sm-2 mb-3 right" v-on:click="removeItem(item)" v-if="editing">Delete</button>
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <div class="form-group" >
                            <input
                              type="text"
                              class="form-control"
                              v-model="item.i_name"
                              v-if="editing"
                              @keydown="editingCase"
                            />
                          </div>
                          <div class="form-group">
                            <textarea
                              class="form-control"
                              rows="10"
                              v-model="item.i_content"
                              v-if="editing"
                              @keydown="editingCase"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-control">
                        <p class="card-text">{{item.i_content}}</p>
                      </div>
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
      editing: false,
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

  mounted() {
    /*Echo.join(`note.${this.note.slug}`)
      .here(users => {
        this.usersEditing = users;
      })
      .joining(user => {
        this.usersEditing.push(user);
      })
      .leaving(user => {
        this.usersEditing = this.usersEditing.filter(u => u != user);
      })
      .listenForWhisper("editing", e => {
        this.title = e.title;
        this.body = e.body;
      })
      .listenForWhisper("saved", e => {
        this.status = e.status;

        // clear is status after 1s
        setTimeout(() => {
          this.status = "";
        }, 1000);
      });*/
  },
  methods: {
    editingCase() {
      /*let channel = Echo.join(`note.${this.note.slug}`);

      // show changes after 1s
      setTimeout(() => {
        channel.whisper("editing", {
          title: this.title,
          body: this.body
        });
      }, 1000);*/
    },
    fetchCaseItems() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 2]);
      fetch("/case/" + this.cid + "/items")
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
          this.total_items = this.all_items.length + 1;
          console.log(res.data);
        })
        .catch(err => console.log(err));
    },
    fetchCase() {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 2]);
      fetch("/case/" + this.cid)
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
      fetch("/user/" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchGroup(gid) {
      fetch("/case/group/" + this.gid)
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
        })
        .catch(err => console.log(err));
    },
    updateItem(item_to_update) {
      this.path = window.location.pathname.split("/");
      this.cid = this.path[this.path.length - 2];
      this.updated_item = {
        iid: Number(item_to_update.iid),
        i_content: item_to_update.i_content,
        i_case: item_to_update.i_case,
        i_type: item_to_update.i_type,
        order: Number(item_to_update.order),
        i_name: item_to_update.i_name
      };
      fetch("/item/" + item_to_update.iid + "/update", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(this.updated_item)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },
    updateItems(items) {
      for (let item in this.items) {
        this.items[item].order = item;
        this.updateItem(this.items[item]);
      }
      this.fetchItems();
      this.fetchCaseItems();
    },
    addItem(new_item) {
      this.path = window.location.pathname.split("/");
      this.cid = Number(this.path[this.path.length - 2]);
      this.new_item.iid = Number(this.all_items[this.all_items.length]) + 1;
      this.new_item.i_content = "Add content here!";
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
      fetch("/item/" + Number(item_to_remove.iid) + "/remove", {
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
      this.editing = true;
    },
    onSubmit(items) {
      this.updateItems(items);
      this.editing = false;
    },
    onCancel() {
      this.editing = false;
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
