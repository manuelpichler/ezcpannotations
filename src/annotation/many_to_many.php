<?php
/**
 * ezcpoAnnotationManyToMany
 *
 * @package Annotation
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoAnnotationManyToMany extends ezcpoAnnotationRelation
{   
    /**
     * Visitor method.
     *
     * @param ezcpoAnnotationVisitor $visitor
     */
    public function visit( ezcpoAnnotationVisitor $visitor )
    {
        $visitor->visitAnnotationManyToMany( $this );
    }

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
            case "table":
            case "columns":
                $this->properties[$name] = $value;
                break;
                
            case "cascade":
                $this->properties[$name] = false;
                break;

            default:
                parent::__set( $name, $value );
                break;
        }
    }

    /**
     * Adds additional properties for the many to many relation.
     *
     * @return void
     */
    protected function init()
    {
        // Add many to many properties
        $this->properties["table"]   = "";
        $this->properties["columns"] = "";
    }
}