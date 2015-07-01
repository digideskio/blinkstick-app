<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  <title>
    <?php echo $this->fetch('title'); ?>
  </title>

    <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="/css/vendor/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/css/flat-ui.css" rel="stylesheet">

    <link rel="shortcut icon" href="/img/favicon.ico">

  <?php
    //echo $this->Html->css('cake.generic');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
  ?>
  <link rel="stylesheet" type="text/css" href="/css/blinkstickapp.css">
  <script src="/js/jquery.min.js"></script>
  <script src="/js/blinkstickapp.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="dist/js/vendor/html5shiv.js"></script>
      <script src="dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <div id="container" class="container">
    <div class="row">
      <div class="col-xs-12">
        
        <div id="content">

          <?php echo $this->fetch('content'); ?>
        </div>
      </div>
    </div>
  </div>
  <!-- ?php echo $this->element('sql_dump'); ? -->

    <script src="/js/vendor/jquery.min.js"></script>
    <script src="/js/vendor/video.js"></script>
    <script src="/js/flat-ui.min.js"></script>
</body>
</html>