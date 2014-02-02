<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$config['title']?></title>

  <!-- Bootstrap -->
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>
      <div class="container">
        <div class="row">&nbsp;</div>

        <nav class="navbar navbar-default navbar-inverse" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="#"><?=$config['title']?></a>
            </div>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
            <li><a href="/admin/widget">Queues</a></li>
              <!-- <li><a href="/admin/pages">Pages</a></li> -->
              <li><a href="/admin/option">Options</a></li>
              <li><a href="/">View wallboard</a></li>
            </ul>
          </div>
        </nav>

        <div class="row">
          <div class="col-md-12">
            <?=$yield?>
          </div>
        </div>
      </div>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="/assets/js/bootstrap.min.js"></script>
    </body>
    </html>

