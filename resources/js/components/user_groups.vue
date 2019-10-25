<template>
  <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">
      <a href="#delete_member_confirm" data-toggle="modal" data-target="#delete_member_confirm">
        <i class="material-icons">remove_circle_outline</i>
      </a>
      <a href="#add_member" data-toggle="modal" data-target="#add_member">
        <i class="material-icons">add_circle_outline</i>
      </a>
      <add_member></add_member>
      <delete_member_confirm></delete_member_confirm>
      <p>My groups</p>
    </h1>

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
        <tr v-for="item in pageOfItems" :key="item.id">
          <td>
            <div class="check-box">
              <input class="checkbox" type="checkbox" id="'checkbox' item.id" v-model="checked">
              <label for="'checkbox' item.id">{{ item.id}}</label>
            </div>
          </td>
          <td>
            <a href="#">{{item.name}}</a>
          </td>
        </tr>
      </tbody>
    </table>
    <paginator :items="exampleItems" @changePage="onChangePage" class="pagination"></paginator>
  </div>
</template>

<script>
const exampleItems = [...Array(150).keys()].map(i => ({
  id: i + 1,
  name: "Name of group  " + (i + 1)
}));

export default {
  data() {
    return {
      exampleItems,
      pageOfItems: []
    };
  },
  methods: {
    onChangePage(pageOfItems) {
      // update page of items
      this.pageOfItems = pageOfItems;
    }
  }
};
</script>



<style lang="scss" scoped>
/* align table to center */
table {
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}

/* control column display format for and content size
*Block is display to make whole row selectable
*/
table tr td a {
  display: block;
  font-size: 18px;
}

/* This is for row content style and alignment */
td a {
  text-align: center;
  margin: auto;
  vertical-align: middle;
  color: black;
  text-decoration: none;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  padding-top: 20px;
  padding-bottom: 20px;
  max-width: 775px;
}

/* align vertically to center checkbox */
table tr td .check-box {
  padding-top: 20px;
}

/* checkbox column width */
#row-order {
  width: 15%;
}

/* check box and label styling */
input[type="checkbox"] + label {
  font-size: 18px;
  height: 18px;
  width: 18px;
  display: inline-block;
  padding: 0 0 0 0px;
}

/* change checkbox size */
input[type="checkbox"] {
  transform: scale(1.2);
}

/* paginate component position in body */
.pagination {
  float: right;
}

/* add/remove icons position in relation to header */
h1 i {
  float: right;
  margin: 10px;
  margin-top: 20px;
}

/* change icon background when hovered */
h1 i:hover {
  color: blue;
}

/* icon initial color */
a {
  color: black;
}
</style>
