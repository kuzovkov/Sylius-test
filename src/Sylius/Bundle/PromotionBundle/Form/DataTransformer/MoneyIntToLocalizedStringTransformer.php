<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\PromotionBundle\Form\DataTransformer;

use Symfony\Component\Form\Extension\Core\DataTransformer\MoneyToLocalizedStringTransformer;

final class MoneyIntToLocalizedStringTransformer extends MoneyToLocalizedStringTransformer
{
    /**
     * Converts a localized string or numeric value to an integer monetary amount.
     *
     * Returns null if the input is not numeric; otherwise, transforms the value using the parent transformer and casts the result to an integer.
     *
     * @param mixed $value The value to be transformed.
     * @return int|null The integer monetary amount, or null if input is not numeric.
     */
    public function reverseTransform(mixed $value): ?int
    {
        if (!is_numeric($value)) {
            return null;
        }

        return (int) parent::reverseTransform($value);
    }

    public function transform(mixed $value): string
    {
        if (!is_numeric($value)) {
            return '';
        }

        return parent::transform($value);
    }
}
