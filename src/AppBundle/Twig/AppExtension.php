<?php
/*
 * @author Tobias Olry <tobias.olry@gmail.com>
 */

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('longest_matching_segment', [$this, 'longestMatchingSegment']),
        ];
    }


    public function longestMatchingSegment($value, $valueToCompareWith, $delimiter = '.')
    {
        if ($value == $valueToCompareWith) {
            return  $value;
        }

        $partsValue = explode($delimiter, $value);
        $partsValueToCompareWith = explode($delimiter, $valueToCompareWith);

        $segments = [];
        for($i = 0; $i < count($partsValue); $i++) {
            if (! isset($partsValueToCompareWith[$i])
                || $partsValue[$i] != $partsValueToCompareWith[$i]) {

                return implode($delimiter, $segments);
            }

            $segments[] = $partsValue[$i];
        }
    }

    public function getName()
    {
        return 'app_extension';
    }
}

