<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->        

        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#code" aria-controls="code" role="tab" data-toggle="tab">Code</a></li>
            <li role="presentation"><a href="#stats" aria-controls="stats" role="tab" data-toggle="tab">Statistics</a></li>    
            </ul>    

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="code">                                      
                    <form class="widget-generator">
                        <div class="form-group">
                            <label for="width">Width</label>
                            <div class="input-group">
                                <input type="number" value="100" name="width" class="form-control" id="width" placeholder="Enter width of the widget">
                                <div class="input-group-addon">                                    
                                    <input type="radio" name="width_units" checked value="%" class="form-control" id="width_units_percent">
                                    <label for="width_units_percent">%</label>                                    
                                    <input type="radio" name="width_units" value="px" class="form-control" id="width_units_pixels">
                                    <label for="width_units_pixels">px</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="height">Height</label>
                            <div class="input-group">
                                <input type="number" value="100" name="height" class="form-control" id="height" placeholder="Enter height of the widget">
                                <div class="input-group-addon">                                    
                                    <input type="radio" name="height_units" checked value="%" class="form-control" id="height_units_percent">
                                    <label for="height_units_percent">%</label>                                    
                                    <input type="radio" name="height_units" value="px" class="form-control" id="height_units_pixels">
                                    <label for="height_units_pixels">px</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="method">Inclusion method</label>
                            <div class="input-group">
                                <select name="method" class="form-control">
                                    <option value="js" selected>JavaScript</option>
                                    <option value="iframe">IFrame</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" hidden>
                            <label>Preview</label>
                            <div id="preview">
                                
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label for="result">Embed code</label>
                            <div class="input-group">
                                <textarea class="form-control" name="result" readonly rows="24" cols="80">
                                    
                                </textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade in" id="stats">
                    <h4>Embeded places</h4>
                    <div class="stats-block-content">
                        <?php if (empty($places)): ?>
                            At this time there are the lack of data
                        <?php else: ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            URL
                                        </th>
                                        <th>
                                            Init count
                                        </th>
                                        <th>
                                            Last Date
                                        </th>
                                        <th>
                                            First Date
                                        </th>                                        
                                    </tr>
                                </thead>    
                                <tbody>
                                    <?php foreach ($places as $place): ?>
                                        <tr>
                                            <th>
                                                <a href="<?php echo $place['url']; ?>" target="_blank"><?php echo $place['url']; ?></a>
                                            </th>                                           
                                            <th>
                                                <?php echo $place['count']; ?>
                                            </th>
                                            <th>
                                                <?php echo $place['last_date']; ?>
                                            </th>
                                            <th>
                                                <?php echo $place['first_date']; ?>
                                            </th>                                            
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>                            
                        <?php endif; ?>
                    </div>
                    <h4>Clicked links</h4>
                    <div class="stats-block-content">
                        <?php if (empty($links)): ?>
                            At this time there are the lack of data
                        <?php else: ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            URL
                                        </th>
                                        <th>
                                            Clicks
                                        </th>
                                        <th>
                                            Last Date
                                        </th>
                                        <th>
                                            First Date
                                        </th>
                                    </tr>
                                </thead>    
                                <tbody>
                                    <?php foreach ($links as $link): ?>
                                        <tr>
                                            <th>
                                                <a href="<?php echo $link['url']; ?>" target="_blank"><?php echo $link['url']; ?></a>
                                            </th>
                                            <th>
                                                <?php echo $link['clicks']; ?>
                                            </th>
                                            <th>
                                                <?php echo $place['last_date']; ?>
                                            </th>
                                            <th>
                                                <?php echo $place['first_date']; ?>
                                            </th>                                            
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>                
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
    </body>
</html>
