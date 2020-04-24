<?php


namespace App\Repository\Facade;

use App\Repository\Contract\IContract;

abstract class DefaultRepository implements IContract
{
    use DefaultFunctions;
}
