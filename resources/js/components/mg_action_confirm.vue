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
          <div v-if="errors.length">
            <div>
              <label style="font-size:18px;">
                Please correct the following error(s):
                <ul style="margin:10px;">
                  <li v-for="(error,index) in errors" :key="index" style="margin:10px;">{{ error }}</li>
                </ul>
              </label>
            </div>
          </div>
          <div v-else-if="!isSelected">
            <p>Please select {{acted_on}} to {{action_confirm}}</p>
          </div>
          <div v-else-if="action_confirm=='Create'">
            <!-- alert content to confirm when user creates group/case  -->
            <p>{{action_confirm}}d {{acted_on}}</p>
          </div>
          <div v-else-if="action_confirm=='Add' ">
            <!-- alert content to confirm when user adds a member to a group -->
            <p>Added user(s) to group</p>
          </div>
          <div v-else-if="action_confirm=='Rename' ">
            <!-- alert content to confirm when user renames a group -->
            <p>Renamed group!</p>
          </div>
          <!-- Dialogue content when user selects a member to remove from group, or to delete a group/case -->
          <div v-else>
            <p>{{action_confirm}} selected {{acted_on}}?</p>
          </div>
        </div>

        <div class="modal-footer">
          <div
            v-if="action_confirm=='Add'||action_confirm=='Create' || action_confirm=='Rename' || !isSelected || errors.length"
          >
            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
          </div>
          <div v-if="action_confirm=='Remove' && isSelected">
            <div v-if="acted_on=='member(s)'">
              <!--Remove member action -->
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                @click="confirmRemoveMembers()"
              >Yes</button>
            </div>
            <div v-else-if=" acted_on=='group(s)'">
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                @click="confirmRemoveGroups()"
              >Yes</button>
            </div>
            <div v-else-if="acted_on=='case study(s)'">
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                @click="confirmRemoveCases()"
              >Yes</button>
            </div>
          </div>
          <div v-if="action_confirm=='Remove' && isSelected">
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
    acted_on: {
      type: String
    },
    message: {
      type: String
    },
    isSelected: {
      type: Boolean,
      default: true
    },
    errors: {
      type: Array,
      default: function() {
        return [];
      }
    }
  },
  methods: {
    confirmRemoveMembers() {
      this.$emit("sendUsers"); //call to mg_action_table(parent) to send users to group vue to remove.
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
