<?php

class Database extends \PDO {
    
    /**
     * Instance of slim app
     *
     * @var \Slim\Slim 
     */
    public $slim;
    
    /**
     * Constructor
     * 
     * @param \Slim\Slim $app
     * 
     * @return \Database
     */
    public function __construct(\Slim\Slim $app) {
        $this->slim = $app;

        try {
            parent::__construct(
                DB_TYPE . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_ENCODING,
                DB_LOGIN,
                DB_PASS,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".DB_ENCODING."'"
                ]
            );
        } catch (\PDOException $p) {
            $this->slim->log->error('BAD THINGS');
            return $this->slim->error();
        }

        return $this;
    }
    
    /**
     * Writes stats
     * 
     * @param string $action_type
     * @param string $activated_url
     * @param string $method
     */
    public function writeStats($action_type, $activated_url = '', $method = '') {
        $stmt = $this->prepare("INSERT INTO stats (source_url, action_type, method, activated_url) VALUES (:source_url, :action_type, :method, :activated_url)");
        $stmt->execute([
            ':activated_url' => $activated_url,
            ':action_type' => $action_type,
            ':method' => $method,
            ':source_url' => isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:''
        ]);
    }
    
}