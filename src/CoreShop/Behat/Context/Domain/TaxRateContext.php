<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2017 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Core\Model\CategoryInterface;
use CoreShop\Component\Core\Model\CurrencyInterface;
use CoreShop\Component\Core\Model\CustomerInterface;
use CoreShop\Component\Core\Model\ProductInterface;
use CoreShop\Component\Core\Model\StoreInterface;
use CoreShop\Component\Core\Repository\CurrencyRepositoryInterface;
use CoreShop\Component\Core\Repository\ProductRepositoryInterface;
use CoreShop\Component\Currency\Context\CurrencyContextInterface;
use CoreShop\Component\Currency\Formatter\MoneyFormatterInterface;
use CoreShop\Component\Customer\Context\CustomerContextInterface;
use CoreShop\Component\Product\Calculator\ProductPriceCalculatorInterface;
use CoreShop\Component\Resource\Factory\FactoryInterface;
use CoreShop\Component\Resource\Repository\RepositoryInterface;
use CoreShop\Component\Taxation\Repository\TaxRateRepositoryInterface;
use Pimcore\Model\DataObject\Folder;
use Webmozart\Assert\Assert;

final class TaxRateContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var TaxRateRepositoryInterface
     */
    private $taxRateRepository;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param TaxRateRepositoryInterface $taxRateRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        TaxRateRepositoryInterface $taxRateRepository)
    {
        $this->sharedStorage = $sharedStorage;
        $this->taxRateRepository = $taxRateRepository;
    }

    /**
     * @Then /^there should be a tax rate "([^"]+)" with "([^"]+)%" rate$/
     */
    public function thereShouldBeATaxRate($name, $rate)
    {
        $rates = $this->taxRateRepository->findByName($name, 'en');

        Assert::eq(
            count($rates),
            1,
            sprintf('%d tax-rate has been found with name "%s".', count($rates), $name)
        );

        $taxrate = reset($rates);

        Assert::eq(
            $taxrate->getRate(),
            $rate,
            sprintf('given rate "%d" is different from tax-rates rate "%s".', $rate, $taxrate->getRate())
        );
    }
}
