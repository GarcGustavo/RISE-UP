<template>
  <!-- Footer -->
  <footer class="page-footer">
    <div style="background-color: #333333;">
      <div class="container">
        <div class="container-fluid text-center text-md-left">
          <!-- Grid row -->
          <div class="row">
            <!-- Grid column -->
            <div class="col-md-6 mt-md-0 mt-3">
              <!-- Content -->
              <h5 class="text-uppercase text-white" style="width:235px;">Footer Content</h5>
              <p class="text-white font-weight-light">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum
                consectetur
                similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit
                voluptatem
                perferendis dicta dolorem non blanditiis ex fugiat.
              </p>
            </div>
            <!-- Grid column -->

            <hr class="clearfix w-100 d-md-none pb-3">

            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">
              <!-- Links -->
              <h5 class="text-uppercase text-white" style="width:50px;">Links</h5>

              <ul class="list-unstyled">
                <li>
                  <a href="#!">Link</a>
                </li>
                <li>
                  <a href="#!">Link 2</a>
                </li>
                <li>
                  <a href="#!">Link 3</a>
                </li>
                <li>
                  <a href="#!">Link 4</a>
                </li>
              </ul>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">
              <!-- Links -->
              <h5 class="text-uppercase text-white" style="width:50px;">Links</h5>

              <ul class="list-unstyled">
                <li>
                  <a href="#!">Link 1</a>
                </li>
                <li>
                  <a href="#!">Link 2</a>
                </li>
                <li>
                  <a href="#!">Link 3</a>
                </li>
                <li>
                  <a href="#!">Link 4</a>
                </li>
              </ul>
            </div>
            <!-- Grid column -->
          </div>
          <!-- Grid row -->
        </div>
        <!-- Footer Links -->
      </div>
    </div>
  </footer>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.page-footer {
  bottom: 0;
  width: 100%;
  background-color: #333333;
  margin-top: auto;
}

/* change links text color */
a:link {
  color: white;
}

/* Footer padding */
.container-fluid {
  padding-top: 30px;
  padding-bottom: 100px;
}

/* padding for content, and links text */
.text-white {
  padding-right: 55px;
}

/* font weight for links options */
ul {
  font-weight: 300;
}

/* underline for footer title text */
h5 {
  border-bottom: 2px solid white;
}
</style>
