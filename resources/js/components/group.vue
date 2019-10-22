<template>
  <!-- Team Members -->
  <div class="body mb-5 mt-5">
    <h1 class="text-center">Our Group</h1>

    <!--
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item active">About</li>
    </ol>
    -->
    <hr>

    <div class="row mt-1 mb-5" id="members">
      <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">Team Member</h4>
            <h6 class="card-subtitle text-muted">Position</h6>
          </div>
          <div class="card-footer">
            <a href="#">name@example.com</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">Team Member</h4>
            <h6 class="card-subtitle text-muted">Position</h6>
          </div>
          <div class="card-footer">
            <a href="#">name@example.com</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center shadow">
          <i class="material-icons pt-2" style="font-size: 125px">person</i>
          <div class="card-body">
            <h4 class="card-title">Team Member</h4>
            <h6 class="card-subtitle text-muted">Position</h6>
          </div>
          <div class="card-footer">
            <a href="#">name@example.com</a>
          </div>
        </div>
      </div>
    </div>

    <hr>
    <!-- Case view -->

    <h1 class="mt-5 text-center">Our Cases</h1>

    <div class="card mb-5" id="cases">
      <div class="col-sm-12 mb-3">
        <ul class="list-group list-group-flush border-0">
          <li class="list-group-item" style="border:none;">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item" style="border:none;">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item" style="border:none;">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item" style="border:none;">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item" style="border:none;">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
          <li class="list-group-item" style="border:none;">
            <div class="card-body">
              <h5 class="card-title">
                <a href="#">Card One</a>
              </h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some text.</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
#cases,
#members {
  max-height: 450px;
  overflow-y: auto;
}
</style>
