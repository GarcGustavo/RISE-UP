<template>
  <!--member group action table
        this table is used everytime a user wants to remove
         members of an existing group or to add an existing
         user to a new group
  -->
  <transition>
    <div>
      <div
        class="modal fade"
        id="case_create_dbox"
        tabindex="-1"
        data-keyboard="false"
        data-backdrop="static"
        role="dialog"
      >
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{action}} {{actor}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- Render group name input element to dialogue box when user creates group -->
            <div class="modal-body">
              <label>Title</label>
              <div class="input-group-append">
                <input type="text" placeholder="Name...">
              </div>

              <!-- group selection for table -->
              <div class="form-group">
                <label for="exampleFormControlSelect2">Assign to a group(optional)</label>
                <select multiple class="form-control" id="exampleFormControlSelect2">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                  <option>6</option>
                  <option>7</option>
                </select>
              </div>
              <!-- case description -->
              <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  class="form-control"
                  id="description"
                  maxlength = "255"
                  v-model="message"
                  v-on:keyup="countdown"
                ></textarea>
              </div>
              <p
                class="text-right h6"
                v-bind:class="{'text-danger': hasError }"
              >{{remainingCount}}</p>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#mg_action_confirm"
              >{{action}}</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!--confirmation dialogue box -->
      <div>
        <mg_action_confirm :action_confirm="action" :actor="actor"></mg_action_confirm>
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
    }
  },

  data() {
    return {
      showModal: false,
      maxCount: 255,
      remainingCount: 255,
      message: "",
      hasError: false
    };
  },

  methods: {
    countdown: function() {
      this.remainingCount = this.maxCount - this.message.length;
      this.hasError = this.remainingCount < 0;
    }
  }
};
</script>

<style lang="scss" scoped>
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

.form-control {
  height: 30px;
}

/***********************************************************/

textarea {
  width: 100%;
  min-height: 150px;
  resize: none;
}

.modal {
  background: rgba(85, 85, 85, 0.5);
}
</style>
