<?php
/**
 * ezcpoAnnotationRelation
 *
 * @package Annotation
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class ezcpoAnnotationRelation extends ezcpoAnnotationBase
{
    /**
     * The properties for a one to many relation.
     *
     * @type array<string>
     * @var array $properties
     */
    protected $properties = array(
        "class"    =>  "",
        "from"     =>  "",
        "to"       =>  "",
        "cascade"  =>  false,
    );
    
    /**
     * Sets the property value.
     *
     * @param string $name
     * @param string $value
     * @throws ezcBasePropertyPermissionException
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case "class":
            case "from":
            case "to":
                $this->properties[$name] = $value;
                break;

            case "cascade":
                $this->properties[$name] = ( $value === "true" );
                break;

            default:
                parent::__set( $name, $value );
                break;
        }
    }
}