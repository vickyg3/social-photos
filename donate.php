<!DOCTYPE html>
<html lang="en">
  <?php include('head.html'); ?>
  <body>
    <?php include('header.html'); ?>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit" style="height: 40px;">
        <span id="placeholderHeader">Donate</span>
      </div>
      <br/>

      <div class="row-fluid">
        <div class="span10">
            <p>Though most of this project was done on my free time, it still required a lot of time and effort to come
            up with such a usable piece of software. Also, hosting it on these servers don't pay for themselves.</p>
            <p>So, I'd be more than happy if you can Donate for the cause of this project. I don't receive many donations,
            and I'd be happy if the donations can pay for the cost of hosting the servers. Please feel free to donate any
            amount you wish to, if you feel Social Photos has helped make your digital photos life easier. You can donate as little a $1
            by clicking on the button below.</p>
            <center>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_donations">
            <input type="hidden" name="business" value="vigneshv.0408@gmail.com">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="item_name" value="Social Photos">
            <input type="hidden" name="no_note" value="0">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
            </center>
        </div>
      </div>

      <hr>
      <?php include('footer.html'); ?>

    </div> <!-- /container -->

    <!-- Le javascript -->
    <script src="static/bootstrap/js/jquery.js"></script>
    <script src="static/bootstrap/js/bootstrap.js"></script>

  </body>
</html>
