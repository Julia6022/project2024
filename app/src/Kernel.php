<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Symfony Contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Class Kernel.
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
