<template>
  <transition>
    <div class="modal" id="add_member_confirm" tabindex="-1" data-backdrop="static" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Add selected members?</p>
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
};
</script>

<style lang="scss" scoped>
p{
    font-size: 18px;
}
</style>
