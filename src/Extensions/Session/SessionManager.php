<?php

namespace Orvital\Support\Extensions\Session;

use Illuminate\Session\SessionManager as BaseSessionManager;
use Orvital\Support\Extensions\Session\EncryptedStore;
use Orvital\Support\Extensions\Session\Store;
use SessionHandlerInterface;

class SessionManager extends BaseSessionManager
{
    /**
     * Build the session instance.
     *
     * @param  SessionHandlerInterface  $handler
     * @return \Orvital\Extensions\Session\Store
     */
    protected function buildSession($handler)
    {
        return $this->config->get('session.encrypt')
                ? $this->buildEncryptedSession($handler)
                : new Store(
                    $this->config->get('session.cookie'),
                    $handler,
                    $id = null,
                    $this->config->get('session.serialization', 'php')
                );
    }

    /**
     * Build the encrypted session instance.
     *
     * @param  SessionHandlerInterface  $handler
     * @return \Orvital\Extensions\Session\EncryptedStore
     */
    protected function buildEncryptedSession($handler)
    {
        return new EncryptedStore(
            $this->config->get('session.cookie'),
            $handler,
            $this->container['encrypter'],
            $id = null,
            $this->config->get('session.serialization', 'php'),
        );
    }
}
