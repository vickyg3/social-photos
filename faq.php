<!DOCTYPE html>
<html lang="en">
  <?php include('head.html'); ?>
  <body>
    <?php include('header.html'); ?>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit" style="height: 40px;">
        <span id="placeholderHeader">Frequently Asked Questions</span>
      </div>
      <br/>

      <div class="row-fluid">
        <div class="span10">
            <p>
              <dl>
                <dt>
                  <b>
                    Why did you make Social Photos?
                  </b>
                </dt>
                <dd>
                  I was one of those people annoyed by having the digital photos on various network without an easy way to
                  organize them. Also, when I wanted to share the same album to multiple social networks, it was usually a pain.
                  Social Photos was developed to scratch my own itch (like many other wonderful pieces of software).
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Is my data safe when I use Social Photos?
                  </b>
                </dt>
                <dd>
                  Yes, absolutely! We do not store any information about you on our servers. You can check out the 
                  <a href="privacy.php" target="_blank">privacy policy</a> for more details (this isn't the usual yada yada, it has clear concise points).
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Can you see/store my passwords?
                  </b>
                </dt>
                <dd>
                  No. Your password never comes to our server. The app uses a protocol known as <a href="http://en.wikipedia.org/wiki/OAuth" target="_blank">OAuth</a>,
                  which enables secure authentication for access of user data without exposing the actual account's passwords.
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Flickr doesn't have the concept of Albums. Yet Social Photos lists Flickr albums. What are they?
                  </b>
                </dt>
                <dd>
                  Your Flickr Sets (photosets) appear as Albums. When you create an album in Flickr, you are essentially creating a Set.
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Where is this hosted? How do you pay for it?
                  </b>
                </dt>
                <dd>
                  The servers are hosted in <a href="http://linode.com" target="_blank">linode</a>. It doesn't cost much to host them for now.
                  But it might change depending upon the patronage. Nevertheless, if you are feeling generous, please feel free to 
                  <a href="donate.php" target="_blank">donate</a> for the cause of supporting this project.
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Will it remain free or are you planning to charge for this in the future?
                  </b>
                </dt>
                <dd>
                  Social Photos will always remain 100% free.
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Why aren't there any ads? I thought free services were always ad supported!
                  </b>
                </dt>
                <dd>
                  I thought about it, but decided not to place ads in social photos for two reasons. One is that there isn't much room in the
                  photo transfers page for the ad. I wanted to leave out as much space as possible to display the photos and albums.
                  The other is that, this app is usually used as a single long standing page with all the interactions happening through 
                  javascript, so it won't get many impressions anyway.
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Something isn't working the way it is supposed to. Where do i report that?
                  </b>
                </dt>
                <dd>
                  We understand that Social Photos isn't a perfect product and has a lot of flaws.
                  You can file a bug report <a href="http://goo.gl/QKZYu" target="_blank">here</a>.
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    Is Social Photos an open source project?
                  </b>
                </dt>
                <dd>
                  <strike>Unfortunately, No. I might publish the source code at some point in the future, but as of now it's not open source.</strike>
                  Yes, Social Photos is an Open Source project. You are free to either fork it, or contribute with pull requests here: <a href="https://github.com/vickyg3/social-photos" target="_blank">https://github.com/vickyg3/social-photos</a>
                  <br/><br/>
                </dd>
                <dt>
                  <b>
                    My question is technical/My question isn't answered here, what do I do?
                  </b>
                </dt>
                <dd>
                  Please feel free to <a href="contact.php" target="_blank">contact me</a>. I will be happy to respond to your concern.
                </dd>
              </dl>
            </p>
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
