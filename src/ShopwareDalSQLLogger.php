<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:33
 */

namespace tm\sw6\sql\logger;

use Doctrine\DBAL\Logging\SQLLogger;
use Monolog;
use Symfony\Component\VarDumper\VarDumper;
use tm\sw6\sql\logger\Ray\Payload\DoctrinePayload;

/**
 * Class OxidSQLLogger
 * @package tm\sw6\sql\logger
 */
class ShopwareDalSQLLogger implements SQLLogger
{

    private SQLQuery|null $SQLQuery;

    private $useVarDumper = false;

    private $useRayDumper = false;

    /**
     * @inheritDoc
     */
    public function __construct(array $options)
    {
        if (!Monolog\Registry::hasLogger('sql')) {
            Monolog\Registry::addLogger((new LoggerFactory())->create('sql'));
        }

        $this->useVarDumper = $options['useVarDumper'] ?? false;
        $this->useRayDumper = $options['useRayDumper'] ?? false;
    }

    /**
     * @inheritDoc
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        if (isset($this->SQLQuery) && $this->SQLQuery !== null) {
            $this->SQLQuery->setCanceled();
            $this->stopQuery();
        }

        $this->SQLQuery = (new SQLQuery())
            ->setSql($sql)
            ->setParams(ShopwareParams::encode($params))
            ->setTypes($types);
    }

    /**
     * @inheritDoc
     */
    public function stopQuery()
    {
        if (isset($this->SQLQuery) && $this->SQLQuery !== null) {
            $msg = ['[' . $this->SQLQuery->getReadableElapsedTime() . ']', $this->SQLQuery->getSql()];
            $data = [
                'params' => $this->SQLQuery->getParams(),
                'time' => $this->SQLQuery->getElapsedTime(),
                'types' => $this->SQLQuery->getTypes(),
            ];

            if ($this->useVarDumper) {
                VarDumper::dump([
                    ...[$msg[0] => $msg[1]],
                    ...$data
                ]);
            } elseif ($this->useRayDumper) {
                $ms = $this->SQLQuery->getElapsedTime();
                if (is_string($ms)) {
                    $ms = -1;
                } else {
                    $ms = round($ms*1000, 3);
                }
                ray()->sendRequest(new DoctrinePayload(
                    sql: $this->SQLQuery->getSql(),
                    bindings: $this->SQLQuery->getParams(),
                    time: $ms,
                ));
            } else {
                Monolog\Registry::sql()->debug(
                    implode(' ', $msg),
                    $data
                );
            }
        }

        $this->SQLQuery = null;
    }
}
