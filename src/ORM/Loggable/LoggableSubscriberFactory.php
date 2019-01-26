<?php
/**
 * Copyright 2019 Martin Meredith <martin@sourceguru.net>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace Mez\DoctrineBehaviors\ORM\Loggable;

use Interop\Container\ContainerInterface;
use Knp\DoctrineBehaviors\ORM\Loggable\LoggableSubscriber;
use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;

/**
 * Class LoggableSubscriberFactory
 *
 * @package Mez\DoctrineBehaviors\ORM\Loggable
 */
final class LoggableSubscriberFactory
{
    /**
     * __invoke
     *
     * @param \Interop\Container\ContainerInterface $container
     *
     * @return \Knp\DoctrineBehaviors\ORM\Loggable\LoggableSubscriber
     */
    public function __invoke(ContainerInterface $container)
    {
        /** @var array $config */
        $config = $container->get('config')['doctrine-behaviors'];

        /** @var ClassAnalyzer $classAnalyzer */
        $classAnalyzer = $container->get(ClassAnalyzer::class);

        /** @var bool $isRecursive */
        $isRecursive = $config['reflection']['is_recursive'];

        /** @var callable|null $loggerCallable */
        $loggerCallable = null;

        if (!empty($config['logger_subscriber']['logger_callable']) &&
            $container->has($config['logger_subscriber']['logger_callable'])) {
            $loggerCallable = $container->get($config['logger_subscriber']['logger_callable']);
        }

        return new LoggableSubscriber($classAnalyzer, $isRecursive, $loggerCallable);
    }
}