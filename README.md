# SwagSessionHandler

This is a workaround or proof of concept for the following ticket: <http://issues.shopware.com/issues/SW-17563>.

The following pull request for Symfony's PdoSessionHandler was rebased to the current Symfony 3.1 branch
<https://github.com/symfony/symfony/pull/14625>.

With Shopware 5.2.14 the Session Handling was changed to use Symfony's `PdoSessionHandler`.
This patched SessionHandler will be used instead of the one Provided by the Shopware Core to improve performance of the session garbage collection.
This is dony by using precalculated expiry timestamps as implemented in the above mentioned Symfony PR.

This will eventually be included the next Shopware Version (Currently targeting 5.2.17).

## Installation

    git clone https://github.com/bcremer/SwagSessionHandler.git custom/plugins/SwagSessionHandler
    ./bin/console sw:plugin:refresh
    ./bin/console sw:plugin:install --activate  SwagSessionHandler
    ./bin/console sw:cache:clear
    
## Note

This plugin uses a separate table (`swagsessionhandler_sessions`) and copies sessions from `s_core_sessions` so it can safetly tested.
    
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
