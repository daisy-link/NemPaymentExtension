<?php
/*
 * Copyright(c) 2018 Daisy Inc. All Rights Reserved.
 *
 * This software is released under the MIT license.
 * http://opensource.org/licenses/mit-license.php
 */

namespace Plugin\NemPaymentExtension\Nem\Exchange;

use DaisyLink\Exchanger\AbstractExchanger;
use DaisyLink\Exchanger\Exception\GetRateException;
use Guzzle\Common\Exception\RuntimeException;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;

class XemJpyZaifExchanger extends AbstractExchanger
{
    /**
     * @var bool
     */
    private $refreshed = false;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $rate;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'XEM/JPY (Zaif)';
    }

    /**
     * @return bool
     */
    protected function isRefreshed()
    {
        return $this->refreshed;
    }

    /**
     * @return ClientInterface
     * @throws RuntimeException
     */
    protected function getClient()
    {
        if (!$this->client) {
            $this->client = new Client('https://api.zaif.jp/api/1/last_price/xem_jpy', array(
                Client::CURL_OPTIONS => array(
                    CURLOPT_CONNECTTIMEOUT_MS => 1500,
                    CURLOPT_TIMEOUT_MS => 5000,
                )
            ));
        }

        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function getRate()
    {
        if (!$this->isRefreshed()) {
            $this->refreshRate();
        }

        return $this->rate;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshRate()
    {
        try {
            $response = $this->getClient()->get()->send();

            if (!$response->isSuccessful() || $response->isRedirect()) {
                throw new GetRateException(sprintf('Request failure. Status code = %s.', $response->getStatusCode()));
            }

            $json = $response->json();

            if (!is_array($json) || !isset($json['last_price']) || !is_numeric($json['last_price'])) {
                throw new GetRateException('Response body is not valid.');
            }

        } catch (RuntimeException $e) {
            throw new GetRateException($e->getMessage(), $e->getCode(), $e);
        }

        $this->refreshed = true;
        $this->rate = $json['last_price'];
    }
}
