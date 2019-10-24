<template>
  <transition>
    <div class="modal" id="add_member" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="input-group">
              <p>Search</p>
              <div class="input-group-append">
                <input type="text" placeholder="User email..">
              </div>
            </div>
            <div class="table-wrapper">
              <table id="group-table" class="table table-hover table-bordered" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th id="row-order">#</th>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Melvin</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Melvin</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.table-wrapper {
  font-size: 18px;
  max-height: 350px;
  overflow: auto;
}

table tr td {
  vertical-align: middle;
  padding-top: 18px;
  padding-bottom: 18px;
}

table body {
  max-height: 5px;
}

#row-order {
  width: 15%;
}

.modal-body p,
.modal-body input {
  font-size: 18px;
  display: inline-block;
margin: 5px;
}

.input-group{
margin-bottom: 10px;
}
.input-group-append input {
 border-radius:10px;
}

</style>
