<template>
  <transition> <!-- member group action confirmation -->
    <div class="modal" id="mg_action_confirm" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <div v-if="action_confirm=='Create'"> <!-- dialogue content to confirm when user creates group dialogue -->
              <p>{{action_confirm}} {{actor}}?</p>
            </div>
            <div v-else> <!-- Dialogue content when user selects a member to add/remove from group or to delete a group -->
              <p>{{action_confirm}} selected {{actor}}?</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Yes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    action_confirm: {
      type: String
    },
    actor: {
      type: String
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
