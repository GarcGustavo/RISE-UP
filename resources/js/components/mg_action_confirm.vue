<template>
  <!-- member group action confirmation -->
  <div
    class="modal fade"
    id="mg_action_confirm"
    tabindex="-1"
    data-keyboard="false"
    data-backdrop="static"
    role="dialog"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <div v-if="action_confirm=='Create'">
            <!-- alert content to confirm when user creates group  -->
            <p>{{action_confirm}}d {{actor}}</p>
          </div>
          <div v-else-if="action_confirm=='Add'">
            <!-- alert content to confirm when user adds a member to a group -->
            <p>Added user(s) to group</p>
          </div>
          <!-- Dialogue content when user selects a member to remove from group or to delete a group -->
          <div v-else>
            <p>{{action_confirm}} selected {{actor}}?</p>
          </div>
        </div>

        <div class="modal-footer">
          <div v-if="action_confirm=='Add'||action_confirm=='Create'">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
          </div>
          <div v-else-if="action_confirm=='Remove' && actor=='member(s)'">
            <!--Remove member action -->
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="confirmRemoveMembers()"
            >Yes</button>
          </div>
          <div v-else-if="action_confirm=='Remove' && actor=='group(s)'">
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="confirmRemoveGroups()"
            >Yes</button>
          </div>
          <div v-else-if="action_confirm=='Remove' && actor=='case study(s)'">
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="confirmRemoveCases()"
            >Yes</button>
          </div>
          <div >
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    action_confirm: {
      type: String
    },
    actor: {
      type: String
    },
    message: {
      type: String
    }
  },
  methods: {
    confirmRemoveMembers() {
      this.$emit("sendUsers"); //call to mg_action_table(parent) to send users to group vue.
    },
    confirmRemoveGroups() {
      this.$emit("removeGroups"); //call to parent (user_groups vue)
    },
    confirmRemoveCases() {
      this.$emit("removeCases"); //call to parent (user_cases vue)
    }
  }
};
</script>

<style lang="scss" scoped>
p {
  padding-top: 30px;
  padding-bottom: 15px;
  font-size: 18px;
}
</style>
