<template>
  <div class="body mb-5 mt-5">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">My groups</h1>

    <hr>

    <table
      id="dtBasicExample"
      class="table table-hover table-bordered table-sm w-75"
      cellspacing="0"
    >
      <thead class="thead-dark">
        <tr>
          <th class="col-1 th-sm">#</th>
          <th class="th-sm">Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in pageOfItems" :key="item.id">
          <td>{{item.id}}</td>
          <td>{{item.name}}</td>
        </tr>
      </tbody>
    </table>
    <paginator :items="exampleItems" @changePage="onChangePage" class="pagination"></paginator>
  </div>
</template>

<script>
const exampleItems = [...Array(150).keys()].map(i => ({
  id: i + 1,
  name: "Item " + (i + 1)
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
table {
  margin-left: auto;
  margin-right: auto;
}

table td {
  text-align: center;
  padding-top: 10px;
  padding-bottom: 10px;
}

.pagination {
  float: right;
  border:none;
}
</style>
