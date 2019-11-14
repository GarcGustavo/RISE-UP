<template>
  <!-- member group action confirmation -->
  <div
    class="modal fade"
    id="action_confirm_dbox"
    tabindex="-1"
    data-keyboard="false"
    data-backdrop="static"
    role="dialog"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- modal header -->
        <div class="modal-header">
          <h5 class="modal-title">{{action_confirm}}</h5>
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>-->
        </div>
        <!-- modal body -->
        <div class="modal-body text-center">
          <!-- if there are errors list them -->
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
          <!-- if no option was selected when adding/removing users from group or removing a case/group -->
          <div v-else-if="!is_selected">
            <!-- alert content for user to make selection  -->
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
        <!-- modal footer -->
        <div class="modal-footer">
          <!-- if action to execute is not remove, or if a selection has not been made or there are errors, render ok button only -->
          <div
            v-if="action_confirm=='Add'||action_confirm=='Create' || action_confirm=='Rename' || !is_selected || errors.length"
          >
            <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
          </div>
          <!-- if action is to remove and a case/group/user has been selected -->
          <div v-if="action_confirm=='Remove' && is_selected">
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
              <!-- Remove group action -->
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                @click="confirmRemoveGroups()"
              >Yes</button>
            </div>
            <div v-else-if="acted_on=='case study(s)'">
              <!-- Remove case study action -->
              <button
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                @click="confirmRemoveCases()"
              >Yes</button>
            </div>
          </div>
          <!-- if action is to remove and case/group/user has been selected -->
          <div v-if="action_confirm=='Remove' && is_selected">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/**
 * This is a dialogue box that serves the multipurpose of alerting,confirming, and throwing error warnings.btn-group
 * this is used for when a user creates/removes a case study or group, or when a user add/removes a member from a group
 */
export default {
  props: {
    action_confirm: {
      //action the user is executing
      type: String
    },
    acted_on: {
      //on what is the action being executed
      type: String
    },
    is_selected: {
      //user selection on cases, groups, or users
      type: Boolean,
      default: true
    },
    errors: {
      //if there are any errors when executing said action
      type: Array,
      default: function() {
        return [];
      }
    }
  },
  methods: {
    /**
     * @description call to parent(action_table_dbox) to send user(s) to group vue to remove.
     */
    confirmRemoveMembers() {
      this.$emit("sendUsers");
    },
    /**
     * @description call to parent (user_groups vue) to remove group(s)
     */
    confirmRemoveGroups() {
      this.$emit("removeGroups");
    },
    /**
     * @description call to parent (user_cases vue) to remove case(s)
     */
    confirmRemoveCases() {
      this.$emit("removeCases");
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
