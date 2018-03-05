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
use CoreShop\Component\Order\Context\CartContextInterface;
use Webmozart\Assert\Assert;

final class CartContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var CartContextInterface
     */
    private $cartContext;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param CartContextInterface $cartContext
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        CartContextInterface $cartContext
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->cartContext = $cartContext;
    }

    /**
     * @Then /^there should be one product in my cart$/
     */
    public function thereShouldBeOneProductInTheCart()
    {
        Assert::eq(
            count($this->cartContext->getCart()->getItems()),
            1,
            sprintf(
                'There should be only one product in the cart, but found %d',
                count($this->cartContext->getCart()->getItems())
            )
        );
    }

    /**
     * @Then /^the cart total should be "([^"]+)" including tax$/
     */
    public function cartTotalShouldBeIncludingTax($total)
    {
        Assert::eq(
            $total,
            $this->cartContext->getCart()->getTotal(true),
            sprintf(
                'Cart total is expected to be %s, but it is %s',
                $total,
                $this->cartContext->getCart()->getTotal(true)
            )
        );
    }

    /**
     * @Then /^the cart total should be "([^"]+)" excluding tax$/
     */
    public function cartTotalShouldBeExcludingTax($total)
    {
        Assert::eq(
            $total,
            $this->cartContext->getCart()->getTotal(false),
            sprintf(
                'Cart total is expected to be %s, but it is %s',
                $total,
                $this->cartContext->getCart()->getTotal(false)
            )
        );
    }

    /**
     * @Then /^the cart subtotal should be "([^"]+)" including tax$/
     */
    public function cartSubtotalShouldBeIncludingTax($total)
    {
        Assert::eq(
            $total,
            $this->cartContext->getCart()->getSubtotal(true),
            sprintf(
                'Cart subtotal is expected to be %s, but it is %s',
                $total,
                $this->cartContext->getCart()->getSubtotal(true)
            )
        );
    }

    /**
     * @Then /^the cart subtotal should be "([^"]+)" excluding tax$/
     */
    public function cartSubtotalShouldBeExcludingTax($total)
    {
        Assert::eq(
            $total,
            $this->cartContext->getCart()->getSubtotal(false),
            sprintf(
                'Cart subtotal is expected to be %s, but it is %s',
                $total,
                $this->cartContext->getCart()->getSubtotal(false)
            )
        );
    }
}
