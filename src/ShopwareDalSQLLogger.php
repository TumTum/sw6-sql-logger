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

/**
 * Class OxidSQLLogger
 * @package tm\sw6\sql\logger
 */
class ShopwareDalSQLLogger implements SQLLogger
{
    /**
     * @var SQLQuery
     */
    private $SQLQuery = null;

    private $useVarDumper = false;

    /**
     * @inheritDoc
     */
    public function __construct(array $options)
    {
        if (!Monolog\Registry::hasLogger('sql')) {
            Monolog\Registry::addLogger((new LoggerFactory())->create('sql'));
        }

        $this->useVarDumper = $options['useVarDumper'] ?? false;
    }

    /**
     * @inheritDoc
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        if ($this->SQLQuery) {
            $this->SQLQuery->setCanceled();
            $this->stopQuery();
        }

        $this->SQLQuery = (new SQLQuery()) ->setSql($sql)
                                            ->setParams(ShopwareParams::encode($params))
                                            ->setTypes($types);
    }

    /**
     * @inheritDoc
     */
    public function stopQuery()
    {
        if ($this->SQLQuery) {
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
