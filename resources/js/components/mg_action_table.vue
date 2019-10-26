<template>
  <transition>
    <div class="modal fade" id="mg_action_table" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{action}} {{actor}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="input-group" v-if="gname_box_show==true">
              <label>Group name</label>
              <div class="input-group-append name">
                <input type="text" placeholder="Name...">
              </div>
            </div>

            <div class="input-group">
              <label>Search</label>
              <div class="input-group-append search">
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
                data-target="#mg_action_confirm"
              >{{action}}</button>
            <mg_action_confirm :action_confirm="action" :actor="actor"></mg_action_confirm>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    action: {
      type: String
    },
    actor: {
      type: String
    },
    gname_box_show: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      showModal: false
    };
  },
  methods: {}
};
</script>

<style lang="scss" scoped>
/*set table's main attributes*/
.table-wrapper {
  font-size: 18px;
  overflow-y: auto;
  overflow-x: auto;
  width: 775px;
  height: 500px;
  white-space: nowrap;
}
/*table cell attrbites*/
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
/*set checkbock row's width*/
#row-checkbox {
  width: 15%;
}
/*the following style are for the search text and input bar*/
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
  border-radius: 3px;
}

.form-check-input {
  font-size: 20px;
}
/***********************************************************/

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
