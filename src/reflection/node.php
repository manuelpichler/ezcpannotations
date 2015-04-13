<?php
/**
 * ezcpoReflectionNode
 *
 * @package Reflection
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
interface ezcpoReflectionNode
{
    function visit( ezcpoReflectionVisitor $visitor );
}