<?php foreach ($app->fetcher->get_items() as $item): $data = $app->fetcher->extractData($item); ?>
    <div class="row">
        <div class="pull-left">
            <img src="<?php echo htmlentities($data['image_url']); ?>" alt="<?php echo htmlentities($data['title']); ?>" width="50" height="50" />
        </div>
        <div class="content">
            <h4><a href="<?php echo $data['link']; ?>" target="_blank"><?php echo $data['title']; ?></a></h4>
            <div><?php echo $data['content']; ?></div>
        </div>
    </div>
<?php endforeach; ?>