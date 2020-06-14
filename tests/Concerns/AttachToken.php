<?php

namespace Tests\Concerns;

use App\User;
use Carbon\Carbon;

trait AttachToken {

    protected $user;

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $parameters
     * @param array  $cookies
     * @param array  $files
     * @param array  $server
     * @param string $content
     *
     * @return \Illuminate\Http\Response
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null) {
        if (isset($this->user)) {
            $cookies = $this->attachToken();
        }
        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    /**
     * @param array $server
     *
     * @return array
     */
    protected function attachToken() {
        return [
            'token' => $this->user->token
        ];
    }
}
