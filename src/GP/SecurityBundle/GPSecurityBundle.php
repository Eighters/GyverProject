<?php

namespace GP\SecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GPSecurityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

