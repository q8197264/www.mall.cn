<?php
namespace App\Caches\Redis;

use Predis;
use Predis\Cluster\Distributor\DistributorInterface;
use Predis\Cluster\Hash\HashGeneratorInterface;
use Predis\Cluster\PredisStrategy;
use Predis\Connection\Aggregate\PredisCluster;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 14:36
 */
class AbstractCache
{
    protected $single_server = array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 15,
    );

    protected $multiple_servers = array(
        array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
            'alias' => 'first',
        ),
        array(
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 15,
            'alias' => 'second',
        ),
    );

    //分布式存储
    protected function driver()
    {
        $options = array(
            'cluster' => function () {
                $distributor = new NaiveDistributor();
                $strategy = new PredisStrategy($distributor);
                $cluster = new PredisCluster($strategy);

                return $cluster;
            },
        );
        $client = new Predis\Client($this->multiple_servers, $options);
        //        for ($i=0; $i<100; $i++) {
        //            $client->set('key:'.$i, str_pad($i, 10, '*', 0));
        //        }
        //        $data = $client->getClientFor('first')->keys("*");
        //        echo '<pre>';print_r($data);
        $server1 = $client->getClientFor('first')->info();
        $server2 = $client->getClientFor('second')->info();
    }

    public function __construct()
    {
        $this->driver();
//        echo '<pre>';print_r($data);
    }

    function redis_version($info)
    {
        if (isset($info['Server']['redis_version'])) {
            return $info['Server']['redis_version'];
        } elseif (isset($info['redis_version'])) {
            return $info['redis_version'];
        } else {
            return 'unknown version';
        }
    }


}
class NaiveDistributor implements DistributorInterface, HashGeneratorInterface
{
    private $nodes;
    private $nodesCount;

    public function __construct()
    {
        $this->nodes = array();
        $this->nodesCount = 0;
    }

    public function add($node, $weight = null)
    {
        $this->nodes[] = $node;
        ++$this->nodesCount;
    }

    public function remove($node)
    {
        $this->nodes = array_filter($this->nodes, function ($n) use ($node) {
            return $n !== $node;
        });

        $this->nodesCount = count($this->nodes);
    }

    public function getSlot($hash)
    {
        return $this->nodesCount > 1 ? abs($hash % $this->nodesCount) : 0;
    }

    public function getBySlot($slot)
    {
        return isset($this->nodes[$slot]) ? $this->nodes[$slot] : null;
    }

    public function getByHash($hash)
    {
        if (!$this->nodesCount) {
            throw new \RuntimeException('No connections.');
        }

        $slot = $this->getSlot($hash);
        $node = $this->getBySlot($slot);

        return $node;
    }

    public function get($value)
    {
        $hash = $this->hash($value);
        $node = $this->getByHash($hash);

        return $node;
    }

    public function hash($value)
    {
        return crc32($value);
    }

    public function getHashGenerator()
    {
        return $this;
    }
}