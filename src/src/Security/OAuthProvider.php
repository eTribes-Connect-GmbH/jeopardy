<?php declare(strict_types = 1);

namespace App\Security;

use Auth0\SDK\Auth0;

class OAuthProvider
{
    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $domain;
    /**
     * @var string
     */
    private $secret;

    /**
     * @var Auth0
     */
    protected $oauth;

    /**
     * OAuthProvider constructor.
     *
     * @param string $clientId
     * @param string $domain
     * @param string $secret
     */
    public function __construct(string $clientId, string $domain, string $secret)
    {
        $this->clientId = $clientId;
        $this->domain = $domain;
        $this->secret = $secret;
    }

    /**
     * @return \Auth0\SDK\Auth0
     * @throws \Auth0\SDK\Exception\CoreException
     */
    public function createOAuth(): Auth0
    {
        return new Auth0([
            'domain' => $this->domain,
            'client_id' => $this->clientId,
            'client_secret' => $this->secret,
            'redirect_uri' => 'http://skillz.local/welcome',
            'scope' => 'openid profile email',
        ]);
    }

    public function getOauth(): Auth0
    {
        if ($this->oauth !== null) {
            return $this->oauth;
        }

        $this->oauth = $this->createOAuth();

        return $this->oauth;
    }
}