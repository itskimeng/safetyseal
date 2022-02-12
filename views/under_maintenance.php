<div class="container" style="padding-top: 5%; padding-bottom: 1%;">
  <img src="frontend/images/banner_calabarzon.png" height="10%" width="100%" alt="">
</div>

<div class="registration-image">
  <div class="container">
    
    <div class="pt-5">
   
      <div class="row align-items-center heading">

          <div class="col-md-6">
            <div class="form-box shadow p-3 mb-5 bg-body rounded">
              <div id="countdown-gampang"></div>

            </div>
          </div>
          <div class="col-md-6">
            <div class="form-box shadow p-3 mb-5 bg-body rounded">
              <h1>We&rsquo;ll be back soon!</h1>
              <div>
                  <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. If you need to you can always contact us, otherwise we&rsquo;ll be back online shortly!</p>
                  <p>&mdash; DILG IV-A</p>
              </div>
            </div>
          </div>

      </div>
      <!-- <div class="row"> -->
    </div>
  </div>
</div>
<script>

  var finish_d = new Date();
  finish_d.setDate(finish_d.getDate() + 50);

  $('#countdown-gampang').countdownGampang({
    rampung: finish_d
  })


</script>
<style>
</style>