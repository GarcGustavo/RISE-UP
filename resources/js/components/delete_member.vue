<template>
  <transition>
    <div class="modal fade" id="delete_member" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Delete member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="input-group">
              <label>Search</label>
              <div class="input-group-append">
                <input type="text" placeholder="User email..">
              </div>
            </div>
            <div class="table-wrapper">
              <table id="group-table" class="table table-hover table-bordered" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th id="row-checkbox">#</th>
                    <th>Email</th>
                    <th>Name</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="check-box">
                        <input class="checkbox" type="checkbox" id="'checkbox1" v-model="checked">
                        <label for="'checkbox1">1</label>
                      </div>
                    </td>
                    <td>Melvinmalave95@gmail.com</td>
                    <td>Melvin Jesus Malave Sanchez</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              data-toggle="modal"
              data-target="#delete_member_confirm"
            >Delete</button>
            <delete_member_confirm></delete_member_confirm>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      showModal: false
    };
  }
};
</script>

<style lang="scss" scoped>
.table-wrapper {
  font-size: 18px;
  overflow-y: auto;
  overflow-x: auto;
  width: 775px;
  height: 500px;
  white-space: nowrap;
}

table tr td {
  text-align: center;
  vertical-align: middle;
  padding-top: 18px;
  padding-bottom: 18px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  max-width: 386px;
}

#row-checkbox {
  width: 15%;
}

.modal-body label,
.modal-body input {
  font-size: 18px;
  display: inline-block;
  margin: 5px;
}

.input-group {
  margin-bottom: 10px;
}

.input-group-append input {
  border-radius: 10px;
}

.form-check-input {
  font-size: 20px;
}


.modal {
  background: rgba(85, 85, 85, 0.5);
}

input[type="checkbox"] + label {
  font-size: 18px;
  height: 18px;
  width: 18px;
  display: inline-block;
  padding: 0 0 0 0px;
}

input[type="checkbox"] {
  transform: scale(1.2);
}
</style>
