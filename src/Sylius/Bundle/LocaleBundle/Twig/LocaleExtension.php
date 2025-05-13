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

namespace Sylius\Bundle\LocaleBundle\Twig;

use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Context\LocaleNotFoundException;
use Sylius\Component\Locale\Converter\LocaleConverterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class LocaleExtension extends AbstractExtension
{
    public function __construct(
        private LocaleConverterInterface $localeConverter,
        private LocaleContextInterface $localeContext,
    ) {
    }

    /**
     * Returns the list of Twig filters provided by this extension for locale name and country code conversion.
     *
     * @return TwigFilter[] Array of Twig filters for locale-related transformations.
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('sylius_locale_name', [$this, 'convertCodeToName']),
            new TwigFilter('sylius_locale_country', [$this, 'getCountryCode']),
        ];
    }

    /**
     * Converts a locale code to its human-readable name, returning the original code if conversion fails.
     *
     * @param string $code The locale code to convert.
     * @param string|null $localeCode Optional locale code to use for the conversion context.
     * @return string The human-readable locale name, or the original code if conversion is not possible.
     */
    public function convertCodeToName(string $code, ?string $localeCode = null): string
    {
        try {
            return $this->localeConverter->convertCodeToName($code, $this->getLocaleCode($localeCode));
        } catch (\InvalidArgumentException) {
            return $code;
        }
    }

    public function getLocaleCode(?string $localeCode): ?string
    {
        if (null !== $localeCode) {
            return $localeCode;
        }

        try {
            return $this->localeContext->getLocaleCode();
        } catch (LocaleNotFoundException) {
            return null;
        }
    }

    public function getCountryCode(string $locale): ?string
    {
        return \Locale::getRegion($locale);
    }
}
