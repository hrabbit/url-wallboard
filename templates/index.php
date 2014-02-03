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
    	<style type="text/css">
    	body { 
    		background-color: <?=$config['widget_background_color']?>; 
    		color: <?=$config['widget_forground_color']?>;
    		font-size: <?=$config['widget_font_size']?>px; 
    	}
    	.title { text-align: center; }
    	</style>
      <div class="container-responsive">
      	<?php foreach($widgets as $widget): ?>
		<div class="col-md-<?=12 / $config['widgets_per_row']?>">
			<div class="title"><?=$widget->title?></div>
			<div class="alert alert-success">
				<!-- <p class="pull-left">Calls waiting</p> -->
				<div class="row">
					<div class="col-md-8">Calls waiting</div>
					<div class="col-md-4"><p class="pull-right"><?=$widget->calls_waiting?></p></div>
				</div>
			</div>
	  		<?=print_r($widget,1)?>
		</div>
	      <?php endforeach ?>
      </div>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="/assets/js/bootstrap.min.js"></script>
    </body>
    </html>

