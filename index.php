<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

$app = new \Slim\Slim([
    'mode' => 'development',
    'templates.path' => __DIR__ . '/templates'
]);

$app->container->singleton('db', function () use ($app) {
    return new \Database($app);
});

$app->container->singleton('fetcher', function () use ($app) {
    return new \Fetcher($app);
});

$app->get('/updates.old', function () use ($app) {    
    $app->render('widget_content.php', compact('app'));
});

$app->get('/updates', function () use ($app) {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    $app->response->headers->set('Content-Type', 'text/event-stream');
    $app->response->headers->set('Cache-Control', 'no-cache');
    @ob_flush();
    @flush();      
        
    while(true) {
        sleep(UPDATE_INTERVAL / 60);
        
        $channel = $app->fetcher->get_channel_tags('', 'lastBuildDate');
        if (isset($channel[0]['data']) && strtotime($channel[0]['data']) < time()) {
            continue;
        }
        
        ob_start();
        include __DIR__ . '/templates/widget_content.php';
        $content = '';        
        foreach (explode("\n", ob_get_clean()) as $line) {
            $content .= "data: {$line}" . "\n";
        }
        echo $content . "\n";
        @ob_end_clean();
        
        @ob_flush();
        @flush();      
    }
});

$app->post('/click', function () use ($app) {
    $app->db->writeStats('click', $_POST['link']);
});

$app->get('/', function () use ($app) {
    $sth = $app->db->prepare("SELECT "
            . "source_url 'url',"
            . "MIN(`time`) first_date, "
            . "MAX(`time`) last_date, "
            . "COUNT(*) 'count' "
            . "FROM stats "
            . "WHERE action_type = 'shown' "
            . "GROUP BY source_url "
            . "ORDER BY last_date DESC");
    $sth->execute();
    $places = $sth->fetchAll();
    
    $sth = $app->db->prepare("SELECT "
            . "activated_url 'url',"
            . "MIN(`time`) first_date, "
            . "MAX(`time`) last_date, "
            . "COUNT(*) 'clicks' "
            . "FROM stats "
            . "WHERE action_type = 'click' "
            . "GROUP BY activated_url "
            . "ORDER BY last_date DESC");
    $sth->execute();
    $links = $sth->fetchAll();
    
    $app->render('main.php', compact('links', 'places'));
});

$app->get('/widget:info', function ($info) use ($app) {    
    $i = strrpos($info, '.');
    $ext = substr($info, $i);    
    $id = ($i > 0)?substr(substr($info, 0, $i), 1):'';
    
    $app->db->writeStats('shown', '', strtolower(substr($ext, 1)));   
    
    $app->render('widget'.$ext.'.php', compact('id', 'app'));
});

$app->run();