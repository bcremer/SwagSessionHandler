<?php
namespace SwagSessionHandler;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class SwagSessionHandler extends Plugin
{

    public function install(InstallContext $context)
    {
        $conn = $this->container->get('dbal_connection');

        $sql = <<<SQL
       CREATE TABLE `swagsessionhandler_sessions` (
  `id` varchar(128) COLLATE utf8_bin NOT NULL,
  `data` mediumblob NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  `expiry` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_sess_expiry` (`expiry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL;
        $conn->exec($sql);

        $sql = <<<SQL
        INSERT INTO `swagsessionhandler_sessions`
SELECT id, data, modified, expiry + modified as expiry FROM `s_core_sessions`;
SQL;
        $conn->exec($sql);
    }

    public function uninstall(UninstallContext $context)
    {
        $conn = $this->container->get('dbal_connection');

        $conn->exec('DROP TABLE `swagsessionhandler_sessions`');
    }
}
