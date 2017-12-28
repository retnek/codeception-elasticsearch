<?php
/**
 * @author Jan Wyszynski
 */

namespace Codeception\Module;

use Codeception\Lib\ModuleContainer;
use Codeception\Module;
use Elasticsearch\ClientBuilder;

class ElasticSearch extends Module
{
    /**
     * @var Client
     */
    private $elasticSearch;

    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        if (!isset($config['dsn'])) {
            throw new \Exception('please configure dsn for ElasticSearch codeception module');
        }

        $this->config = $config;

        parent::__construct($moduleContainer, $config);
    }

    public function _initialize()
    {
        $this->elasticSearch = ClientBuilder::create()
            ->setHosts([$this->config['dsn']])
            ->build();
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
