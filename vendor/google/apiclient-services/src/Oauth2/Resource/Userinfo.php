<?php

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
namespace BookneticVendor\Google\Service\Oauth2\Resource;

use BookneticVendor\Google\Service\Oauth2\Userinfo as UserinfoModel;
/**
 * The "userinfo" collection of methods.
 * Typical usage is:
 *  <code>
 *   $oauth2Service = new Google\Service\Oauth2(...);
 *   $userinfo = $oauth2Service->userinfo;
 *  </code>
 */
class Userinfo extends \BookneticVendor\Google\Service\Resource
{
    /**
     * (userinfo.get)
     *
     * @param array $optParams Optional parameters.
     * @return UserinfoModel
     */
    public function get($optParams = [])
    {
        $params = [];
        $params = \array_merge($params, $optParams);
        return $this->call('get', [$params], UserinfoModel::class);
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(Userinfo::class, 'BookneticVendor\\Google_Service_Oauth2_Resource_Userinfo');
