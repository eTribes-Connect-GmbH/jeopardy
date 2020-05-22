<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;

trait UserDataTrait
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|null
     */
    protected function getUserData(Request $request): ?array
    {
        if (!$request->getSession()->has('user')) {
            return null;
        }

        return json_decode($request->getSession()->get('user'), true);
    }
}