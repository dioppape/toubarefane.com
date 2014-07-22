<?php

namespace Toubarefane\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ToubarefaneUserBundle extends Bundle
{
    public function getParent()
  {
    return 'FOSUserBundle';
  }
}
