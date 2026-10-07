<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Fusio\Adapter\Ftp\Connection;

use Fusio\Engine\ConnectionAbstract;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;

/**
 * Ftp
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org/
 */
class Ftp extends ConnectionAbstract
{
    public function getName(): string
    {
        return 'FTP';
    }

    public function getConnection(ParametersInterface $config): FilesystemOperator
    {
        $adapter = new FtpAdapter(
            FtpConnectionOptions::fromArray([
                'host' => $config->get('host'),
                'root' => $config->get('root'),
                'username' => $config->get('username'),
                'password' => $config->get('password'),
            ])
        );

        return new Flysystem($adapter);
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory): void
    {
        $builder->add($elementFactory->newInput('host', 'Host', 'text', 'FTP Host'));
        $builder->add($elementFactory->newInput('username', 'Username', 'text', 'FTP username'));
        $builder->add($elementFactory->newInput('password', 'Password', 'password', 'FTP password'));
        $builder->add($elementFactory->newInput('root', 'Root', 'text', 'Root path to the folder'));
    }
}
