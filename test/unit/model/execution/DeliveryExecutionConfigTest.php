<?php

/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2020 (original work) Open Assessment Technologies SA;
 */

declare(strict_types=1);

namespace oat\taoDelivery\test\unit\model\execution;

use oat\generis\test\TestCase;
use oat\taoDelivery\model\execution\DeliveryExecutionConfig;

class DeliveryExecutionConfigTest extends TestCase
{
    /**
     * @dataProvider dataProviderForIsHomeButtonHiddenTest
     *
     * @param array $options
     * @param bool $expected
     */
    public function testIsHomeButtonHiddenMethod(array $options, bool $expected): void
    {
        $deliveryExecutionConfig = new DeliveryExecutionConfig($options);
        $this->assertEquals($expected, $deliveryExecutionConfig->isHomeButtonHidden());
    }

    /**
     * @dataProvider dataProviderForSetHideButtonTest
     *
     * @param bool $hide
     * @param bool $expected
     */
    public function testSetHideHomeButtonMethod(bool $hide, bool $expected): void
    {
        $deliveryExecutionConfig = new DeliveryExecutionConfig([]);
        $this->assertEquals(false, $deliveryExecutionConfig->isHomeButtonHidden());

        $deliveryExecutionConfig->setHideHomeButton($hide);
        $this->assertEquals($expected, $deliveryExecutionConfig->isHomeButtonHidden());
    }

    /**
     * @dataProvider dataProviderForIsLogoutButtonHiddenTest
     *
     * @param array $options
     * @param bool $expected
     */
    public function testIsLogoutButtonHiddenMethod(array $options, bool $expected): void
    {
        $deliveryExecutionConfig = new DeliveryExecutionConfig($options);
        $this->assertEquals($expected, $deliveryExecutionConfig->isLogoutButtonHidden());
    }

    /**
     * @dataProvider dataProviderForSetHideButtonTest
     *
     * @param bool $hide
     * @param bool $expected
     */
    public function testSetHideLogoutButtonMethod(bool $hide, bool $expected): void
    {
        $deliveryExecutionConfig = new DeliveryExecutionConfig([]);
        $this->assertEquals(false, $deliveryExecutionConfig->isLogoutButtonHidden());

        $deliveryExecutionConfig->setHideLogoutButton($hide);
        $this->assertEquals($expected, $deliveryExecutionConfig->isLogoutButtonHidden());
    }

    /**
     * @return array
     */
    public function dataProviderForIsHomeButtonHiddenTest(): array
    {
        return [
            [
                'options' => [DeliveryExecutionConfig::OPTION_HIDE_HOME_BUTTON => true],
                'expected' => true,
            ],
            [
                'options' => [DeliveryExecutionConfig::OPTION_HIDE_HOME_BUTTON => false],
                'expected' => false,
            ],
            [
                'options' => [DeliveryExecutionConfig::OPTION_HIDE_HOME_BUTTON => 'test value'],
                'expected' => false,
            ],
            [
                'options' => [],
                'expected' => false,
            ],
        ];
    }

    /**
     * @return array
     */
    public function dataProviderForIsLogoutButtonHiddenTest(): array
    {
        return [
            [
                'options' => [DeliveryExecutionConfig::OPTION_HIDE_LOGOUT_BUTTON => true],
                'expected' => true,
            ],
            [
                'options' => [DeliveryExecutionConfig::OPTION_HIDE_LOGOUT_BUTTON => false],
                'expected' => false,
            ],
            [
                'options' => [DeliveryExecutionConfig::OPTION_HIDE_LOGOUT_BUTTON => 'test value'],
                'expected' => false,
            ],
            [
                'options' => [],
                'expected' => false,
            ],
        ];
    }

    /**
     * @return array
     */
    public function dataProviderForSetHideButtonTest(): array
    {
        return [
            [
                'hide' => true,
                'expected' => true,
            ],
            [
                'hide' => false,
                'expected' => false,
            ],
        ];
    }
}
