<template>
  <div id="app">
          <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">
      <a
        href="#mg_action_confirm"
        data-toggle="modal"
        data-target="#mg_action_confirm"
        @click="action='Remove',
        actor='group(s)'"
      >
        <i class="material-icons">remove_circle_outline</i>
      </a>
      <a
        href="#mg_action_table"
        data-toggle="modal"
        data-target="#mg_action_table"
        @click="gname_box_show=true,
        action='Create',
        actor='group', fetchUsers()"
      >
        <i class="material-icons">add_circle_outline</i>
      </a>

      <div v-if="action=='Remove'">
        <!-- if action is to remove group, render confirm box upfront; this is so there's no display issues with action_table since it also renders a confirm box -->
        <mg_action_confirm :action_confirm="action" :actor="actor"></mg_action_confirm>
      </div>

      <mg_action_table
        :action="action"
        :actor="actor"
        :gname_box_show="gname_box_show"
        :users="users"
      ></mg_action_table>

      <p>My groups</p>
    </h1>
    <div class ="col-md-4 col-md-offset-2">
       <article class="card" v-for="item in items" :key="item.iid" :data-id="item.iid">
                        <header>
                            {{ item.i_content }}
                        </header>
                        <markdown-editor 
                          toolbar="" 
                          :v-model="data" 
                          :options="options">
                        </markdown-editor>
        </article>
    </div>


    <hr>
    <!-- Table -->
    <table id="group-table" class="table table-hover table-bordered table-sm" cellspacing="0">
      <thead class="thead-dark">
        <tr>
          <th id="row-order">#</th>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(group,index) in pageOfGroups" :key="index">
          <td>
            <div class="check-box">
              <input class="checkbox" type="checkbox" id="'checkbox' + index" v-model="checked">
              <label for="'checkbox' + index">{{index+1}}</label>
            </div>
          </td>
          <td>
            <a :href="'/group/' + group.gid">{{group.g_name}}</a>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-if="ready">
      <paginator :items="groups" @changePage="onChangePage" class="pagination"></paginator>
    </div>
  </div>
  </div>

  
</template>

<script>
import Editor from 'v-markdown-editor'
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
    this.fetchCaseItems();
  },
  mounted(){
     
  },
  methods: {
      clickHandler(){
          this.text = 'You reseted tinymce\'s content';
      },
      fetchCaseItems() {
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
<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>