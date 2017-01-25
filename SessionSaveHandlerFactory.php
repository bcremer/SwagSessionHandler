<?php

namespace SwagSessionHandler;

use Shopware\Components\DependencyInjection\Bridge\Db;
use Shopware\Components\DependencyInjection\Container;

class SessionSaveHandlerFactory
{
    /**
     * @param Container $container
     * @return null|\SessionHandlerInterface
     */
    static public function createSaveHandler(Container $container)
    {
        $sessionOptions = $container->getParameter('shopware.session');
        if (isset($sessionOptions['save_handler']) && $sessionOptions['save_handler'] !== 'db')  {
            return null;
        }

        $dbOptions = $container->getParameter('shopware.db');
        $conn = Db::createPDO($dbOptions);

        return new PdoSessionHandler(
            $conn,
            [
                'db_table'        => 'swagsessionhandler_sessions',
                'db_id_col'       => 'id',
                'db_data_col'     => 'data',
                'db_expiry_col'   => 'expiry',
                'db_time_col'     => 'modified',
                'lock_mode'       => $sessionOptions['locking'] ? PdoSessionHandler::LOCK_TRANSACTIONAL : PdoSessionHandler::LOCK_NONE,
            ]
        );
    }
}
