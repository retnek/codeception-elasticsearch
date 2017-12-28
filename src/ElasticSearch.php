<?php
/**
 * @author Jan Wyszynski
 */

namespace Codeception\Module;

use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Elasticsearch\Client;

class ElasticSearch extends Module
{
    /**
     * @var Client
     */
    private $elasticSearch;

    public function __construct($config = null)
    {
        if (!isset($config['hosts'])) {
            throw new \Exception('please configure hosts for ElasticSearch codeception module');
        }

        if (isset($config['hosts']) && !is_array($config['hosts'])) {
            $config['hosts'] = array($config['hosts']);
        }
        $this->config = (array)$config;

        parent::__construct();
    }

    public function _initialize()
    {
        $this->elasticSearch = new Client($this->config);
    }

    /**
     * Check if an item exists in a given index
     *
     * @param string $index index name
     * @param string $type item type
     * @param string $id item id
     *
     * @return array
     */
    public function seeItemExistsInElasticsearch($index, $type, $id)
    {
        return $this->elasticSearch->exists([
            'index' => $index,
            'type' => $type,
            'id' => $id
        ]);
    }
}
