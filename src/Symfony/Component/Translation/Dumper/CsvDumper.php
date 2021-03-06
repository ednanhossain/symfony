<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Dumper;

use Symfony\Component\Translation\MessageCatalogue;

/**
 * CsvDumper generates a csv formated string representation of a message catalogue
 *
 * @author Stealth35
 */
class CsvDumper implements DumperInterface
{
    private $delimiter = ';';
    private $enclosure = '"';

    /**
     * {@inheritDoc}
     */
    public function dump(MessageCatalogue $messages, $domain = 'messages')
    {
        $handle = fopen('php://memory', 'rb+');

        foreach ($messages->all($domain) as $source => $target) {
            fputcsv($handle, array($source, $target), $this->delimiter, $this->enclosure);
        }

        rewind($handle);
        $output = stream_get_contents($handle);
        fclose($handle);

        return $output;
    }

    /**
     * Sets the delimiter and escape character for CSV.
     *
     * @param string $delimiter delimiter character
     * @param string $enclosure enclosure character
     */
    public function setCsvControl($delimiter = ';', $enclosure = '"')
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }
}
