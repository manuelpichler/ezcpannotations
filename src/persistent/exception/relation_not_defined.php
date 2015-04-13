<?php
/**
 * ezcPersistentRelationNotDefinedException
 *
 * @package PersistentObject
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcPersistentRelationNotDefinedException extends ezcPersistentObjectException
{

    /**
     * Constructs a new ezcPersistentRelationInvalidException for the given
     * relation class $class.
     *
     * @param string $className
     */
    public function __construct( $className )
    {
        parent::__construct( "No relation defined for class '{$className}'." );
    }
}