<template>
  <div class="body mb-5 mt-5 border shadow" style="background: #c0c0c0;">
    <div class="container-fluid">
      <div class="row" style="margin: 50px;">
        <div class="col-md-12 border shadow" style="background: white;">
          <template v-if="case_to_show">
            <h1 class="text-center mt-3" v-for="(case_study,index) in case_to_show" :key="index">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control text-capitalize"
                  style="text-align: center;
                  font-weight: 500;
                  font-size: 2rem;"
                  v-model="case_study.c_title"
                  v-if="editing"
                  :maxlength="32"
                  @keydown="editingCase"
                />
              </div>
              <h1 class="text-capitalize" v-if="!editing">{{case_study.c_title}}</h1>
            </h1>
            <h5
              class="text-center mt-3"
              v-for="(user,index) in users"
              :key="index + 10"
            >Created by: {{user.first_name}} {{user.last_name}}</h5>
            <div v-if="!editing">
              <h5
                class="text-center mt-3"
                v-for="(group,index) in groups"
                :key="index + 20"
                style="margin-bottom: 50px;"
              >Group: {{group.g_name}}</h5>
            </div>
          </template>
          <div class="dropdown" style="text-align: center;" v-if="editing">
            <button
              v-for="(group,index) in groups"
              :key="index + 30"
              class="btn btn-primary dropdown-toggle"
              type="button"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black"
              id="dropdownMenuButton"
              data-toggle="dropdown"
            >Group: {{group.g_name}}</button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="drop">
              <option
                class="dropdown-item"
                href="#"
                v-for="(group, index) in this.all_groups.filter(group => group.g_owner == case_to_show[0].c_owner)"
                :key="index"
                v-on:click="onSelect(group.gid)"
              >{{index + 1}}: {{group.g_name}}</option>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="margin: 50px; background: white;">
        <!-- Case Parameters -->
        <div class="col-md-12">
          <h4 class="card-title border-0">Parameters</h4>
          <div class="row border" id="toc">
            <div
              class="col-sm-2 mx-auto-left"
              v-for="(case_parameter, index) in case_parameters"
              :key="index"
              style="margin: 50px;"
            >
              <div class="dropdown">
                <button
                  class="btn btn-primary dropdown-toggle"
                  type="button"
                  style="background: #c0c0c0; border-color: #c0c0c0; color: black"
                  id="dropdownMenuButton"
                  data-toggle="dropdown"
                >{{case_parameter.csp_name}}: Selection</button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a
                    class="dropdown-item"
                    href="#"
                    v-for="(option, sd) in filteredOptions(case_parameter.csp_id)"
                    :key="sd"
                  >{{sd + 1}}: {{option.o_content}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2" style="margin-left: 25px;">
          <!-- Table of Contents -->
          <h4 class="card text-center card-title" style="background: white;">Table of Contents</h4>
          <div class="row mt-2 card mb-5" id="toc">
            <div class="toc_list">
              <ul class="list-group list-group-flush border-0">
                <li class="list-group-item" v-for="(item, index) in items" :key="index">
                  <a href="#">{{index + 1}}: {{item.i_name}}</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-12 card" style="background: white;">
            <button
              class="btn btn-primary btn-sm mb-2"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black; margin: 10px"
              v-on:click="onEdit()"
              v-if="!this.editing"
            >Edit</button>
            <button
              class="btn btn-primary btn-sm mb-2"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black; margin: 10px"
              v-on:click="onCancel()"
              @keydown="editingCase"
              v-if="this.editing"
            >Cancel</button>
            <button
              class="btn btn-primary btn-sm mb-2"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black"
              v-on:click="addItem(new_item)"
              v-if="this.editing"
            >Add Item</button>
            <button
              class="btn btn-primary btn-sm mb-2"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black"
              v-on:click="onSubmit(items);"
              v-if="this.editing"
            >Submit Changes</button>
          </div>
        </div>
        <div class="col-md">
          <p class="col-sm-11 border shadow" style="background: white;" v-if="editing">
            Users currently editing this case study:
            <span
              class="badge"
              v-for="(user,uid) in usersEditing"
              :key="uid"
            >{{ user.first_name }} {{user.last_name}}</span>
          </p>
          <!-- Case Body -->
          <div class="row mt-2 card mb-5" id="items">
            <draggable
              v-model="items"
              animation="250"
              :options="{disabled: !editing}"
              @start="drag=true"
              @end="drag=false"
            >
              <div
                class="col-md"
                style="margin: 25px; margin-left: 0px;"
                v-for="(item,index) in items"
                :key="index"
              >
                <ul class="list-items" style="margin: 25px; margin-left: 0px;">
                  <div class="card h-100 text-left shadow">
                    <div class="card-body">
                      <h4 class="card-title" v-if="!editing">{{item.i_name }}</h4>
                      <button
                        class="btn btn-primary mb-3"
                        style="background: #c0c0c0; border-color: #c0c0c0; color: black"
                        v-on:click="removeItem(item)"
                        v-if="editing"
                      >Delete</button>
                      <div class="panel panel-default">
                        <div class="panel-body">
                          <div class="form-group">
                            <input
                              type="text"
                              class="form-control"
                              :maxlength="32"
                              v-model="item.i_name"
                              v-if="editing"
                              no-resize
                              @keydown="editingCase"
                            />
                          </div>
                          <div class="form-group">
                            <textarea
                              class="form-control"
                              rows="3"
                              min-height="50px"
                              v-model="item.i_content"
                              v-if="editing"
                              @keydown="editingCase"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                      <div
                        class="form-group text-break"
                        v-if="!editing"
                        style="white-space: pre-line;"
                      >{{item.i_content}}</div>
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
import draggable from "vuedraggable";
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
      usersEditing: [],
      items: [],
      all_items: [],
      case_parameters: [],
      parameter_options: [],
      ready: false,
      cid: "",
      initial_gid: "",
      gid: "",
      case_to_show: [],
      users: [],
      user: { uid: "", first_name: "", last_name: "" },
      groups: [],
      all_groups: [],
      group: { g_name: "", g_owner: "" },
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
      }
    };
  },
  created() {
    this.fetchItems();
    this.fetchCaseItems();
    this.fetchCase();
    this.fetchCaseParameters();
    this.fetchUsersEditing(this.cid);
  },

  mounted() {
    Echo.join(`App.User.${this.user.uid}`)
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
        this.case_study.c_title = e.title;
        this.items.i_content = e.body;
      })
      .listenForWhisper("saved", e => {
        this.case_study.c_status = e.status;

        // clear is status after 1s
        setTimeout(() => {
          this.case_study.c_status = "";
        }, 1000);
      });
  },
  methods: {
    editingCase() {
      let channel = Echo.join(`App.User.${this.user.uid}`);
      // show changes after 1s
      setTimeout(() => {
        channel.whisper("editing", {
          title: this.case_study.c_title,
          body: this.items.i_content
        });
      }, 1000);
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
          this.initial_gid = this.gid;
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
    fetchUserGroups() {
      fetch("/groups/")
        .then(res => res.json())
        .then(res => {
          this.all_groups = res.data;
          console.log(res.data);
        })
        .catch(err => console.log(res.data));
      //return this.all_groups.filter(group => group.g_owner == uid);
    },
    //TODO
    fetchUsersEditing(cid) {
      fetch("/user/edit/" + cid)
        .then(res => res.json())
        .then(res => {
          this.usersEditing = res.data;
        })
        .catch(err => console.log(err));
    },
    //TODO
    updateUsersEditing(user_editing_id) {
      if (this.editing) {
        this.updated_user_edit = {
          current_edit_cid: this.cid
        };
      }
      else{
        this.updated_user_edit = {
          current_edit_cid: "0"
        };
      }
      fetch("/user/" + user_editing_id + "/edit/", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(this.updated_user_edit)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
        })
        .catch(err => {
          console.error("Error: ", err);
        });
      this.fetchUsersEditing(this.cid);
    },
    fetchGroup(gid) {
      fetch("/case/group/" + this.gid)
        .then(res => res.json())
        .then(res => {
          this.groups = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchCaseParameters() {
      fetch("/parameters")
        .then(res => res.json())
        .then(res => {
          this.case_parameters = res.data;
          console.log(res.data);
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
    filteredOptions(parameter) {
      return this.parameter_options.filter(
        option => option.o_parameter == parameter
      );
    },
    //TODO
    updateCase() {
      this.cid = this.case_to_show[0].cid;
      this.updated_case = {
        cid: this.cid,
        c_title: this.case_to_show[0].c_title,
        c_description: this.case_to_show[0].c_description,
        c_thumbnail: this.case_to_show[0].c_thumbnail,
        c_status: this.case_to_show[0].c_status,
        c_date: this.case_to_show[0].c_date,
        c_owner: this.case_to_show[0].c_owner,
        c_group: this.case_to_show[0].c_group
      };
      fetch("/case/" + this.cid + "/update", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(this.updated_case)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
        })
        .catch(err => {
          console.error("Error: ", err);
        });
      this.fetchCase();
      this.fetchCaseParameters();
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
      if (confirm("Do you want to delete this item permanently?")) {
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
      }
      this.fetchCaseItems();
      this.fetchItems();
    },
    //TODO
    languageToggle() {},
    onEdit() {
      this.editing = true;
      this.fetchUserGroups();
      for (let user in this.users) {
        this.updateUsersEditing(this.users[user].uid);
      }
    },
    onCancel() {
      this.gid = this.initial_gid;
      this.fetchGroup(this.gid);
      this.fetchItems();
      this.fetchCaseItems();
      this.fetchCase();
      this.fetchCaseParameters();
      this.editing = false;
      for (let user in this.users) {
        this.updateUsersEditing(this.users[user].uid);
      }
    },
    onSubmit(items) {
      this.updateItems(items);
      this.updateCase();
      this.editing = false;
    },
    onSelect(selected_gid) {
      this.gid = selected_gid;
      this.case_to_show[0].c_group = this.gid;
      this.fetchGroup(this.gid);
    }
  }
};
</script>

<style lang="scss" scoped>
/* Set max height for content containers */
#items {
  max-height: 1000px;
  margin: 25px;
  margin-left: 0px;
  //overflow-x: auto;
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
