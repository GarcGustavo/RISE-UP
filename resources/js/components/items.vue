<template>
  <div class="body mb-5 mt-5 border shadow" style="background: #c0c0c0;">
    <div class="container-fluid">
      <div class="row" style="margin: 50px;">
        <div class="col-md-12 col-md-offset-6 border shadow" style="background: white;">
          <template v-if="case_to_show">
            <h1
              class="text-center mt-3"
              style="text-align: center;"
              v-for="(case_study,index) in case_to_show"
              :key="index"
            >
              <input
                type="text"
                class="text-capitalize"
                style="text-align: center;
                  font-weight: 500;
                  font-size: 3rem;
                  max-width: 500px;"
                v-model="case_study.c_title"
                v-if="editing"
                :maxlength="32"
                @keydown="editingCase()"
              />
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
                style="margin-bottom: 30px;"
              >Group: {{group.g_name}}</h5>
            </div>
          </template>
          <div class="dropdown" style="text-align: center;" v-if="editing">
            <button
              v-for="(group,index) in groups"
              :key="index + 30"
              class="btn btn-primary dropdown-toggle"
              type="button"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black; margin-bottom: 30px; margin-top: 10px"
              id="dropdownMenuButton"
              data-toggle="dropdown"
            >Group: {{group.g_name}}</button>
            <div
              class="dropdown-menu scrollable-menu"
              aria-labelledby="dropdownMenuButton"
              id="drop"
              :key="this.independent"
            >
              <option
                class="dropdown-item"
                href="#"
                v-for="(group, index) in this.all_groups"
                :key="index"
                v-on:click="onSelectGroup(group.gid)"
              >{{index + 1}}: {{group.g_name}}</option>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="margin: 50px; background: white;">
        <!-- Case Description and Thumbnail -->
        <div class="col-md-8">
          <h4 class="card-title border-0" style="margin: 10px;">Description:</h4>
          <div class="card-body">
            <h5 v-for="(case_study,index) in case_to_show" :key="index">
              <textarea
                class="form-control"
                rows="3"
                min-height="50px"
                v-model="case_study.c_description"
                v-if="editing"
                :maxlength="320"
                @keydown="editingCase"
                @mouseover="typing = true"
                @mouseleave="typing = false"
              />
              <div class="form-group text-break" v-if="!editing">{{case_study.c_description}}</div>
            </h5>
          </div>
        </div>
        <div
          class="col-md-4.5 border shadow form-group text-break text-center"
          style="margin-top: 10px; margin-right: 10px;"
          v-for="(case_study,index) in case_to_show"
          :key="index"
        >
          <!-- Thumbnail -->
          <div :key="previewThumbnail">
            <input
              enctype="multipart/form-data"
              type="file"
              accept="image/*"
              v-if="editing"
              @change="uploadThumbnail($event)"
              id="file-input"
            />
            <img
              style="margin-top: 10px; max-width: 250px; max-height: 250px;"
              v-if="editing && !previewThumbnail"
              :src="'../images/' + case_study.c_thumbnail"
              onerror="this.onerror=null;this.src='../images/image_placeholder.jpg';"
            />
            <img
              style="margin-top: 10px; max-width: 250px; max-height: 250px;"
              v-if="editing && previewThumbnail"
              :src="thumbnail_preview"
              onerror="this.onerror=null;this.src='../images/image_placeholder.jpg';"
            />
          </div>
          <img
            style="margin-top: 10px; max-width: 250px; max-height: 250px;"
            v-if="!editing"
            :src="'../images/' + case_study.c_thumbnail"
            onerror="this.onerror=null;this.src='../images/image_placeholder.jpg';"
          />
        </div>
      </div>
      <div class="row" style="margin: 50px; background: white;">
        <!-- Case Parameters -->
        <div class="col-md-12">
          <h4 class="card-title border-0" style="margin: 10px;">Parameters:</h4>
          <div class="row border shadow" id="toc" v-if="!editing">
            <div
              class="col-md-2 mx-auto-left mb-1"
              v-for="(case_parameter, index) in case_parameters"
              :key="index"
              style="margin: 50px; margin-bottom: 20px; margin-top: 20px;"
            >
              <h5
                v-if="(case_parameter.csp_name != 'Incident date' || !case_to_show[0].c_incident_date)"
                class="btn btn-primary-disabled btn-block"
                style="background: #c0c0c0; border-color: #c0c0c0; color: black; width:250px"
              >{{case_parameter.csp_name}}: {{case_parameter.o_content}}</h5>
              <h5
                v-if="(case_parameter.csp_name == 'Incident date' && case_to_show[0].c_incident_date)"
                class="btn btn-primary-disabled btn-block"
                style="background: #c0c0c0; border-color: #c0c0c0; color: black; width:250px"
              >{{case_parameter.csp_name}}: {{case_to_show[0].c_incident_date}}</h5>
            </div>
          </div>
          <div class="row border" v-if="editing">
            <div
              class="col-md-2 mx-auto-left mb-1"
              v-for="(case_parameter, index) in case_parameters"
              :key="index"
              style="margin: 50px; margin-bottom: 30px; margin-top: 20px;"
            >
              <div v-if="(case_parameter.csp_name == 'Incident date')">
                <button
                  class="btn btn-primary"
                  type="button"
                  style="background: #c0c0c0; border-color: #c0c0c0; color: black; width:250px"
                >
                  {{case_parameter.csp_name}}:
                  <datepicker v-model="case_to_show[0].c_incident_date" :format="date_format"></datepicker>
                </button>
              </div>
              <div class="dropdown" v-if="(case_parameter.csp_name != 'Incident date')">
                <button
                  class="btn btn-primary dropdown-toggle"
                  type="button"
                  style="background: #c0c0c0; border-color: #c0c0c0; color: black; width:250px"
                  id="dropdownMenuButton"
                  data-toggle="dropdown"
                >{{case_parameter.csp_name}}: {{case_parameter.o_content}}</button>
                <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton">
                  <a
                    class="dropdown-item"
                    href="#"
                    v-for="(option, sd) in filteredOptions(case_parameter.csp_id)"
                    :key="sd"
                    v-on:click="onSelectOption(option, index)"
                    style="width:250px"
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
                  <a :href="'#item' + index">{{index + 1}}: {{item.i_name}}</a>
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
              v-on:click="addItem(new_item, 1)"
              v-if="this.editing"
            >Add Text Item</button>
            <button
              class="btn btn-primary btn-sm mb-2"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black"
              v-on:click="addItem(new_item, 2)"
              v-if="this.editing"
            >Add Image Item</button>
            <button
              class="btn btn-primary btn-sm mb-2"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black"
              v-on:click="onSubmit(items);"
              v-if="this.editing"
            >Submit Changes</button>
          </div>
          <div class="col-sm-12 card mt-5" style="background: white;" v-if="editing">
            <button
              class="btn btn-primary btn-xl mt-2 mb-2"
              style="background: #c0c0c0; border-color: #c0c0c0; color: black"
              v-on:click="deleteCaseStudy()"
            >Delete Case Study</button>
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
              :options="{disabled: (!editing || typing)}"
              @start="drag=true"
              @end="drag=false"
            >
              <div
                class="col-md"
                style="margin: 25px; margin-left: 0px;"
                v-for="(item,index) in items"
                :key="index"
                :id="'item' + index"
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
                              @mouseover="typing = true"
                              @mouseleave="typing = false"
                            />
                          </div>
                          <div class="form-group">
                            <textarea
                              class="form-control"
                              rows="3"
                              min-height="50px"
                              v-model="item.i_content"
                              v-if="editing && (item.i_type == 1)"
                              @keydown="editingCase"
                              @mouseover="typing = true"
                              @mouseleave="typing = false"
                            ></textarea>
                          </div>
                          <div>
                            <input
                              enctype="multipart/form-data"
                              type="file"
                              accept="image/*"
                              v-if="editing && (item.i_type == 2)"
                              @change="uploadImage($event, item, index)"
                              id="file-input"
                            />
                            <div :key="preview[index]">
                              <img
                                v-if="editing && (item.i_type == 2) && !preview[index]"
                                :src="'../images/' + item.i_content"
                                onerror="this.onerror=null;this.src='../images/image_placeholder.jpg';"
                              />
                              <img
                                v-if="editing && (item.i_type == 2) && preview[index]"
                                :src="images[index]"
                                onerror="this.onerror=null;this.src='../images/image_placeholder.jpg';"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div
                        class="form-group text-break"
                        v-if="!editing && (item.i_type == 1)"
                        style="white-space: pre-line;"
                      >{{item.i_content}}</div>
                      <div
                        class="form-group text-break text-center"
                        v-if="!editing && (item.i_type == 2)"
                      >
                        <img
                          :src="'../images/' + item.i_content"
                          onerror="this.onerror=null;this.src='../images/image_placeholder.jpg';"
                        />
                        {{item.i_content}}
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
import draggable from "vuedraggable";
import datepicker from "vuejs-datepicker";
export default {
  //name: 'app',
  components: {
    draggable,
    datepicker
  },
  events: {},
  data() {
    return {
      date_format: "yyyy-MM-dd",
      new_date: new Date(),
      editing: false,
      showModal: false,
      typing: false,
      action: "",
      actor: "",
      total_items: "",
      images: [],
      image_names: [],
      thumbnail_name: "",
      thumbnail_preview: "",
      thumbnail_files: [],
      independent: false,
      previewThumbnail: false,
      preview: [],
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
      selected_options_content: [],
      selected_options_id: [],
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
    this.preview[0] = false;
    this.fetchItems();
    this.fetchCaseItems();
    this.fetchCase();

    this.fetchCaseParameters();
    //this.fetchSelectedOptions(this.cid);
    this.fetchUsersEditing(this.cid);
    this.fetchUserGroups();
  },

  mounted() {
    Echo.join(`case.${this.case_to_show.cid}`).listenForWhisper(
      "editing",
      e => {
        this.case_to_show.c_title = e.title;
        this.items.forEach(element => {
          this.items[element] = e.items[element];
        });
        console.log("hell from channel");
      }
    );
    // .here(users => {
    //   this.usersEditing = users;
    // })
    // .joining(user => {
    //   this.usersEditing.push(users[0]);
    // })
    // .leaving(user => {
    //   this.usersEditing = this.usersEditing.filter(u => u != users[0]);
    // })
    // .listenForWhisper("saved", e => {
    //   //this.case_study.c_status = e.status;

    //   // clear is status after 1s
    //   setTimeout(() => {
    //     //this.case_study.c_status = "";
    //   }, 1000);
    // });
  },
  methods: {
    editingCase() {
      let channel = Echo.join(`case.${this.case_to_show.cid}`);

      console.log("hello from editing case");
      //show changes after 1s
      setTimeout(() => {
        channel.whisper("editing", {
          title: this.case_to_show.c_title,
          items: this.items
        });
      }, 1000);
    },
    fetchCaseItems() {
      this.path = new URLSearchParams(window.location.search); //get url parameters
      this.cid = Number(this.path.get("cid")); //get cid
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
      this.path = new URLSearchParams(window.location.search); //get url parameters
      this.cid = Number(this.path.get("cid")); //get cid
      fetch("/case?cid=" + this.cid)
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
      fetch("/user?uid=" + this.uid)
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchUserGroups() {
      fetch("/group/show?uid=" + this.case_to_show[0].c_owner)
        .then(res => res.json())
        .then(res => {
          this.all_groups = res.data;
          this.all_groups.unshift({
            gid: 0,
            g_name: "No Group",
            g_owner: null
          });
          console.log(res.data);
        })
        .catch(err => console.log(res.data));
    },
    fetchUsersEditing(cid) {
      fetch("/user/edit?cid=" + cid)
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
      } else {
        this.updated_user_edit = {
          current_edit_cid: "0"
        };
      }
      fetch("/user/edit?uid=" + user_editing_id, {
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
      if (this.gid != 0) {
        fetch("/case/group?gid=" + this.gid)
          .then(res => res.json())
          .then(res => {
            this.groups = res.data;
          })
          .catch(err => console.log(err));
      } else {
        this.independent = true;
        this.groups[0] = { g_name: "No Group", gid: 0 };
      }
    },
    fetchCaseParameters() {
      fetch("/case/parameters?cid=" + this.cid)
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
    updateParameter(updated_param) {
      this.updated_parameter = {
        cid: this.cid,
        csp_id: updated_param.csp_id,
        opt_selected: updated_param.opt_selected
      };
      fetch("/parameter/update", {
        method: "post",
        headers: new Headers({
          "Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        body: JSON.stringify(this.updated_parameter)
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
        })
        .catch(err => {
          console.error("Error: ", err);
        });
    },
    updateParams() {
      for (let param in this.case_parameters) {
        this.updated_param = this.case_parameters[param];
        this.updateParameter(this.updated_param);
      }
      //this.fetchCaseParameters();
    },
    updateCase() {
      this.cid = this.case_to_show[0].cid;

      var form_data = new FormData();
      if (this.thumbnail_files && this.thumbnail_preview) {
        form_data.append("image", this.thumbnail_name);
      }
      form_data.append("cid", this.cid);
      form_data.append("c_title", this.case_to_show[0].c_title);
      form_data.append("c_description", this.case_to_show[0].c_description);
      form_data.append("c_thumbnail", this.case_to_show[0].c_thumbnail);
      form_data.append("c_status", this.case_to_show[0].c_status);
      form_data.append("c_date", this.case_to_show[0].c_date);
      form_data.append("c_incident_date", this.new_date.toUTCString());
      console.log(this.new_date.toUTCString());
      form_data.append("c_owner", this.case_to_show[0].c_owner);
      form_data.append("c_group", this.case_to_show[0].c_group);

      fetch("/case/update", {
        method: "post",
        headers: new Headers({
          //"Content-Type": "application/json",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        //body: JSON.stringify(this.updated_case)
        body: form_data
      })
        .then(res => res.text())
        .then(text => {
          console.log(text);
        })
        .catch(err => {
          console.error("Error: ", err);
        });
      this.fetchCase();
    },
    updateItem(item_to_update, index) {
      this.path = new URLSearchParams(window.location.search); //get url parameters
      this.cid = Number(this.path.get("cid")); //get cid
      var form_data = new FormData();
      if (this.files && this.images[index]) {
        form_data.append("image", this.image_names[index]);
      }
      form_data.append("i_case", item_to_update.i_case);
      form_data.append("i_type", item_to_update.i_type);
      form_data.append("order", Number(item_to_update.order));
      form_data.append("i_name", item_to_update.i_name);
      form_data.append("i_content", item_to_update.i_content);
      //console.log(form_data.get('i_content'));
      fetch("/item/update?iid=" + item_to_update.iid, {
        method: "post",
        headers: new Headers({
          //"Content-Type": "multipart/form-data",
          "Access-Control-Origin": "*",
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }),
        //body: JSON.stringify(this.updated_item)
        body: form_data
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
        this.updateItem(this.items[item], item);
      }
      this.fetchItems();
      this.fetchCaseItems();
    },
    addItem(new_item, item_type) {
      this.path = new URLSearchParams(window.location.search); //get url parameters
      this.cid = Number(this.path.get("cid")); //get cid
      var item_name = "New Text";
      var item_content = "Add content here!";
      if (item_type == 2) {
        item_name = "New Image";
        item_content = "new_item.jpg";
      }
      this.new_item.iid = Number(this.all_items[this.all_items.length]) + 1;
      this.new_item.i_content = item_content;
      this.new_item.i_case = this.cid;
      this.new_item.i_type = item_type;
      this.new_item.order = "1";
      this.new_item.i_name = item_name;
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
        fetch("/item/remove?iid=" + Number(item_to_remove.iid), {
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
    deleteCaseStudy() {
      if (confirm("Do you want to delete this case study permanently?")) {
        //send request
        fetch("/case/remove", {
          method: "delete",
          headers: new Headers({
            "Content-Type": "application/json",
            "Access-Control-Origin": "*",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          }),
          body: JSON.stringify(this.case_to_show)
        })
          .then(res => res.text())
          .then(text => {
            console.log(text);
          })
          .catch(err => {
            console.error("Error: ", err);
          });
      }
    },
    //TODO
    languageToggle() {},
    onEdit() {
      this.editing = true;
      this.fetchUserGroups();

      for (let user in this.users) {
        this.updateUsersEditing(this.users[user].uid);
      }
      for (let option in this.case_parameters) {
        this.selected_options_content[option] = this.case_parameters[
          option
        ].o_content;
        this.selected_options_id[option] = this.case_parameters[
          option
        ].opt_selected;
      }
    },
    onCancel() {
      this.gid = this.initial_gid;
      this.editing = false;
      this.previewThumbnail = false;
      for (let index in this.preview) {
        this.preview[index] = false;
      }

      this.fetchGroup(this.gid);
      this.fetchItems();
      this.fetchCaseItems();
      this.fetchCase();
      this.fetchCaseParameters();
      this.fetchParameterOptions();

      for (let user in this.users) {
        this.updateUsersEditing(this.users[user].uid);
      }
      for (let option in this.selected_options_content) {
        this.case_parameters[option].o_content = this.selected_options_content[
          option
        ];
        this.case_parameters[option].opt_selected = this.selected_options_id[
          option
        ];
      }
    },
    onSubmit(items) {
      this.editing = false;
      for (let index in this.preview) {
        this.preview[index] = false;
      }
      this.previewThumbnail = false;
      this.new_date = this.case_to_show[0].c_incident_date;
      this.updateParams();
      this.updateItems(items);
      this.updateCase();

      //this.updateParameter();
    },
    onSelectGroup(selected_gid) {
      if (!selected_gid) {
        this.independent = true;
      } else {
        this.independent = false;
      }
      this.gid = selected_gid;
      this.case_to_show[0].c_group = this.gid;
      this.fetchGroup(this.gid);
    },
    onSelectOption(selected_op, index) {
      this.case_parameters[index].o_content = selected_op.o_content;
      this.case_parameters[index].opt_selected = selected_op.oid;
    },
    uploadImage(e, item, index) {
      //This reads an image from a data url stored in the item
      //var image = new Image();
      var reader = new FileReader();
      this.files = e.target.files || e.dataTransfer.files;

      reader.readAsDataURL(this.files[0]);
      reader.onload = e => {
        this.images[index] = e.target.result;
        this.image_names[index] = this.files[0];
        this.preview[index] = true;
      };
    },
    uploadThumbnail(e) {
      //This reads an image from a data url stored in the item
      //var image = new Image();
      var reader = new FileReader();
      this.thumbnail_files = e.target.files || e.dataTransfer.files;
      //this.files = e.target.files || e.dataTransfer.files;

      reader.readAsDataURL(this.thumbnail_files[0]);
      reader.onload = e => {
        this.thumbnail_preview = e.target.result;
        this.thumbnail_name = this.thumbnail_files[0];
        this.previewThumbnail = true;
      };
    }
  }
};
</script>

<style lang="scss" scoped>
.scrollable-menu {
  height: auto;
  max-height: 200px;
  overflow-x: hidden;
}
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
//image display
img {
  width: 50%;
  margin: auto;
  display: block;
  margin-bottom: 10px;
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
