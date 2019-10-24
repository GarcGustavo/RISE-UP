<template>
  <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">My groups</h1>

    <hr>

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
            <a href="#">{{item.id}}</a>
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
  name: "Name of group " + (i + 1)
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
  },

};
</script>



<style lang="scss" scoped>
table {
  margin-left: auto;
  margin-right: auto;
  width: 85%;
}

table td {
  text-align: center;

}

td a {
  display: block;
  color: black;
  text-decoration: none;
  padding-top: 20px;
  padding-bottom: 20px;
  width: 100%;
}

#row-order {
  width: 15%;
}

.pagination {
  float: right;
}
</style>
