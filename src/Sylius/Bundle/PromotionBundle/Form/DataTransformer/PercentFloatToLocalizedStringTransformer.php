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

use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\DataTransformer\PercentToLocalizedStringTransformer;

final class PercentFloatToLocalizedStringTransformer extends PercentToLocalizedStringTransformer
{
    /**
     * Converts a numeric percentage value to a float, or returns null if the input is not numeric.
     *
     * @param mixed $value The percentage value to convert.
     * @return float|null The converted float value, or null if input is not numeric.
     * @throws TransformationFailedException If the parent transformation fails.
     */
    public function reverseTransform(mixed $value): ?float
    {
        if (!is_numeric($value)) {
            return null;
        }

        return (float) parent::reverseTransform($value);
    }

    /**
     * @param float|string $value
     */
    public function transform(mixed $value): string
    {
        if (!is_numeric($value)) {
            return '';
        }

        return parent::transform((float) $value);
    }
}
