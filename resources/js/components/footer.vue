<template>
  <!-- Footer -->
  <footer class="page-footer">
    <div style="background-color: #333333;">
      <div class="text-center text-md-left">
        <!-- Grid row -->
        <div class="row">
          <!-- Grid column -->
          <div class="col-7 mt-md-0 mt-3 justify-content-md-start" id="Acknowledgment">
            <!-- Content -->
            <img src="../../../public/images/nsf_logo.jpg" />
            <h5 class="text-uppercase text-white">Acknowledgment</h5>
            <p class="text-white font-weight-light">
              This material is based upon work supported by the National Science Foundation under grants
              No. HSI #1832468 and 1832427 (HSI program).
            </p>
          </div>
          <!-- Grid column -->

          <div class="col-5 mt-md-0 mt-3 justify-content-md-start" id="Disclaimer">
            <!-- Content -->
            <h5 class="text-uppercase text-white">Disclaimer</h5>
            <p class="text-white font-weight-light">
              Any opinions, findings, and conclusions or recommendations expressed in this material are
              those of the authors and do not necessarily reflect the views of the National Science Foundation.
            </p>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
      <!-- Footer Links -->
    </div>
  </footer>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.page-footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  background-color: #333333;
  top: 100%;
}

/* change links text color */
a:link {
  color: white;
}

/* Footer padding */
.container-fluid {
  //padding-top: 30px;
  padding-bottom: 50px;
}

/* padding for content, and links text */
.text-white {
  padding-right: 55px;
}

/* font weight for links options */
ul {
  font-weight: 300;
}

/*attributes for nsf logo and footer content display */
#Acknowledgment img {
  float: left;
  margin-right: 15px;
}

#Acknowledgment h5 {
  margin-left: 15px;
  padding-top: 15px;
}

#Disclaimer h5 {
  padding-top: 15px;
}
/*************************************************/
</style>
